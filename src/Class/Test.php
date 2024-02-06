<?php

namespace App\Class;

class Test extends Crud {

    private $table= 'user';
    protected $crud;

    public function __construct()
    {
        $this->crud = new Crud($this->table);
    }

    public function getAllUsers(){
        return $this->crud->GetAll();
    }
}