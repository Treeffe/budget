<?php

namespace budget\Domain;

class Transaction
{
    
    private $id;

    private $categorieTransaction;
    
    private $compteCredit;
    
    private $compteDebit;
    
    private $libelleTransaction;
    
    private $montant;
    
    private $dateTransaction;
    
    private $User;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getCategorieTransaction() {
        return $this->categorieTransaction;
    }

    public function setCategorieTransaction($categorieTransaction) {
        $this->categorieTransaction = $categorieTransaction;
    }
    
    public function getCompteCredit() {
        return $this->compteCredit;
    }

    public function setCompteCredit($compteCredit) {
        $this->compteCredit = $compteCredit;
    }
    
    public function getCompteDebit() {
        return $this->compteDebit;
    }

    public function setCompteDebit($compteDebit) {
        $this->compteDebit = $compteDebit;
    }
    
    public function getLibelleTransaction() {
        return $this->libelleTransaction;
    }

    public function setLibelleTransaction($libelleTransaction) {
        $this->libelleTransaction = $libelleTransaction;
    }
    
    public function getMontant() {
        return $this->montant;
    }

    public function setMontant($montant) {
        $this->montant = $montant;
    }
    
    public function getDateTransaction() {
        return $this->dateTransaction;
    }

    public function setDateTransaction($dateTransaction) {
        $this->dateTransaction= $dateTransaction;
    }
    
    public function getUser() {
        return $this->user;
    }

    public function setUser($user) {
        $this->user = $user;
    }
}