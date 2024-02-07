<?php

namespace App\Controller\Authentication;

use App\Authentication\UserRegistration;
use App\Class\Controller;
use App\Manager\AuthenticationManager;

class AuthenticationController extends Controller 
{
    public function manageRegister($email, $password, $confirmPassword, $firstname, $lastname){
        
        $authService = new UserRegistration();

        $test = new AuthenticationManager();
        
        $test->makeRegister($authService, $email,  $password, $confirmPassword, $firstname, $lastname);
    }
}

?>