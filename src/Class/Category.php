<?php

namespace App\Class;

use App\Class\Crud;

class Category extends Crud
{
    protected $table = 'category';

    // Propriété pour stocker l'instance de Crud
    private $crud;

    public function __construct(
        private ?int $id = null,
        private ?string $name = null,
        private ?array $posts = []
    ) {
        // Appeler le constructeur de la classe parente
        parent::__construct($this->table);

        // Initialiser l'instance de Crud
        $this->crud = new Crud($this->table);
    }

    /**
     * Get the value of id
     */ 
    public function GetId(): ?int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function SetId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of name
     */ 
    public function GetName(): ?string
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function SetName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of posts
     */ 
    public function GetPosts(): array
    {
        return $this->posts;
    }

    /**
     * Set the value of posts
     *
     * @param Post[] $posts
     * @return  self
     */ 
    public function SetPosts(array $posts): self
    {
        $this->posts = $posts;

        return $this;
    }

    public function ToArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'posts' => count($this->posts)
        ];
    }

    public function FindOneById(int $id): self
    {
        $category = $this->GetById($id);

        if ($category) {
            $this->id = $category['id'];
            $this->name = $category['name'];
        }

        return $this;
    }

    public function FindAll(): array
    {
        $categories = $this->GetAll();

        $results = [];
        foreach ($categories as $category) {
            $results[] = (new Category())
                ->SetId($category['id'])
                ->SetName($category['name']);
        }

        return $results;
    }

    public function Save(): self
    {
        if (is_null($this->id)) {
            $this->Create([
                'name' => $this->name
            ]);
        } else {
            $this->Update([
                'name' => $this->name
            ], $this->id);
        }

        return $this;
    }

    public function Delete($id): void
    {
        // Appeler la méthode Delete de Crud à travers l'instance $crud
        $this->crud->Delete($id);
    }
}
