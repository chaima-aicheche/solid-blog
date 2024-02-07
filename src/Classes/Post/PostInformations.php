<?php

namespace App\Classes\Post;

use App\Class\Crud;
use App\Class\Post;
use App\Interfaces\Post\PostInformationsInterface;

class PostInformations extends Post implements PostInformationsInterface 
{

    public function __construct()
    {
        $this->crud = new Crud('post');
    }

    public function getPostInformations($id)
    {
        return $this->crud->GetByAttributes(['id' => $id]);
    }
}

?>