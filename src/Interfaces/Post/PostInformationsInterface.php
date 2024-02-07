<?php

namespace App\Interfaces\Post;


interface PostInformationsInterface 
{
    public function getPostInformations($key, $value);
    public function getPaginatePosts($page);
}