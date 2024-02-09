<?php

use App\Interfaces\User\UserInformationsInterface;

class UserManager 
{
    public function getUserInformations(UserInformationsInterface $userInformationsInterface, $key, $value){
        $userInformationsInterface->getUserInformations($key, $value);
    }
}

?>