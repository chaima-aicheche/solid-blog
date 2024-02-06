<?php

namespace App\Classes;

use App\Interfaces\LoginInterface;
use App\Class\Database;

class UserLogin implements LoginInterface
{
    private $dbConnection;

    public function __construct()
    {
        $this->dbConnection = Database::connect();
    }

    public function login($email, $password)
    {
       
        $sql = "SELECT * FROM utilisateurs WHERE email = ?";
        
        $query = $this->dbConnection->prepare($sql);
        $query->execute([$email]);

        $user = $query->fetch(\PDO::FETCH_ASSOC);

        if ($user !== false && password_verify($password, $user['password'])) {
         
            return true;
        } else {
           
            return false;
        }
    }
}
