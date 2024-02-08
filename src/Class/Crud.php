<?php

namespace App\Class;

use App\Manager\Database\DatabaseManager;
use DateTime;

class Crud
{

    protected $dbConnection;
    protected $table;

    public function __construct($table) {
        $databaseManager = new DatabaseManager();
        $this->dbConnection = $databaseManager->makeConnection(new Database());
        $this->table = $table;
    }

    public function Query(string $sql, ?array $attributs = []){
         //On vérifie si on a des attributs 
         if ($attributs !== null){
            //requête préparée
            $query = $this->dbConnection->prepare($sql);
            $query->execute($attributs);
            return $query;
        } else {
            //requête simple
            return $this->dbConnection->query($sql);
        }
    }

    public function Create(array $data)
    {
        
        $columns = implode(', ', array_keys($data));
        $values = implode(', ', array_fill(0, count($data), '?'));

        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$values})";

        $query = $this->dbConnection->prepare($sql);
        $query->execute(array_values($data));

        return $this->dbConnection->lastInsertId();
    }

    public function GetAll(){
        $query = $this->Query("SELECT * FROM {$this->table}");
        $allRecords = $query->fetchAll();

        return $allRecords;
    }

    /**
     * Renvoyer une liste d'éléments limités pour la pagination
     *
     * @param [type] $page
     * @return void
     */
    public function GetAllPaginate($page){
        $limit = 10;
        $offset = ($page - 1) * $limit;
        $sql = "SELECT * FROM {$this->table} ORDER BY created_at DESC LIMIT :limit OFFSET :offset";
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();
        $arrayPost = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $arrayPost;
    }

    /**
     * Trouver des lignes de la table en fonction de critéres
     * findBy(['actif' => 15])
     * 
     * @param array $criteres
     * @return requete
     */
    public function GetByAttributes(array $attributes){

        $champs = [];
        $valeurs = [];

        // On boucle pour éclater le tableau
        foreach($attributes as $champ => $valeur){
            //SELECT * FROM annonces where actif = ? AND signale = 0
            //bindValue(1, valeur);
            $champs[] = "$champ = ?";
            $valeurs[] = $valeur;
        }

        // On transforme le tableau champs en chaine de caractére
        $liste_champs = implode(' AND ', $champs);

        // On éxecute la requête 
        return $this->Query('SELECT * FROM '.$this->table.' WHERE '. $liste_champs, $valeurs)->fetchAll();
    }

    public function Delete($id): void
    {
        $query = $this->dbConnection->prepare("DELETE FROM {$this->table} WHERE id = :id");
        $query->bindValue(':id', $id, \PDO::PARAM_INT);
        $query->execute();
    }
    
    

    public function Update(array $data, $id): void
    {
        // Requête UPDATE
        $sql = "UPDATE {$this->table} SET ";
        $setValues = [];
        foreach ($data as $column => $value) {
            $setValues[] = "$column = :$column";
        }
        $sql .= implode(', ', $setValues);
        $sql .= " WHERE id = :id";

        
        
        // Préparer la requête
        $query = $this->dbConnection->prepare($sql);

        // var_dump($query);
        $roles = '[';
        
        // Binder les valeurs
        foreach ($data as $column => $value) {
            if ($column == 'Role'){
                foreach($value as $key => $role){
                    if ($key < count($value) - 1){
                        $roles .= '"'.$role.'",';
                    } else {
                        $roles .= '"'.$role.'"';
                    }
                }
                $roles .= ']';
                $query->bindValue(":$column", $roles);
            } else {
                $query->bindValue(":$column", $value);
            }
        }
        $query->bindValue(':id', $id, \PDO::PARAM_INT);
        

        // On exécute la requête
        $query->execute();
    }

}