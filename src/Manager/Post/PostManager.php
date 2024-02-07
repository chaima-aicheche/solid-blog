<?php

namespace App\Manager\Post;

use App\Interfaces\Post\PostInformationsInterface;

class PostManager 
{
    public function getPostInformations(PostInformationsInterface $postInformationsInterface, $key, $value){
        return $postInformationsInterface->getPostInformations($key, $value);
    }

    public function getPaginatePosts(PostInformationsInterface $postInformationsInterface, $page){
        return $postInformationsInterface->getPaginatePosts($page);
    }
}

?>