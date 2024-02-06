<?php

namespace App\Interfaces;

interface AuthenticationInterface 
{
    public function Register($email, $password, $confirmPassword, $firstname, $lastname);
    public function Login($email, $password);
}