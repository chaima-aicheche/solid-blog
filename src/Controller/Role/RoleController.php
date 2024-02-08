<?php 

namespace App\Controller\Role;

use App\Class\Controller;

class RoleController extends Controller

{
    public static function userRoleVerify($roleToVerify){

        $roles = explode(',',$_SESSION['user']['role']);

        $isRoleVerify = false;

        foreach($roles as $role){
            $role = trim($role, '[');
            $role = trim($role, ']');
            $role = str_replace('"', '', $role);
            $role = trim($role, " ");
            
            if ($roleToVerify == $role){
                $isRoleVerify = true;
            }
        }

        
        return $isRoleVerify;
    }
}