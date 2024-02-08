<?php

namespace App\Manager\Authentication;

use App\Interfaces\Authentication\LoginInterface;
use App\Interfaces\Authentication\RegistrationInterface;
use App\Interfaces\Authentication\UserSessionInterface;

class AuthenticationManager 
{
    public function makeLogin(LoginInterface $authenticationInterface, $email, $password): void
    {
        $authenticationInterface->Login($email, $password);
    }

    public function makeRegister(RegistrationInterface $authenticationInterface, $email, $password, $confirmPassword, $firstname, $lastname){
        $authenticationInterface->Register($email, $password, $confirmPassword, $firstname, $lastname);
    }
}