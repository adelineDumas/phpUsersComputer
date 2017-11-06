<?php

namespace App\Computer\Entity;

class Computer
{
    protected $id;

    protected $nom;

    protected $marque;

    protected $os; 

    protected $idUser; 

    protected $nomUser; 

    public function __construct($id, $nom, $marque, $os, $idUser)
    {
        $this->id = $id;
        $this->marque = $marque;
        $this->nom = $nom;
        $this->os = $os; 
        $this->idUser = $idUser; 
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    public function setMarque($marque)
    {
        $this->marque = $marque;
    }

    public function setOS($os)
    {
        $this->os = $os;
    }

    public function setidUser($idUser)
    {
        $this->idUser = $idUser;
    }

    public function setNomUser($nomUser)
    {
        $this->nomUser = $nomUser;
    }

    public function getId()
    {
        return $this->id;
    }
    public function getMarque()
    {
        return $this->marque;
    }
    public function getNom()
    {
        return $this->nom;
    }
    public function getOS()
    {
        return $this->os;
    }
    public function getidUser()
    {
        return $this->idUser;
    }

    public function getNomUser()
    {
        return $this->nomUser;
    }
    public function toArray()
    {
        $array = array();
        $array['id'] = $this->id;
        $array['nom'] = $this->nom;
        $array['marque'] = $this->marque;
        $array['os'] = $this->os;
        $array['idUser'] = $this->idUser;
        $array['nomUser'] = $this->nomUser;

        return $array;
    }
}
