<?php 

namespace App\Controller\Post;

use App\Class\Controller;
use App\Class\Crud;
use App\Class\Post;
use App\Classes\Post\PostInformations;
use App\Manager\Post\PostManager;

class PostController extends Controller 
{
    public function getPaginatePosts($page){

        $postInformations = new PostInformations();

        $postManager = new PostManager();

        $postCrud = new Crud('post');

        $postsNumber = $postCrud->GetAll();

        $posts = $postManager->getPaginatePosts($postInformations, $page);
        $pages = count($postsNumber) / 10;
        $this->render('posts', ['posts' => $posts, 'pages' => $pages]);
    }

    public function viewPost($id, $error = null){

        if (is_numeric($id) === false) {
            throw new \Exception("L'identifiant du post n'est pas valide");

            return;
        }

        $postInformations = new PostInformations();

        $postManager = new PostManager();

        $post = $postManager->getPostInformations($postInformations, 'id', $id);
        
        $this->render('post', ['post' => $post, 'error' => $error]);
    }
}

?>