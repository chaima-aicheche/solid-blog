<?php

namespace App\Class;

use App\Router\Router;

class Controller
{

    public function render($view, $params = [])
    {
        ob_start();
        extract($params);
        require_once 'src/views/' . $view . '.php';
        $content = ob_get_clean();
        require_once 'src/views/partials/header.php';
        echo $content;
        require_once 'src/views/partials/footer.php';
    }

    public function redirect($url, $params = [], $code = 302, $message = null)
    {
        $url = Router::url($url, $params);
        header("Location: $url", true, $code);
        exit();
    }

    // public static function getUser()
    // {
    //     if (isset($_SESSION['user'])) {
    //         return $_SESSION['user'];
    //     } else {
    //         return null;
    //     }
    // }

    public function profile()
    {
        $user = new User();
        if (self::getUser() === null) {
            $this->redirect('login');

            return;
        }
        $user = $user->findOneById($_SESSION['user']->getId());
        if ($user) {
            $user->setPassword('');
            $this->render('profile', ['user' => $user]);

            return;
        }

        $this->redirect('login');

        return;
    }

    // public function viewPost($id, $error = null)
    // {
    //     if (is_numeric($id) === false) {
    //         throw new \Exception("L'identifiant du post n'est pas valide");

    //         return;
    //     }
    //     $post = new Post();
    //     $post = $post->findOneById((int) $id);
    //     $this->render('post', ['post' => $post, 'error' => $error]);
    // }

    public function createComment($content, $post_id)
    {
        if (empty($content)) {
            throw new \Exception("Le contenu ne peut pas être vide");

            return;
        }

        if (self::getUser() === null) {
            throw new \Exception("Vous devez être connecté pour commenter");

            return;
        }

        if (is_numeric($post_id) === false) {
            throw new \Exception("L'identifiant du post n'est pas valide");

            return;
        }

        $post_id = (int) $post_id;

        $post = new Post();
        $post = $post->findOneById($post_id);

        $comment = new Comment();
        $comment->setContent($content);
        $comment->setUser(self::getUser());
        $comment->setPost($post);
        $comment->setCreatedAt(new \DateTime());
        $comment->save();

        $this->redirect('post', ['id' => $post->getId()]);
    }

    public function admin($action = 'list', $entity = 'user', $id = null)
    {
        if (self::getUser() === null || !in_array('ROLE_ADMIN', self::getUser()->getRole())) {
            $this->redirect('home');

            return;
        }

        $action = $action . 'Admin';

        if (method_exists($this, $action)) {
            $this->$action($entity, $id);
        } else {
            throw new \Exception("L'action demandée n'existe pas");
        }
    }

    public function listAdmin($entity)
    {
        $entity = ucfirst($entity);
        $className = "App\\Class\\$entity";
        $class = new $className();
        $entities = $class->findAll();
        $entities = array_map(function ($instance) {
            return $instance->toArray();
        }, $entities);
        $this->render('admin/list', [
            'entities' => $entities,
            'entityName' => $entity
        ]);
    }

    public function showAdmin($entity, $id)
    {
        $entity = ucfirst($entity);
        $className = "App\\Class\\$entity";
        $class = new $className();
        $instance = $class->findOneById($id);
        $this->render('admin/show', [
            'entity' => $instance,
            'entityName' => $entity
        ]);
    }

    public function editAdmin($entity, $id)
    {
        $entity = ucfirst($entity);
        $className = "App\\Class\\$entity";
        $class = new $className();
        $instance = $class->findOneById($id);
        foreach ($_POST as $key => $value) {
            $key = explode('_', $key);
            $key = array_map(function ($word) {
                return ucfirst($word);
            }, $key);
            $key = implode('', $key);
            $value = htmlspecialchars($value);
            $getter = 'get' . $key;
            if (method_exists($instance, $getter) && is_array($instance->$getter())) {
                $value = explode(', ', $value);
            }
            if (is_string($value) && strtotime($value)) {
                $value = (new \DateTime())->setTimestamp(strtotime($value));
            }
            if ($key === 'User' || $key === 'Post' || $key === 'Comments' || $key === 'Category') {
                continue;
            }
            $setter = 'set' . $key;
            var_dump([$key, $value]);
            if (method_exists($instance, $setter) && null !== $instance->$getter()) {
                $instance->$setter($value);
            }
        }

        $instance->save();

        $this->redirect('admin', ['entity' => strtolower($entity), 'action' => 'list']);
    }

    public function deleteAdmin($entity, $id)
    {
        $entity = ucfirst($entity);
        $className = "App\\Class\\$entity";
        $class = new $className();
        $instance = $class->findOneById($id);
        $instance->delete();

        if ($entity === 'User' && $id === self::getUser()->getId()) {
            $this->redirect('logout');
        }

        $this->redirect('admin', ['entity' => strtolower($entity), 'action' => 'list']);
    }
}
