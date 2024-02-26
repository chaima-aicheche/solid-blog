<?php

namespace App\Classes\Category;

use App\Class\Crud;
use App\Class\Category;
use App\Interfaces\Category\CategoryInformationsInterface;

class CategoryInformations extends Category implements CategoryInformationsInterface 
{

    public function __construct()
    {
        $this->crud = new Crud('category');
    }

    public function getCategoryInformations($id)
    {
        return $this->crud->GetByAttributes(['id' => $id]);
    }
}

?>



