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

        // User
        $userCrud = new Crud('user');
        $userRequest = $userCrud->getByAttributes(['id' => $post[0]['user_id']]);
        $user = new User();
        $user->setFirstname($userRequest[0]['firstname']);
        $user->setLastname($userRequest[0]['lastname']);
        $this->setUser($user);

        // Category
        $categoryCrud = new Crud('category');
        $categoryRequest = $categoryCrud->getByAttributes(['id' => $post[0]['category_id']]);
        $category = new Category();
        $category->setName($categoryRequest[0]['name']);
        $this->setCategory($category);

        // Comment
        $commentCrud = new Crud('comment');
        $commentRequest = $commentCrud->getByAttributes(['post_id' => $post[0]['id']]);
        
        $arrayCommentRequest = (array)$commentRequest;

        $comments = [];
        if (count($commentRequest[0]) > 0){
            foreach($arrayCommentRequest as $comment){

                $commentUserRequest = $userCrud->GetByAttributes(['id' => $comment['user_id']]);

                $commentUser = new User();
                $commentUser->setFirstname($commentUserRequest ? $commentUserRequest[0]['firstname'] : '');
                $commentUser->setLastname($commentUserRequest ? $commentUserRequest[0]['lastname'] : '');

                $comments[] = (new Comment())
                ->setId($comment['id'])
                ->setContent($comment['content'])
                ->setCreatedAt($comment['created_at'])
                ->setUser($commentUser);
            }
        }   

        $this->setComments($comments);

        return $this;
    }

    public function getPaginatePosts($page)
    {
        return $this->crud->GetAllPaginate($page);
    }
}

?>