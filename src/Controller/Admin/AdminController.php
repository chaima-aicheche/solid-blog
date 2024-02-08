<?php 

namespace App\Controller\Admin;

use App\Class\Controller;
use App\Class\Crud;
use App\Classes\Admin\AdminDashboard;
use App\Controller\Authentication\AuthenticationController;
use App\Controller\Role\RoleController;
use App\Manager\Admin\AdminManager;

class AdminController extends Controller
{
    public function admin($action = 'list', $entity = 'user', $id = null)
    {
        if (AuthenticationController::getUserSession() === null || !RoleController::userRoleVerify('ROLE_ADMIN')) {
            $this->redirect('home');

            return;
        }

        $action = $action . 'Admin';

        if (method_exists($this, $action)) {
            $this->$action($entity, $id);
        } else {
            throw new \Exception("L'action demandée n'existe pas");
        }
    }

    public function editAdmin($entity, $id)
    {
        $adminDashboard = new AdminDashboard();

        $adminManager = new AdminManager();

        $adminManager->editAdmin($adminDashboard,$entity, $id);

        $this->redirect('admin', ['entity' => strtolower($entity), 'action' => 'list']);
    }
}