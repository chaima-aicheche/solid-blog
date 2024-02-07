<?php

use App\Interfaces\User\UserInformationsInterface;

class UserManager 
{
    public function getUserInformations(UserInformationsInterface $userInformationsInterface, $id){
        $userInformationsInterface->getUserInformations($id);
    }
}

?>