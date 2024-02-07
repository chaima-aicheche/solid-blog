<?php

namespace App\Manager\Database;

use App\Interfaces\Database\DatabaseInterface;

class DatabaseManager 
{
    public function makeConnection(DatabaseInterface $databaseInterface){
        return $databaseInterface::connect();
    }
}

?>