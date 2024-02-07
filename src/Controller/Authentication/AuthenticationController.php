<?php

namespace App\Controller\Authentication;

use App\Authentication\UserLogin;
use App\Authentication\UserRegistration;
use App\Class\Controller;
use App\Manager\AuthenticationManager;
use App\Class\Crud;

class AuthenticationController extends Controller 
{
    private $crud;

    public function __construct()
    {
        
        $this->crud = new Crud('users'); 
    }

    public function manageRegister($email, $password, $confirmPassword, $firstname, $lastname)
    {
        $authService = new UserRegistration();
        $test = new AuthenticationManager();
        $test->makeRegister($authService, $email, $password, $confirmPassword, $firstname, $lastname);
    }

    public function manageLogin($email, $password)
    {
        $authService = new UserLogin($this->crud); 
        $isLoggedIn = $authService->login($email, $password);

        if ($isLoggedIn) {
            $this->redirect('home');
        }
    }
}



/*class AuthenticationController extends Controller 
{
    public function manageRegister($email, $password, $confirmPassword, $firstname, $lastname){
        
        $authService = new UserRegistration();

        $test = new AuthenticationManager();
        
        $test->makeRegister($authService, $email,  $password, $confirmPassword, $firstname, $lastname);
    }

   
}*/



?>