<?php

namespace App\Authentication;

use App\Class\Crud;
use App\Interfaces\LoginInterface;

class UserLogin implements LoginInterface
{

    public function login($email, $password)
    {
        
        if ($email === '' && $password === 'motdepasse') {
           
            return true;
        } else {
         
            return false;
        }
    }
}
