<?php

use App\Interfaces\Post\PostInformationsInterface;

class PostManager 
{
    public function getPostInformations(PostInformationsInterface $postInformationsInterface, $key, $value){
        $postInformationsInterface->getPostInformations($key, $value);
    }
}

?>