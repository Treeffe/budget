<?php

namespace budget\DAO;

use budget\Domain\Frais;
use budget\Domain\Visiteur;
use budget\Domain\Periode;
use budget\DAO\VisiteurDAO;
use budget\DAO\PeriodeDAO;

class FraisDAO extends DAO
{
    private $visiteurDAO;
    
    private $periodeDAO;
    
    public function setVisiteurDAO(VisiteurDAO $visiteurDAO) {
        $this->visiteurDAO = $visiteurDAO;
    }
    
    public function setPeriodeDAO(PeriodeDAO $periodeDAO) {
        $this->periodeDAO = $periodeDAO;
    }
    
    protected function buildDomainObject($row) 
    {
        $frais = new Frais();
        $frais->setId($row['ID']);
        $frais->setLibelleFrais($row['libelleFrais']);
        $frais->setMontantFrais($row['MontantFrais']);
        $frais->setDescriptionFrais($row['descriptionFrais']);
        $idUser = $row['IDUser'];
        
        if (array_key_exists('IDUser', $row) || iduser > 0) {
            $idVisiteur = $row['IDUser'];
            $visiteur = $this->visiteurDAO->find($idVisiteur);
            $frais->setUser($visiteur);
        }
        
        if (array_key_exists('idPeriode', $row)) {
            $idPeriode = $row['idPeriode'];
            $periode = $this->periodeDAO->find($idPeriode);
            $frais->setPeriode($periode);
        }
        
        return $frais;
    }
    
    public function findAllFrais($idUser) {
        $sql = "SELECT * FROM `frais` where idUser = ? order by libelleFrais";
        $result = $this->getDb()->fetchAll($sql, array($idUser));
        
        // Convertit les résultats de requête en tableau d'objets du domaine
        $frais = array();
        foreach ($result as $row) {
            $id = $row['ID'];
            $frais[$id] = $this->buildDomainObject($row);
        }
        return $frais;
    }
    
    public function find($code) {
        $sql = "select * from frais where id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($code));
        if ($row)
            return $this->buildDomainObject($row);
        //else
            //throw new \Exception("Aucun compte trouvé");
    }
    
    public function saveFrais($idUser, $idPeriode, $descriptionFrais, $libelleFrais, $montantFrais)
	{
		$data = array(
			'montantFrais' => $montantFrais,
            'descriptionFrais' => $descriptionFrais,
            'libelleFrais' => $libelleFrais,
            'idUser' => $idUser,
            'idPeriode' => $idPeriode
			);
		$this->getDb()->insert('frais', $data);
	}
    
    public function modificationMontantCompte($idCompte, $nouveauMontant)
    {   
        $sql = "UPDATE frais SET montantFrais=? WHERE ID = ?";
        $test = $this->getDb()->executeUpdate($sql, array( $nouveauMontant, $idCompte));
    }
    
    
}