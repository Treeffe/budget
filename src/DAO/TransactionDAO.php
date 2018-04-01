<?php

namespace budget\DAO;

use budget\Domain\CategorieCompte;
use budget\Domain\Compte;
use budget\Domain\Transaction;
use budget\DAO\CategorieCompteDAO;
use budget\DAO\CompteDAO;

class TransactionDAO extends DAO
{
	private $compteDebitDAO;
    private $compteCreditDAO;
    private $categorieTransactionDAO;
    private $visiteurDAO;

    public function setCategorieTransactionDAO(CategorieTransactionDAO $categorieTransactionDAO) {
        $this->categorieTransactionDAO = $categorieTransactionDAO;
    }
    
    public function setCompteDebitDAO(CompteDAO $compteDebitDAO) {
        $this->compteDebitDAO = $compteDebitDAO;
    }
    
    public function setCompteCreditDAO(CompteDAO $compteCreditDAO) {
        $this->compteCreditDAO = $compteCreditDAO;
    }
    
    public function setVisiteurDAO(VisiteurDAO $visiteurDAO) {
        $this->visiteurDAO = $visiteurDAO;
    }
    
    
    
    protected function buildDomainObject($row) 
    {
        $transaction = new Transaction();
        $transaction->setId($row['ID']);
        $transaction->setLibelleTransaction($row['libelleTransaction']);
        $transaction->setMontant($row['montant']);
        $transaction->setDateTransaction($row['date']);
        $idCategorieTransaction = $row['IDCategorieTransaction'];
        $idCompteDebit = $row['IDCompteDebit'];
        $idCompteCredit = $row['IDCompteCredit'];
        $idUser = $row['idUser'];
        
        
         if (array_key_exists('IDCategorieTransaction', $row)) {
            $idCategorieTransaction = $row['IDCategorieTransaction'];
            $categorieTransaction = $this->categorieTransactionDAO->find($idCategorieTransaction);
            $transaction->setCategorieTransaction($categorieTransaction);
        }
        
        if (array_key_exists('IDCompteDebit', $row)) {
            $idCompteDebit = $row['IDCompteDebit'];
            $compteDebit = $this->compteDebitDAO->find($idUser);
            $transaction->setCompteDebit($compteDebit);
        }
        
        if (array_key_exists('IDCompteCredit', $row)) {
            $idCompteCredit = $row['IDCompteCredit'];
            $compteCredit = $this->compteCreditDAO->find($idUser);
            $transaction->setCompteCredit($compteCredit);
        }
        
        if (array_key_exists('idUser', $row)) {
            $idUser = $row['idUser'];
            $user = $this->visiteurDAO->find($idUser);
            $transaction->setUser($user);
        }
        
        return $transaction;
    }
    
    public function findAllTransactions($idUser) {
        $sql = "SELECT * FROM `transaction` where idUser = ?";
        $result = $this->getDb()->fetchAll($sql, array($idUser));
        
        // Convertit les résultats de requête en tableau d'objets du domaine
        $comptes = array();
        foreach ($result as $row) {
            if (array_key_exists('IDCategorieTransaction', $row)) {
            $id = $row['ID'];
            $comptes[$id] = $this->buildDomainObject($row);
            }
        }
        return $comptes;
    }
    
    public function find($code) {
        $sql = "select * from transaction where id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($code));
        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("Aucun probleme trouvé");
    }
    
    public function saveTransaction($idCategorieTransaction, $idCompteCredit, $idCompteDebit, $idUser, $libelle, $montant)
	{
		$data = array(
            'libelleTransaction' => $libelle,
            'idUser' => $idUser,
            'montant' => $montant,
            'IDCompteCredit' =>$idCompteCredit,
            'IDCompteDebit' => $idCompteDebit,
            'IDCategorieTransaction' => $idCategorieTransaction
			);
		$this->getDb()->insert('transaction', $data);
	}
    
    public function modificationCategorieTransaction($idCatDel, $idCategorieTransaction)
    {   
        $sql = "UPDATE transaction SET IDCategorieTransaction=? WHERE IDCategorieTransaction = ?";
        $test = $this->getDb()->executeUpdate($sql, array( $idCategorieTransaction, $idCatDel));
    }
    
    public function findByCompte($iCompte) {
        $sql = "SELECT * from transaction where IDCompteCredit = (SELECT ID from compte where ID=?)";
        $result = $this->getDb()->fetchAll($sql, array($idCompte));
        
        // Convertit les résultats de requête en tableau d'objets du domaine
        $transactions = array();
        foreach ($result as $row) {
            if (array_key_exists('IDCategorieTransaction', $row)) {
            $id = $row['ID'];
            $transactions[$id] = $this->buildDomainObject($row);
            }
        }
        return $transactions;
    }
    
    public function findByCompteDebit($idCompte) {
        $sql = "SELECT * from transaction where IDCompteDebit = (SELECT ID from compte where ID=?)";
        $result = $this->getDb()->fetchAll($sql, array($idCompte));
        
        // Convertit les résultats de requête en tableau d'objets du domaine
        $transactions = array();
        foreach ($result as $row) {
            if (array_key_exists('IDCategorieTransaction', $row)) {
            $id = $row['ID'];
            $transactions[$id] = $this->buildDomainObject($row);
            }
        }
        return $transactions;
    }
}