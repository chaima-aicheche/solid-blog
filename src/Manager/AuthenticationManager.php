<?php

namespace App\Manager;

use App\Interfaces\Authentication\LoginInterface;
use App\Interfaces\Authentication\RegistrationInterface;

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