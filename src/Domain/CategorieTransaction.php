<?php

namespace budget\Domain;

class CategorieTransaction
{
    
    private $id;


    private $libelleCategorieTransaction;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getLibelleCategorieTransaction() {
        return $this->libelleCategorieTransaction;
    }

    public function setLibelleCategorieTransaction($libelleCategorieTransaction) {
        $this->libelleCategorieTransaction = $libelleCategorieTransaction;
    }
}