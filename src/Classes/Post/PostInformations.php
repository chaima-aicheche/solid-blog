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

    public function getPostInformations($key, $value)
    {
        return $this->crud->GetByAttributes([$key => $value]);
    }

    public function getPaginatePosts($page)
    {
        return $this->crud->GetAllPaginate($page);
    }
}

?>