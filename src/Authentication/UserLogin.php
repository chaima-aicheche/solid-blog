<?php

namespace App\Authentication;

use App\Class\Crud;
use App\Interfaces\Authentication\LoginInterface;

class UserLogin implements LoginInterface
{
    private $crud;

    public function __construct(Crud $crud)
    {
        $this->crud = $crud;
    }

    public function login($email, $password)
    {
       
        $user = $this->crud->GetByAttributes(['email' => $email]);

        if (!empty($user) && password_verify($password, $user[0]['password'])) {
            
            return true;
        } else {
           
            return false;
        }
    }
}
