<?php

namespace App\Manager\Admin;

use App\Interfaces\Admin\AdminInterface;

class AdminManager 
{
    public function editAdmin(AdminInterface $adminInterface, $entity, $id)
    {
        $adminInterface->editAdmin($entity, $id);
    }
}