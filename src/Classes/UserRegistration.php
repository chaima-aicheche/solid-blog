<?php

namespace App\Classes;
use App\Class\Crud;

use App\Interfaces\RegistrationInterface;

class UserRegistration implements RegistrationInterface
{
    private $crud;

    public function __construct(Crud $crud)
    {
        $this->crud = $crud;
    }

    public function register($email, $password, $confirmPassword, $firstname, $lastname)
    {
       
        $data = [
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'firstname' => $firstname,
            'lastname' => $lastname,
        ];

        $userId = $this->crud->Create($data);

        
    }
}
