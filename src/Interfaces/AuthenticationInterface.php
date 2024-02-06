<?php

namespace App\Interfaces;

interface RegistrationInterface 
{
    public function register($email, $password, $confirmPassword, $firstname, $lastname);
}

interface LoginInterface 
{
    public function login($email, $password);
}
