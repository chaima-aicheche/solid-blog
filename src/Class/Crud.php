<?php

namespace App\Class;

use App\Class\Database;

class Crud extends Database implements CurdInterface
{

    private $dbConnection;
    private $table;

    public function __construct($table) {
        $this->dbConnection = Database::connect();
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

    public function Create(){

    }

    public function GetAll(){
        $query = $this->Query("SELECT * FROM {$this->table}");
        $allRecords = $query->fetchAll();

    return $allRecords;
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

        // Binder les valeurs
        foreach ($data as $column => $value) {
            $query->bindValue(":$column", $value);
        }
        $query->bindValue(':id', $id, \PDO::PARAM_INT);

        // On exécute la requête
        $query->execute();
    }

}

interface CurdInterface {
    public function Create();
    public function GetAll();
    public function GetByAttributes(array $attributes);
    public function Update(array $data, $id);
    public function Delete($id);
}