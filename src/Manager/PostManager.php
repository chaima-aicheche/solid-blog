<?php

use App\Interfaces\Post\PostInformationsInterface;

class PostManager 
{
    public function getPostInformations(PostInformationsInterface $postInformationsInterface, $id){
        $postInformationsInterface->getPostInformations($id);
    }
}

?>