<?php

/**
 * This is a Anax pagecontroller.
 *
 */
// Get environment & autoloader and the $app-object.
require __DIR__.'/config.php'; 

// Create services and inject into the app. 
$di  = new \Anax\DI\CDIFactoryDefault();

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

// Set configuration for theme
$app->theme->configure(ANAX_APP_PATH . 'config/theme-grid.php');

$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_me.php');

// Set url cleaner url links
$app->url->setUrlType(\Anax\Url\CUrl::URL_CLEAN);

// Set routing options
$app->router->add('', function() use ($app) {
	$app->theme->setTitle("Home");
	
	$me = $app->fileContent->get('me.md');
	$me = $app->textFilter->doFilter($me, 'shortcode, markdown');
    $byline = $app->fileContent->get('byline.md');
    $byline = $app->textFilter->doFilter($byline, 'shortcode, markdown');
    $img1 = <<<EOD
		<img 
			class="img" 
			src="https://40.media.tumblr.com/tumblr_m85abqTAnt1rclw9bo1_500.png" 
			style="width:250px" 
			alt="Trip1"
			>
EOD;
    $img2 = <<<EOD
		<img 
			class="img" 
			src="https://41.media.tumblr.com/9e51e3879dde770f492ad9f37eb1b202/tumblr_mrkucqOp8v1se7bvho2_500.png" 
			style="width:250px" 
			alt="Trip2"
			>
EOD;
    $img3 = <<<EOD
		<img 
			class="img" 
			src="http://cdn.shopify.com/s/files/1/0228/9021/products/RWBY-first_0661be4a-11b7-48a1-a8a8-e147313b010f.jpg?v=1377902942" 
			style="width:250px" 
			alt="Trip2"
			>
EOD;
    $mmos = <<<EOD
		<h5>My Top MMORPGs</h5>
		<img class="img" src="http://i40.tinypic.com/2cmnix0.jpg" style="width:250px" alt="FFXIV">
		</br>
		<img class="img" src="http://hypeup.net/engine/images/uploads/489/star-wars-the-old-republic-logo.jpg" style="width:250px" alt="STWOR">
		</br>
		<img class="img" src="		http://www.gamer.ru/system/attached_images/images/000/653/111/original/logo-family-hearthstone.png" style="width:250px" alt="HearthStone">
EOD;
	$ffxivChar = <<<EOD
		<a href="http://eu.finalfantasyxiv.com/lodestone/character/6700023/">
		<img class="img" src="http://img.finalfantasyxiv.com/t/24f8b35d60ade80123ce1c06bf5dd023f33ce143.png" style="width:200px" alt="FFXIV Lodestone">
		</a>
EOD;
	$htmlphp = <<<EOD
		<a href="http://www.student.bth.se/~phan13/htmlphp/Kmom7-10/me.php">
		<img class="img" src="http://www.student.bth.se/~phan13/oophp/webroot/img.php?src=me-slide/me-4.jpg" style="width:200px" alt="HTMLPHP">
		</a>
		<p style='color:black'>HTML-PHP</p>		
EOD;
	$oophp = <<<EOD
		<a href="http://www.student.bth.se/~phan13/oophp/webroot/me.php">
		<img class="img" src="http://www.student.bth.se/~phan13/oophp/webroot/img.php?src=me-slide/me-2.jpg" style="width:200px" alt="OOPHP">
		</a>
		<p style='color:black'>OO-PHP</p>
EOD;
	$MAL = <<<EOD
		<a href="http://myanimelist.net/animelist/Sarono">
			<p style='color:blue'>MyAnimeList</p>
		</a>
		<a href="http://myanimelist.net/mangalist/Sarono">
			<p style='color:red'>MyMangaList</p>
		</a>
EOD;
	$app->views->add('me/page', [
        'content' => $me,
        'byline' => $byline
	])
			   ->addString('<img class="img" src="img/me/me-2.jpg" alt="Picture">','flash')
			   ->addString($mmos,'sidebar')
			   ->addString($img1,'triptych-1')
   			   ->addString($img2,'triptych-2')
			   ->addString($img3,'triptych-3')
			   ->addString($ffxivChar, 'footer-col-1')
               ->addString($htmlphp, 'footer-col-2')
               ->addString($oophp, 'footer-col-3')
               ->addString($MAL, 'footer-col-4')
			   ;
});

