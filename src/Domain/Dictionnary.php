<?php

namespace budget\Domain;

class Dictionnary
{
    
    private $compte;


    private $transactions;

    public function getCompte() {
        return $this->compte;
    }

    public function setCompte(Compte $compte) {
        $this->compte = $compte;
    }

    public function getTransactions() {
        return $this->transactions;
    }

    public function setTransactions($transactions) {
        $this->transactions = $transactions;
    }
    
    
}