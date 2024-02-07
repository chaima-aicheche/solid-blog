<?php

namespace App\Authentication;

use App\Class\Crud;
use App\Interfaces\Authentication\RegistrationInterface;

class UserRegistration implements RegistrationInterface
{

    protected $crud;

    public function __construct()
    {
        $this->crud = new Crud('user');
    }

    public function register($email, $password, $confirmPassword, $firstname, $lastname)
    {
        
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

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $this->crud->Create(['email' => $email, 'password' => $hashedPassword, 'firstname' => $firstname, 'lastname' => $lastname, 'role' =>json_encode(["ROLE_USER"])]);

            return;
        } else {
            throw new \Exception("Les mots de passe ne correspondent pas");

            return;
        }
    }
}
