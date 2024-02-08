<?php

namespace App\Controller\Authentication;

use App\Authentication\UserLogin;
use App\Authentication\UserRegistration;
use App\Class\Controller;
use App\Manager\Authentication\AuthenticationManager;
use App\Class\Crud;

class AuthenticationController extends Controller 
{
    private $crud;

    public function __construct()
    {
        
        $this->crud = new Crud('user'); 
    }

    public function manageRegister($email, $password, $confirmPassword, $firstname, $lastname)
    {
        $authService = new UserRegistration();
        $test = new AuthenticationManager();
        $test->makeRegister($authService, $email, $password, $confirmPassword, $firstname, $lastname);
    }

    public function manageLogin($email, $password)
    {

        if (empty($email) || empty($password)) {
            throw new \Exception("Tous les champs sont obligatoires");
            $this->redirect('login');
        
            return;
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \Exception("L'email n'est pas valide");
            $this->redirect('login');
        
            return;
        }

        $authService = new UserLogin($this->crud); 

        $isLoggedIn = $authService->login($email, $password);

        if ($isLoggedIn) {
            $this->redirect('home');
        } else {
            throw new \Exception("Les identifiants sont incorects");
            $this->redirect('login');
        
            return;
        }
    }

    public function manageLogout()
    {
        unset($_SESSION['user']);
        $this->redirect('home');
    }

    public static function getUserSession(){
        if (isset($_SESSION['user'])) {
            return $_SESSION['user'];
        } else {
            return null;
        }
    }
}

?>