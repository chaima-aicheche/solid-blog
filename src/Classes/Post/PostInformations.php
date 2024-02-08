<?php

namespace App\Classes\Post;

use App\Class\Category;
use App\Class\Comment;
use App\Class\Crud;
use App\Class\Post;
use App\Class\User;
use App\Interfaces\Post\PostInformationsInterface;
use DateTime;

class PostInformations extends Post implements PostInformationsInterface 
{

    public function __construct()
    {
        $this->crud = new Crud('post');
    }

    public function getPostInformations($key, $value)
    {
        $post = $this->crud->GetByAttributes([$key => $value]);

        $this->setId($post[0]['id']);
        $this->setTitle($post[0]['title']);
        $this->setContent($post[0]['content']);
        $this->setCreatedAt($post[0]['created_at'] ? new DateTime($post[0]['created_at']) : null);
        $this->setUpdatedAt($post[0]['updated_at'] ? new DateTime($post[0]['updated_at']) : null);

        // Relations
        $postRelationsInformations = new PostRelationsInformations();
        // User
        $userPost = $postRelationsInformations->getUserPostInformations($post[0]['user_id']);
        $this->setUser($userPost);

        // Category
        $categoryPost = $postRelationsInformations->getCategoryPostInformations($post[0]['category_id']);
        $this->setCategory($categoryPost);

        // Comments
        $comments = $postRelationsInformations->getCommentsPostInformations($post[0]['id']);
        $this->setComments($comments);

        return $this;
    }

    public function getPaginatePosts($page)
    {
        $arrayPosts = $this->crud->GetAllPaginate($page);
        $results = [];
        foreach ($arrayPosts as $arrayPost) {
            $post = new Post();
            $post->setId($arrayPost['id']);
            $post->setTitle($arrayPost['title']);
            $post->setContent($arrayPost['content']);
            $post->setCreatedAt(new DateTime($arrayPost['created_at']));
            $post->setUpdatedAt($arrayPost['updated_at'] ? new DateTime($arrayPost['updated_at']) : null);
            $post->setUser((new User())->findOneById($arrayPost['user_id']));
            $post->setCategory((new Category())->findOneById($arrayPost['category_id']));
            $post->setComments((new Comment())->findByPost($arrayPost['id']));
            $results[] = $post;
        }
        return $results;
    }
}

?>