<?php

namespace App\Router\Routes;

use App\Controller\Authentication\AuthenticationController;
use App\Router\Router;

class AuthenticationRoutes
{
    public function __construct(Router $router)
    {
        $router->get('/register', function () {
            try {
                $controller = new AuthenticationController();
                $controller->render('register');
            } catch (\Exception $e) {
                $controller->render('register', ['error' => $e->getMessage()]);
            }
        }, "register");
        
        $router->post('/register', function () {
            try {
                $controller = new AuthenticationController();
                $controller->manageRegister($_POST['email'], $_POST['password'], $_POST['password_confirm'], $_POST['firstname'], $_POST['lastname']);
                $controller->redirect('login');
            } catch (\Exception $e) {
                $controller->render('register', ['error' => $e->getMessage()]);
            }
        }, "register");
    }
}

?>