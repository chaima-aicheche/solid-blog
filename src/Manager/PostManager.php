<?php

use App\Interfaces\PostInformationsInterface;

class PostManager 
{
    public function getPostInformation(PostInformationsInterface $postInformationsInterface, $id){
        $postInformationsInterface->getPostInformation($id);
    }
}

?>