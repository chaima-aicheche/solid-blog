<?php

namespace App\Class;

use App\Class\Crud;
class User
{
    protected $crud;

    public function __construct(
        private ?int $id = null,
        private ?string $email = null,
        private ?string $password = null,
        private ?string $firstname = null,
        private ?string $lastname = null,
        private ?array $role = [],
        private ?array $posts = [],
        private ?array $comments = []
    ) {
        $this->crud = new Crud('user'); // Instanciation de l'objet Crud
    }

    // Getters et Setters pour les attributs de la classe User

    public function FindOneById(int $id): self
    {
        $user = $this->crud->getById($id); 

        if ($user) {
            $this->id = $user['id'];
            $this->email = $user['email'];
            $this->password = $user['password'];
            $this->firstname = $user['firstname'];
            $this->lastname = $user['lastname'];
            $this->role = json_decode($user['role'], true);
        }

        return $this;
    }

    // public function FindOneByEmail(string $email): ?self
    // {
    //     $user = $this->crud->getByAttributes(['email' => $email]);

    //     if ($user) {
    //         $user = $user[0];
    //         $this->id = $user['id'];
    //         $this->email = $user['email'];
    //         $this->password = $user['password'];
    //         $this->firstname = $user['firstname'];
    //         $this->lastname = $user['lastname'];
    //         $this->role = json_decode($user['role'], true);
    //         return $this;
    //     }

    //     return null;
    // }

    public function FindAll(): array
    {
        return $this->crud->getAll();
    }

    public function save(): void
    {
        $data = [
            'email' => $this->email,
            'password' => $this->password,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'role' => json_encode($this->role)
        ];

        if ($this->id) {
            $this->crud->update($data, $this->id);
        } else {
            $this->id = $this->crud->create($data);
        }
    }

    public function Delete(): void
    {
        if ($this->id) {
            $this->crud->delete($this->id);
        }
    }

}
