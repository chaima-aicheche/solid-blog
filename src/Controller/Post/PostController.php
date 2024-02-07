<?php 

namespace App\Controller\Post;

use App\Class\Controller;
use App\Classes\Post\PostInformations;
use App\Manager\Post\PostManager;

class PostController extends Controller 
{
    public function getPaginatePosts($page){

        $postInformations = new PostInformations();

        $postManager = new PostManager();

        $posts = $postManager->getPaginatePosts($postInformations, $page);
        $pages = count($posts) / 10;
        $this->render('posts', ['posts' => $posts, 'pages' => $pages]);
    }
}

?>