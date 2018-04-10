<?php

namespace budget\Domain;

class Periode
{
    private $id;

    private $libellePeriode;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getLibellePeriode() {
        return $this->libellePeriode;
    }

    public function setLibellePeriode($libellePeriode) {
        $this->libellePeriode = $libellePeriode;
    }
}