$app->router->add('reports', function() use ($app) {
 
    $app->theme->setTitle("Reports");

    $content = $app->fileContent->get('reports.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');
 
    $byline = $app->fileContent->get('byline.md');
    $byline = $app->textFilter->doFilter($byline, 'shortcode, markdown');
 
    $app->views->add('me/page', [
        'content' => $content,
        'byline' => $byline,
    ]);
 
});

$app->router->add('kmom01', function() use ($app) {
    $app->theme->setTitle("Kmom01 Rapport");
    
    $content = $app->fileContent->get('kmom01.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');
    
    $byline = $app->fileContent->get('byline.md');
    $byline = $app->textFilter->doFilter($byline, 'shortcode, markdown');
    
    $app->views->add('me/page', [
        'content' => $content,
        'byline' => $byline,
    ]);
    
     $app->dispatcher->forward([
        'controller' => 'comment',
        'action' => 'view',
        'params' => ['kmom01'],
    ]);
    
    $app->views->add('comment/form', [
        'mail' => null,
        'web' => null,
        'name' => null,
        'comment' => null,
        'output' => null,
        'key' => 'kmom01',
    ]);
});

$app->router->add('kmom02', function() use ($app) {
    $app->theme->setTitle("kmom02");

    $content = $app->fileContent->get('kmom02.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');

    $byline = $app->fileContent->get('byline.md');
    $byline = $app->textFilter->doFilter($byline, 'shortcode, markdown');

    $app->views->add('me/page', [
        'content' => $content,
        'byline' => $byline,
    ]);

    $app->dispatcher->forward([
        'controller' => 'comment',
        'action' => 'view',
        'params' => ['kmom02'],
    ]);

    $app->views->add('comment/form', [
        'mail' => null,
        'web' => null,
        'name' => null,
        'comment' => null,
        'output' => null,
        'key' => 'kmom02',
    ]);
});

$app->router->add('kmom03', function() use ($app) {
    $app->theme->setTitle("kmom03");

    $content = $app->fileContent->get('kmom03.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');

    $byline = $app->fileContent->get('byline.md');
    $byline = $app->textFilter->doFilter($byline, 'shortcode, markdown');

    $app->views->add('me/page', [
        'content' => $content,
        'byline' => $byline,
    ]);

    $app->dispatcher->forward([
        'controller' => 'comment',
        'action' => 'view',
        'params' => ['kmom03'],
    ]);

    $app->views->add('comment/form', [
        'mail' => null,
        'web' => null,
        'name' => null,
        'comment' => null,
        'output' => null,
        'key' => 'kmom03',
    ]);
});

$app->router->add('kmom04', function() use ($app) {
    $app->theme->setTitle("kmom04");

    $content = $app->fileContent->get('kmom04.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');

    $byline = $app->fileContent->get('byline.md');
    $byline = $app->textFilter->doFilter($byline, 'shortcode, markdown');

    $app->views->add('me/page', [
        'content' => $content,
        'byline' => $byline,
    ]);

    $app->dispatcher->forward([
        'controller' => 'comment',
        'action' => 'view',
        'params' => ['kmom04'],
    ]);

    $app->views->add('comment/form', [
        'mail' => null,
        'web' => null,
        'name' => null,
        'comment' => null,
        'output' => null,
        'key' => 'kmom04',
    ]);
});

$app->router->add('source', function() use ($app) {
 
    $app->theme->addStylesheet('css/source.css');
    $app->theme->setTitle("Källkod");
 
    $source = new \Mos\Source\CSource([
        'secure_dir' => '..', 
        'base_dir' => '..', 
        'add_ignore' => ['.htaccess'],
    ]);
 
    $app->views->add('me/source', [
        'content' => $source->View(),
    ]);
});

