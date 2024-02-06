<?php

namespace App\Class;

// DEPENDENCIES INVERSION PRINCIPLE

// Interface get BDD connection
interface DatabaseConnectionInterface{
    // Return instance of BDD connection
    public function connect();
}

// Return private $connection PDO instance for BDD 
class Database implements DatabaseConnectionInterface
{
    private static $connection;

    public function __construct()
    {
    }

    public function connect(){
        if (self::$connection){
            return self::$connection;
        }

        try {
            self::$connection = new \PDO('mysql:host=localhost;dbname=solid-blog;charset=utf8', 'root', '', [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_TIMEOUT => 90
            ]);
        } catch (\PDOException $e) {
            die('Erreur : ' . $e->getMessage());
        }
        return self::$connection;
    }

    public static function setConnection($connection)
    {
        self::$connection = $connection;
    }
}