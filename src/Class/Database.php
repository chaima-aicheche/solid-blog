<?php

namespace App\Class;


// Return private $connection PDO instance for BDD 
class Database
{
    private static $connection;

    public function __construct()
    {
    }

    public static function connect(){
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