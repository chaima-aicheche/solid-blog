<?php

namespace App\Class;

use App\Class\Database;

class Crud extends Database
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
        $query = $this->Query('SELECT * FROM '. $this->table);
        $find_all = $query->fetchAll();
        return $find_all;
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

    public function Delete($id){

    }

    public function Update($id){

    }
}