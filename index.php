<?php

use App\Class\Controller;
use App\Controller\Authentication\AuthenticationController;
use App\Router\Router;
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
new PostRoutes($router);
// $router->get('/register', function () {
//     try {
//         $controller = new AuthenticationController();
//         $controller->render('register');
//     } catch (\Exception $e) {
//         $controller->render('register', ['error' => $e->getMessage()]);
//     }
// }, "register");

// $router->post('/register', function () {
//     try {
//         $controller = new AuthenticationController();
//         $controller->manageRegister($_POST['email'], $_POST['password'], $_POST['password_confirm'], $_POST['firstname'], $_POST['lastname']);
//         $controller->redirect('login');
//     } catch (\Exception $e) {
//         $controller->render('register', ['error' => $e->getMessage()]);
//     }
// }, "register");


$router->get('/login', function () {
    $controller = new AuthenticationController();
    $controller->render('login');
}, "login");

$router->post('/login', function () {
    try {
        $controller = new AuthenticationController();
        $controller->manageLogin($_POST['email'], $_POST['password']);
    } catch (\Exception $e) {
        $controller->render('login', ['error' => $e->getMessage()]);
    }
}, "login");



// User
$router->get('/profile', function () {
    $controller = new Controller();
    $controller->profile();
}, "profile");

// Post


// Admin
$router->get('/admin/:action/:entity', function ($action = 'list', $entity = 'user') {
    $controller = new Controller();
    $controller->admin($action, $entity);
}, "admin")->with('action', 'list')->with('entity', 'user|post|comment|category');

$router->get('/admin/:action/:entity/:id', function ($action = 'list', $entity = 'user', $id = null) {
    $controller = new Controller();
    $controller->admin($action, $entity, $id);
}, "admin-entity")->with('action', 'show')->with('entity', 'user|post|comment|category')->with('id', '[0-9]+');

$router->post('/admin/:action/:entity/:id', function ($action = 'list', $entity = 'user', $id = null) {
    $controller = new Controller();
    $controller->admin($action, $entity, $id);
}, "admin-entity")->with('action', 'edit|delete')->with('entity', 'user|post|comment|category')->with('id', '[0-9]+');


$router->run();
