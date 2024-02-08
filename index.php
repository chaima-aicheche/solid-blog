<?php

use App\Class\Controller;
use App\Controller\Authentication\AuthenticationController;
use App\Router\Router;
use App\Router\Routes\AdminRoutes;
use App\Router\Routes\AuthenticationRoutes;
use App\Router\Routes\PostRoutes;

require_once 'vendor/autoload.php';

session_start();

$router = new Router($_SERVER['REQUEST_URI']);

$router->setBasePath('/solid-blog/');

$router->get('/', function () {
    $controller = new Controller();
    $controller->render('index');
}, "home");

// Authentication
new AuthenticationRoutes($router);
// Posts
new PostRoutes($router);
// Admin
new AdminRoutes($router);




// User
$router->get('/profile', function () {
    $controller = new Controller();
    $controller->profile();
}, "profile");


$router->run();
