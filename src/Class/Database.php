<?php

namespace App\Class;

use App\Interfaces\Database\DatabaseInterface;

// Return private $connection PDO instance for BDD 
class Database implements DatabaseInterface
{
    private static $connection;
    private static $env;


    public function __construct()
    {
        $envFile = parse_ini_file('.env.example');
        self::$env = $envFile;
    }

    public static function connect(){
        if (self::$connection){
            return self::$connection;
        }

        try {
            self::$connection = new \PDO('mysql:host='.self::$env['DB_HOST'].';dbname='.self::$env['DB_NAME'].';charset='.self::$env['DB_CHARSET'].'', self::$env['DB_USERNAME'], self::$env['DB_PASSWORD'], [
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