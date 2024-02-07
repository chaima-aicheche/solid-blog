<?php

namespace App\Interfaces\Authentication;

interface RegistrationInterface 
{
    public function register($email, $password, $confirmPassword, $firstname, $lastname);
}