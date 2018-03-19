<?php

namespace budget\Domain;

class CategorieCompte
{
    /**
     * Identifiant.
     *
     * @var integer
     */
    private $id;

    /**
     * Libelle.
     *
     * @var string
     */
    private $libelleCategorieCompte;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getLibelleCategorieCompte() {
        return $this->libelleCategorieCompte;
    }

    public function setLibelleCategorieCompte($libelleCategorieCompte) {
        $this->libelleCategorieCompte = $libelleCategorieCompte;
    }
}