<?php

namespace Anax\Users;
 
/**
 * A controller for users and admin related events.
 *
 */
class UsersController implements \Anax\DI\IInjectionAware {
    
    use \Anax\DI\TInjectable;

    /**
     * Initialize the controller.
     *
     * @return void
     */
    public function initialize() {
        $this->users = new \Anax\Users\User();
        $this->users->setDI($this->di);
        date_default_timezone_set('Europe/London');
    }

    /**
     * List all users.
     *
     * @return void
     */
    public function listAction() {
        $all = $this->users->findAll();
     
        $this->theme->setTitle("List all users");
        $this->views->add('users/list-all', [
            'users' => $all,
            'title' => "View all users",
        ]);
    }

    /**
     * List user with id.
     *
     * @param int $id of user to display
     *
     * @return void
     */
    public function idAction($id = null) {
        $user = $this->users->find($id);
     
        $this->theme->setTitle("View user with id");
        $this->views->add('users/view', [
            'user' => $user,
            'title' => "View user with id $id",
        ]);
    }

    /**
     * Reset and setup database tabel with default users.
     *
     * @return void
     */
    public function setupAction() {
 
        $this->theme->setTitle("Reset and setup database with default users.");

        $table = [
                'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
                'acronym' => ['varchar(20)', 'unique', 'not null'],
                'email' => ['varchar(80)'],
                'name' => ['varchar(80)'],
                'password' => ['varchar(255)'],
                'created' => ['datetime'],
                'updated' => ['datetime'],
                'deleted' => ['datetime'],
                'active' => ['datetime'],
        ];

           $res = $this->users->setupTable($table);

        // Add some users 
        $now = date(DATE_RFC2822);
 
        $this->users->create([
            'acronym' => 'admin',
            'email' => 'admin@dbwebb.se',
            'name' => 'Administrator',
            'password' => password_hash('admin', PASSWORD_DEFAULT),
            'created' => $now,
            'active' => $now,
        ]);

        $this->users->create([
            'acronym' => 'doe',
            'email' => 'doe@dbwebb.se',
            'name' => 'John/Jane Doe',
            'password' => password_hash('doe', PASSWORD_DEFAULT),
            'created' => $now,
            'active' => $now,
        ]);
     
        $url = $this->url->create('users/list');
        $this->response->redirect($url);
    }

    /**
     * Add new user.
     *
     * @param string $acronym of user to add.
     *
     * @return void
     */
    public function addAction($acronym = null) {
        
        if (!isset($acronym)) {
            $form = $this->form->create([], [
                'acronym' => [
                  'type'        => 'text',
                  'label'       => 'Acronym: ',
                  'required'    => true,
                  'validation'  => ['not_empty'],
                ],
                'submit' => [
                    'type'      => 'submit',
                    'callback'  => function($form) {
                        $form->AddOutput("<p><i>Form was submitted.</i></p>");
                        $form->AddOutput("<p><b>Acronym: " . $form->Value('acronym') . "</b></p>");
                        $form->saveInSession = true;
                        return true;
                    }
                ],
            ]);

            // Prepare the page content
            $this->views->add('users/view-default', [
                'title' => "Add a user",
                'main' => $form->getHTML(),
            ]);
            $this->theme->setVariable('title', "Add a user");

            // Check the status of the form
            $status = $form->check();
             
            if ($status === true) {

                // What to do if the form was submitted?
                $form->AddOutput("<p><i>Form submitted.</i></p>");

                // Get data from and and unset the session variable
                $acronym = $_SESSION['form-save']['acronym']['value'];
                session_unset($_SESSION['form-save']);

                // Route to prefered controller function
                $url = $this->url->create('users/add/' . $acronym);
                $this->response->redirect($url);
             
            } else if ($status === false) {     

                // What to do when form could not be processed?
                $form->AddOutput("<p><i>Form submitted but did not checkout.</i></p>");

            }
        };

        // Create and display new user if acronym is present. 
        if (isset($acronym)) {         
            $now = date(DATE_RFC2822);     
            $this->users->save([
                'acronym' => $acronym,
                'email' => $acronym . '@mail.se',
                'name' => 'Mr/Mrs ' . $acronym,
                'password' => password_hash($acronym, PASSWORD_DEFAULT),
                'created' => $now,
                'active' => $now,
            ]);
            $url = $this->url->create('users/list');
            $this->response->redirect($url);
        }     
    }

