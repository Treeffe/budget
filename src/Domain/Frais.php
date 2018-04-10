<?php

namespace budget\Domain;

class Frais
{
    
    private $id;
    
    private $user;
    
    private $libelleFrais;
    
    private $montantFrais;
    
    private $descriptionFrais;
    
    private $periode;
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }
    
    public function getPeriode() {
        return $this->periode;
    }

    public function setPeriode(Periode $periode) {
        $this->periode = $periode;
    }
    
    public function getUser() {
        return $this->user;
    }

    public function setUser($user) {
        $this->user = $user;
    }
    
    public function getLibelleFrais() {
        return $this->libelleFrais;
    }

    public function setLibelleFrais($libelleFrais) {
        $this->libelleFrais = $libelleFrais;
    }
    
    public function getMontantFrais() {
        return $this->montantFrais;
    }
    
    public function setMontantFrais($montantFrais) {
        $this->montantFrais = $montantFrais;
    }

    public function getDescriptionFrais() {
        return $this->libelleFrais;
    }

    public function setDescriptionFrais($descriptionFrais) {
        $this->descriptionFrais = $descriptionFrais;
    }
}