<?php

namespace App\Router\Routes;

use App\Class\Controller;
use App\Controller\Post\PostController;
use App\Router\Router;

class PostRoutes 
{
    public function __construct(Router $router)
    {
        $router->get('/posts/:page', function ($page = 1) {
            $controller = new PostController();
            $controller->getPaginatePosts($page);
        }, "posts")->with('page', '[0-9]+');
        
        $router->get('/post/:id', function ($id) {
            $controller = new PostController();
            $controller->viewPost($id);
        }, "post")->with('id', '[0-9]+');
        
        $router->post('/comments/:post_id', function ($post_id) {
            try {
                $controller = new Controller();
                $controller->createComment($_POST['content'], $post_id);
            } catch (\Exception $e) {
                $postController = new PostController();
                $postController->viewPost($post_id, ['error' => $e->getMessage()]);
            }
        }, "add_comment")->with('post_id', '[0-9]+');
    }
}