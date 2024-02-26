<?php

namespace App\Interfaces\Comment;
use App\Class\User;
use App\Class\Post;

use DateTime;

interface CommentInterface
{
    public function getId(): ?int;
    public function setId(int $id): self;

    public function getContent(): ?string;
    public function setContent(string $content): self;

    public function getCreatedAt(): ?DateTime;
    public function setCreatedAt(DateTime|string $createdAt): self;

    public function getUser(): ?User;
    public function setUser(User $user): self;

    public function getPost(): ?Post;
    public function setPost(Post $post): self;

    public function toArray(): array;

    public function findOneById(int $id): self;
    public function findAll(): array;
    public function findByPost(int $id): array;
    public function findByUser(int $id): array;

    public function save(): void;
    public function delete(): void;
}
