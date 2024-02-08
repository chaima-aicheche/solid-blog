<?php

namespace App\Classes\Admin;

use App\Class\Crud;
use App\Class\User;
use App\Interfaces\Admin\AdminInterface;

class AdminDashboard extends User implements AdminInterface
{
    public function editAdmin($entity, $id)
    {
        $entityName = $entity;
        $entity = ucfirst($entity);
        $className = "App\\Class\\$entity";

        $class = new $className();
        $instance = $class->findOneById($id);
        $data = array();
        foreach ($_POST as $key => $value) {
            $key = explode('_', $key);
            $key = array_map(function ($word) {
                return ucfirst($word);
            }, $key);
            $key = implode('', $key);
            $value = htmlspecialchars($value);
            $getter = 'get' . $key;
            if (method_exists($instance, $getter) && is_array($instance->$getter())) {
                $value = explode(', ', $value);
            }
            if (is_string($value) && strtotime($value)) {
                $value = (new \DateTime())->setTimestamp(strtotime($value));
            }
            if ($key === 'User' || $key === 'Post' || $key === 'Comments' || $key === 'Category') {
                continue;
            }
            $setter = 'set' . $key;
            $data[$key] = $value;
            
            if (method_exists($instance, $setter) && null !== $instance->$getter()) {
                $instance->$setter($value);
            }
        }

        $crud = new Crud(strtolower($entityName));

        $crud->Update($data, $id);
    }
}