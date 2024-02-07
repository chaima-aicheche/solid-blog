<?php

namespace App\Interfaces\Authentication;

interface LoginInterface 
{
    public function login($email, $password);
}
