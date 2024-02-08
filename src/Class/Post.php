<?php

namespace App\Class;

use DateTime;

class Post
{

    protected $crud;
    
    public function __construct(
        private ?int $id = null,
        private ?string $title = null,
        private ?string $content = null,
        private ?DateTime $createdAt = null,
        private ?DateTime $updatedAt = null,
        private ?User $user = null,
        private ?array $comments = [],
        private ?Category $category = null,
    ) {
    }

    /**
     * getId
     *
     * @return integer|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * setId
     *
     * @param  mixed $id
     * @return self
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * getTitle
     * 
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * setTitle
     *
     * @param  mixed $title
     * @return self
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * getContent
     *
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * setContent
     *
     * @param  mixed $content
     * @return self
     */
    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * getCreatedAt
     *
     * @return DateTime|null
     */
    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    /**
     * setCreatedAt
     *
     * @param  DateTime $createdAt
     * @return self
     */
    public function setCreatedAt(DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * getUpdatedAt
     *
     * @return DateTime|null
     */
    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    /**
     * setUpdatedAt
     *
     * @param  DateTime $updatedAt
     * @return self
     */
    public function setUpdatedAt(?DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * getUser
     *
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * setUser
     *
     * @param  User $user
     * @return self
     */
    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * getComments
     *
     * @return array|null
     */
    public function getComments(): ?array
    {
        return $this->comments;
    }

    /**
     * setComments
     *
     * @param  array $comments
     * @return self
     */
    public function setComments(array $comments): self
    {
        $this->comments = $comments;
        foreach ($comments as $comment) {
            $comment->setPost($this);
        }

        return $this;
    }

    public function addComment(Comment $comment): self
    {
        if (!in_array($comment, $this->comments) && $comment->getPost()->getId() === $this->id) {
            $this->comments[] = $comment;
        }
        $this->comments[] = $comment;

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        $key = array_search($comment, $this->comments);
        if ($key !== false) {
            unset($this->comments[$key]);
        }

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(Category $category): self
    {
        $this->category = $category;

        return $this;
    }
}
