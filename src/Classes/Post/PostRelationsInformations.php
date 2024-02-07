<?php

namespace App\Classes\Post;

use App\Class\Category;
use App\Class\Comment;
use App\Class\Crud;
use App\Class\User;

class PostRelationsInformations  
{
    public function getUserPostInformations($user_id){
        // User
        $userCrud = new Crud('user');
        $userRequest = $userCrud->getByAttributes(['id' => $user_id]);
        $user = new User();
        $user->setFirstname($userRequest[0]['firstname']);
        $user->setLastname($userRequest[0]['lastname']);

        return $user;
    }

    public function getCategoryPostInformations($category_id){
        // Category
        $categoryCrud = new Crud('category');
        $categoryRequest = $categoryCrud->getByAttributes(['id' => $category_id]);
        $category = new Category();
        $category->setName($categoryRequest[0]['name']);

        return $category;
    }

    public function getCommentsPostInformations($post_id){
        // User
        $userCrud = new Crud('user');
        // Comment
        $commentCrud = new Crud('comment');
        $commentRequest = $commentCrud->getByAttributes(['post_id' => $post_id]);
        
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

        return $comments;
    }
}
?>