<?php

namespace budget\Domain;

class Compte
{
    
    private $id;

    private $categorieCompte;
    
    private $User;
    
    private $libelleCompte;
    
    private $montantCompte;
    
    private $nomTitulaire;
    
    private $prenomTitulaire;
    
    private $dateCompte;
        
    public function getDateCompte() {
        return $this->date;
    }

    public function setDateCompte($date) {
        $this->dateCompte = $date;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getCategorieCompte() {
        return $this->categorieCompte;
    }

    public function setCategorieCompte($categorieCompte) {
        $this->categorieCompte = $categorieCompte;
    }
    
    public function getUser() {
        return $this->user;
    }

    public function setUser($user) {
        $this->user = $user;
    }
    
    public function getLibelleCompte() {
        return $this->libelleCompte;
    }

    public function setLibelleCompte($libelleCompte) {
        $this->libelleCompte = $libelleCompte;
    }
    
    public function getMontantCompte() {
        return $this->montantCompte;
    }

    public function setMontantCompte($montantCompte) {
        $this->montantCompte = $montantCompte;
    }
    
    public function getNomTitulaire() {
        return $this->nomTitulaire;
    }

    public function setNomTitulaire($nomTitulaire) {
        $this->nomTitulaire = $nomTitulaire;
    }
    
    public function getPrenomTitulaire() {
        return $this->prenomTitulaire;
    }

    public function setPrenomTitulaire($prenomTitulaire) {
        $this->prenomTitulaire = $prenomTitulaire;
    }
}