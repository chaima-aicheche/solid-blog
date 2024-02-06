<?php

namespace App\Manager;

use App\Interfaces\AuthenticationInterface;

class AuthenticationManager 
{
    public function makeLogin(AuthenticationInterface $authenticationInterface, $email, $password): void
    {
        $authenticationInterface->Login($email, $password);
    }

    public function makeRegister(AuthenticationInterface $authenticationInterface, $email, $password, $confirmPassword, $firstname, $lastname){
        $authenticationInterface->Register($email, $password, $confirmPassword, $firstname, $lastname);
    }
}