    /**
     * Update user.
     *
     * @param integer $id of user to update.
     *
     * @return void
     */
    public function updateAction($id = null) {        
        if (!isset($id)) {
            die("Missing id");
        }

        $user = $this->users->find($id);

        $form = $this->form->create([], [
            'acronym' => [
              'type'        => 'text',
              'label'       => 'Acronym: ',
              'required'    => true,
              'validation'  => ['not_empty'],
              'value'        => $user->acronym,
            ],
            'name' => [
              'type'        => 'text',
              'label'       => 'Name: ',
              'required'    => true,
              'validation'  => ['not_empty'],
              'value'        => $user->name,
            ],
            'email' => [
              'type'        => 'text',
              'label'       => 'Email: ',
              'required'    => true,
              'validation'  => ['not_empty', 'email_adress'],
              'value'        => $user->email,
            ],
            'submit' => [
                'type'      => 'submit',
                'callback'  => function($form) {
                    $form->AddOutput("<p><i>Form was submitted.</i></p>");
                    $form->AddOutput("<p><b>Acronym: " . $form->Value('acronym') . "</b></p>");
                    $form->saveInSession = true;
                    return true;
                }
            ],
        ]);

        // Check the status of the form
        $status = $form->check();
         
        if ($status === true) {

            // What to do if the form was submitted?
            $form->AddOutput("<p><i>Form submitted.</i></p>");

            // Collect data and unset the session variable
            $updated_user['id'] = $id;
            $updated_user['acronym'] = $_SESSION['form-save']['acronym']['value'];
            $updated_user['name'] = $_SESSION['form-save']['name']['value'];
            $updated_user['email'] = $_SESSION['form-save']['email']['value'];
            session_unset($_SESSION['form-save']);

            // Save updated user data
            $res = $this->users->save($updated_user);          
            if($res) { 
                $form->AddOutput("<p><i>User updated successfully.</i></p>");
                $url = $this->url->create('users/list');
                $this->response->redirect($url);
            }
         
        } else if ($status === false) {     

            // What to do when form could not be processed?
            $form->AddOutput("<p><i>Form submitted but did not checkout.</i></p>");

        }

        // Prepare the page content
        $this->views->add('users/view-default', [
            'title' => "Update user",
            'main' => $form->getHTML(),
        ]);
    }


    /**
     * Delete user.
     *
     * @param integer $id of user to delete.
     *
     * @return void
     */
    public function deleteAction($id = null) {
        if (!isset($id)) {
            die("Missing id");
        }
     
        $res = $this->users->delete($id);
     
        $url = $this->url->create('users/list');
        $this->response->redirect($url);
    }

    /**
     * Delete (soft) user.
     *
     * @param integer $id of user to delete.
     *
     * @return void
     */
    public function softDeleteAction($id = null) {
        if (!isset($id)) {
            die("Missing id");
        }
     
        $now = date(DATE_RFC2822);
     
        $user = $this->users->find($id);
     
        $user->deleted = $now;
        $user->save();
     
        $url = $this->url->create('users/list');
        $this->response->redirect($url);
    }

    /**
     * Undelete (soft) user.
     *
     * @param integer $id of user to undelete.
     *
     * @return void
     */
    public function softUndeleteAction($id = null) {
        if (!isset($id)) {
            die("Missing id");
        }
     
        $now = date(DATE_RFC2822);
     
        $user = $this->users->find($id);
     
        $user->deleted = null;
        $user->save();
     
        $url = $this->url->create('users/list');
        $this->response->redirect($url);
    }

    /**
     * Make user active.
     *
     * @param integer $id of user to activate.
     *
     * @return void
     */
    public function activateAction($id = null) {
        if (!isset($id)) {
            die("Missing id");
        }
     
        $now = date(DATE_RFC2822);
     
        $user = $this->users->find($id);
     
        $user->active = $now;
        $user->save();
     
        $url = $this->url->create('users/list');
        $this->response->redirect($url);
    }

    /**
     * Make user inactive.
     *
     * @param integer $id of user to deactivate.
     *
     * @return void
     */
    public function deactivateAction($id = null) {
        if (!isset($id)) {
            die("Missing id");
        }
     
        $now = date(DATE_RFC2822);
     
        $user = $this->users->find($id);
     
        $user->active = null;
        $user->save();
     
        $url = $this->url->create('users/list');
        $this->response->redirect($url);
    }

    /**
     * List all active and not deleted users.
     *
     * @return void
     */
    public function activeAction() {
        $all = $this->users->query()
            ->where('active IS NOT NULL')
            ->andWhere('deleted is NULL')
            ->execute();
     
        $this->theme->setTitle("Users that are active");
        $this->views->add('users/list-all', [
            'users' => $all,
            'title' => "Users that are active",
        ]);
    }

    /**
     * List all soft-deleted users.
     *
     * @return void
     */
    public function inactiveAction() {
        $all = $this->users->query()
            ->where('active is NULL')
            ->execute();
     
        $this->theme->setTitle("Users that are inactive");
        $this->views->add('users/list-all', [
            'users' => $all,
            'title' => "Users that are inactive",
        ]);
    }

        /**
     * List all soft-deleted users.
     *
     * @return void
     */
    public function trashAction() {
        $all = $this->users->query()
            ->where('deleted is NOT NULL')
            ->execute();
     
        $this->theme->setTitle("Users that are soft-deleted");
        $this->views->add('users/list-all', [
            'users' => $all,
            'title' => "Users that are soft-deleted",
        ]);
    }
 
} 