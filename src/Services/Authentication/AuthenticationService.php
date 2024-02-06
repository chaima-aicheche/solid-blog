<?php

namespace App\Services\Authentication;

use App\Class\Crud;
use App\Class\User;

class AuthenticationService {

    protected $crud;

    public function __construct()
    {
        $this->crud = new Crud('user');
    }

    public function Register($email, $password, $confirmPassword, $firstname, $lastname)
    {

        var_dump($this->crud->GetByAttributes(['id' => 1]));

        if (empty($email) || empty($password) || empty($confirmPassword) || empty($firstname) || empty($lastname)) {
            throw new \Exception("Tous les champs sont obligatoires");

            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \Exception("L'email n'est pas valide");

            return;
        }

        if ($this->crud->GetByAttributes(['email' => $email])) {
            throw new \Exception("L'email existe déjà");

            return;
        }

        if ($password === $confirmPassword) {
            
            $this->crud->Create(['email' => $email, 'password' => $password, 'firstname' => $firstname, 'lastname' => $lastname, 'role' =>json_encode(["ROLE_USER"])]);

            return;
        } else {
            throw new \Exception("Les mots de passe ne correspondent pas");

            return;
        }
    }
}