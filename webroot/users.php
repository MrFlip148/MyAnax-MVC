<?php 
/**
 * This is a Anax pagecontroller.
 *
 */

// Get environment & autoloader and the $app-object.
require __DIR__.'/config.php'; 

// Create services and inject into the app. 
$di = new \Anax\DI\CDIFactoryDefault();

$di->setShared('db', function() {
    $db = new \Mos\Database\CDatabaseBasic();
    $db->setOptions(require ANAX_APP_PATH . 'config/config_sqlite.php');
    $db->connect();
    return $db;
});

$di->set('form', '\Mos\HTMLForm\CForm');

$di->set('UsersController', function() use ($di) {
    $controller = new \Anax\Users\UsersController();
    $controller->setDI($di);
    return $controller;
});

$di->set('CommentController', function() use ($di) {
    $controller = new \Anax\Comment\CommentDbController();
    $controller->setDI($di);
    return $controller;
});

$app = new \Anax\Kernel\CAnax($di);

// Start session
$app->session;

// Add routes ------------------------------------------------

$app->router->add('', function() use ($app) {

    $app->theme->setTitle("Users");

    $app->views->add('me/page', [
        'content' => "<h1 style='border: 0;'>Welcome to the user database!</h1>",
    ]);

    $app->views->add('comment/form', [
        'mail' => null,
        'web' => null,
        'name' => null,
        'comment' => null,
        'output' => null,
        'key' => 'user',
        ]);
        
        $app->dispatcher->forward([
        'controller' => 'comment',
        'action' => 'view',
        ]);
});

// Finish off the page ----------------------------------------------

// Run the route handler
$app->router->handle();

// Set configuration for theme
$app->theme->configure(ANAX_APP_PATH . 'config/theme-grid.php');

// Set the title of the page
$app->theme->setVariable('title', "PHPMVC v2 - User database");

// Add extra styling
$app->theme->addStylesheet('css/comment.css');

// Navigation
$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_user.php');

// Render the response using theme engine.
$app->theme->render();