<?php

use App\Interfaces\Category\CategoryInformationsInterface;

class CategoryManager 
{
    public function getCategoryInformations(CategoryInformationsInterface $categoryInformationsInterface, $key, $value){
        $categoryInformationsInterface->getCategoryInformations($key, $value);
    }
}

?>