$app->router->add('theme/grid', function() use ($app) {
 
    $app->theme->setTitle("Grid");
 
    $app->theme->addStylesheet('css/gridview.css');
    
    $app->views->addString('flash', 'flash')
               ->addString('featured-1', 'featured-1')
               ->addString('featured-2', 'featured-2')
               ->addString('featured-3', 'featured-3')
               ->addString('main', 'main')
               ->addString('sidebar', 'sidebar')
               ->addString('triptych-1', 'triptych-1')
               ->addString('triptych-2', 'triptych-2')
               ->addString('triptych-3', 'triptych-3')
               ->addString('footer-col-1', 'footer-col-1')
               ->addString('footer-col-2', 'footer-col-2')
               ->addString('footer-col-3', 'footer-col-3')
               ->addString('footer-col-4', 'footer-col-4');

    $app->views->add('me/page', [ 
        'content' => 'This is featured-1', 
        ], 'featured-1'); 

    $app->views->add('me/page', [ 
        'content' => 'This is featured-2', 
        ], 'featured-2'); 

    $app->views->add('me/page', [ 
        'content' => 'This is featured-3', 
        ], 'featured-3'); 

    $app->views->add('me/page', [ 
        'content' => '<h1>Welcome to Main</h1>', 
        ], 'main'); 

    $app->views->add('me/page', [ 
        'content' => '<h2>Sidebar</h2>', 
    ], 'sidebar'); 

    $app->views->add('me/page', [ 
        'content' => 'This is footer-col-1', 
    ], 'footer-col-1'); 

    $app->views->add('me/page', [ 
        'content' => 'This is footer-col-2', 
    ], 'footer-col-2'); 

    $app->views->add('me/page', [ 
        'content' => 'This is footer-col-3', 
    ], 'footer-col-3'); 

    $app->views->add('me/page', [ 
        'content' => 'This is footer-col-4', 
    ], 'footer-col-4');
});

$app->router->add('theme/regions', function() use ($app) {
 
    $app->theme->setTitle("Regions");

    $app->theme->addStylesheet('css/regionview.css');
	
    $app->views->addString('flash', 'flash')
               ->addString('featured-1', 'featured-1')
               ->addString('featured-2', 'featured-2')
               ->addString('featured-3', 'featured-3')
               ->addString('main', 'main')
               ->addString('sidebar', 'sidebar')
               ->addString('triptych-1', 'triptych-1')
               ->addString('triptych-2', 'triptych-2')
               ->addString('triptych-3', 'triptych-3')
               ->addString('footer-col-1', 'footer-col-1')
               ->addString('footer-col-2', 'footer-col-2')
               ->addString('footer-col-3', 'footer-col-3')
               ->addString('footer-col-4', 'footer-col-4');
 
});

$app->router->add('theme/typography', function() use ($app) {
 
    $app->theme->setTitle("Typography");
    $content = $app->fileContent->get('typography.html');

    $app->views->addString($content, 'main')
               ->addString($content, 'sidebar');
 
});

$app->router->add('theme/font', function() use ($app) {
 
    $app->theme->setTitle("Font Awesome");
 
    $app->views->addString('<i class="fa fa-arrow-circle-o-right"></i>', 'featured-2')
               ->addString('<i class="fa fa-arrow-circle-o-right"></i>', 'featured-3')
               ->addString('<i class="fa fa-child fa-5x"></i>', 'main')
               ->addString('<p><i class="fa fa-coffee fa-lg"></i> fa-coffee</p>
<p><i class="fa fa-home fa-2x"></i> fa-home</p>
<p><i class="fa fa-key fa-3x"></i> fa-key</p>
<p><i class="fa fa-rocket fa-4x"></i> fa-rocket</p>
<p><i class="fa fa-camera-retro fa-5x"></i> fa-camera-retro</p>', 'sidebar');
 
});

$app->router->add('users', function() use ($app) {

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

$app->router->add('setupcomments', function() use ($app) {
	
	

});

$app->router->handle();

$app->theme->addStylesheet('css/comment.css');

$app->theme->render();