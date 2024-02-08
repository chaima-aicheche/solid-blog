<?php

namespace App\Router\Routes;

use App\Controller\Admin\AdminController;
use App\Router\Router;

class AdminRoutes
{
    public function __construct(Router $router)
    {
       // Admin
        $router->get('/admin/:action/:entity', function ($action = 'list', $entity = 'user') {
            $controller = new AdminController();
            $controller->admin($action, $entity);
        }, "admin")->with('action', 'list')->with('entity', 'user|post|comment|category');

        $router->get('/admin/:action/:entity/:id', function ($action = 'list', $entity = 'user', $id = null) {
            $controller = new AdminController();
            $controller->admin($action, $entity, $id);
        }, "admin-entity")->with('action', 'show')->with('entity', 'user|post|comment|category')->with('id', '[0-9]+');

        $router->post('/admin/:action/:entity/:id', function ($action = 'list', $entity = 'user', $id = null) {
            $controller = new AdminController();
            $controller->admin($action, $entity, $id);
        }, "admin-entity")->with('action', 'edit|delete')->with('entity', 'user|post|comment|category')->with('id', '[0-9]+');
    }
}

?>