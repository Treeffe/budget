<?php

namespace budget\DAO;

use budget\Domain\CategorieCompte;
use budget\Domain\Compte;
use budget\Domain\Visiteur;
use budget\DAO\CategorieCompteDAO;
use budget\DAO\VisiteurDAO;

class CompteDAO extends DAO
{
	private $categorieCompteDAO;
    private $visiteurDAO;

    public function setCategorieCompteDAO(CategorieCompteDAO $categorieCompteDAO) {
        $this->categorieCompteDAO = $categorieCompteDAO;
    }
    
    public function setVisiteurDAO(VisiteurDAO $visiteurDAO) {
        $this->visiteurDAO = $visiteurDAO;
    }
    
    protected function buildDomainObject($row) 
    {
        $compte = new compte();
        $compte->setId($row['ID']);
        $compte->setLibelleCompte($row['libelleCompte']);
        $compte->setNomTitulaire($row['nomTitulaire']);
        $compte->setPrenomTitulaire($row['prenomTitulaire']);
        $compte->setMontantCompte($row['MontantCompte']);
        
        if (array_key_exists('IDCategorieCompte', $row)) {
            $idCategorieCompte = $row['IDCategorieCompte'];
            $categorieCompte = $this->categorieCompteDAO->find($row['IDCategorieCompte']);
            $compte->setCategorieCompte($categorieCompte);
        }
        
        if (array_key_exists('IDUser', $row)) {
            $idVisiteur = $row['IDUser'];
            $visiteur = $this->visiteurDAO->find($idVisiteur);
            $compte->setUser($visiteur);
        }
        
        return $compte;
    }
    
    public function findAllComptes($idUser) {
        $sql = "SELECT * FROM `compte` where idUSer = ? order by libelleCompte";
        $result = $this->getDb()->fetchAll($sql, array($idUser));
        
        // Convertit les résultats de requête en tableau d'objets du domaine
        $comptes = array();
        foreach ($result as $row) {
            if (array_key_exists('IDCategorieCompte', $row)) {
            $id = $row['ID'];
            $comptes[$id] = $this->buildDomainObject($row);
            }
        }
        return $comptes;
    }
    
    public function find($code) {
        $sql = "select * from compte where id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($code));
        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("Aucun compte trouvé");
    }
    
    public function saveCompte($idCategorieCompte, $idUser, $libelle, $montant)
	{
		$data = array(
			'montantCompte' => $montant,
            'libelleCompte' => $libelle,
            'idCategorieCompte' => $idCategorieCompte,
            'idUser' => $idUser
			);
		$this->getDb()->insert('compte', $data);
	}
    
    public function modificationMontantCompte($idCompte, $nouveauMontant)
    {   
        $sql = "UPDATE compte SET montantCompte=? WHERE ID = ?";
        $test = $this->getDb()->executeUpdate($sql, array( $nouveauMontant, $idCompte));
    }
}