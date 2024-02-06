<?php
namespace App\Classes;

use App\Interfaces\RegistrationInterface;

class UserRegistration implements RegistrationInterface
{
    public function register($email, $password, $confirmPassword, $firstname, $lastname)
    {
        
        if ($password === $confirmPassword) {
           
            return true;
        } else {
           
            return false;
        }
    }
}
