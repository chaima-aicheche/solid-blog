<?php

namespace App\Classes\User;

use App\Class\Crud;
use App\Class\User;
use App\Interfaces\User\UserInformationsInterface;

class UserInformations extends User implements UserInformationsInterface 
{

    public function __construct()
    {
        $this->crud = new Crud('user');
    }

    public function getUserInformations($key, $value)
    {
        return $this->crud->GetByAttributes([$key => $value]);
    }
}

?>