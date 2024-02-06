<?php

namespace App\Classes;

use App\Interfaces\RegistrationInterface;
use App\Class\Database;

class UserRegistration implements RegistrationInterface
{
    private $dbConnection;

    public function __construct()
    {
        $this->dbConnection = Database::connect();
    }

    public function register($email, $password, $confirmPassword, $firstname, $lastname)
    {
        
        $sql = "INSERT INTO utilisateurs (email, password, firstname, lastname) VALUES (?, ?, ?, ?)";
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $query = $this->dbConnection->prepare($sql);
        $query->execute([$email, $hashedPassword, $firstname, $lastname]);
        
        
    }
}
