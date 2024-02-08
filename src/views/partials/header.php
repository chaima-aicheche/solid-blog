<?php

use App\Class\Controller;
use App\Controller\Authentication\AuthenticationController;
use App\Controller\Role\RoleController;
use App\Controller\User\UserController;
use App\Router\Router;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stupid Blog</title>
</head>

<header>
    <h1>Stupid Blog</h1>
    <?php if (AuthenticationController::getUserSession()) : ?>
        <p>Bonjour <?= AuthenticationController::getUserSession()['firstname'] ?> <?= AuthenticationController::getUserSession()['lastname'] ?></p>
    <?php endif ?>
    <nav>
        <ul>
            <li><a href="<?= Router::url('home') ?>">Accueil</a></li>
            <li><a href="<?= Router::url('posts', ['page' => 1]) ?>">Articles</a></li>
            <?php if (null !== AuthenticationController::getUserSession()) : ?>
                <li><a href="<?= Router::url('profile') ?>">Profil</a></li>
                <li><a href="<?= Router::url('logout') ?>">Se déconnecter</a></li>
                <?php if (RoleController::userRoleVerify('ROLE_ADMIN')) : ?>
                    <li><a href="<?= Router::url('admin', ['action' => 'list', 'entity' => 'user']) ?>">Admin</a></li>
                <?php endif ?>
            <?php else : ?>
                <li><a href="<?= Router::url('login') ?>">Se connecter</a></li>
                <li><a href="<?= Router::url('register') ?>">S'inscrire</a></li>
            <?php endif ?>
        </ul>
    </nav>
</header>