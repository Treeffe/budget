<?php

namespace budget\DAO;

use budget\Domain\CategorieCompte;

class CategorieCompteDAO extends DAO
{

    /**
     * Renvoie un type à partir de son identifiant
     *
     * @param integer $id L'identifiant du type
     *
     * @return \GSB\Domain\Type|Lève une exception si aucun Type  ne correspond
     */
    public function find($id) {
        $sql = "select * from categoriecompte where id = ?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));
        
        if ($row)
            
            return $this->buildDomainObject($row);
        //else
            //throw new \Exception("Aucune categorie de compte n'a été trouvé");
            //throw new \Exception("aucun ".$id);
        
    }
    
    public function findAllCategoriesComptes() {
        $sql = "SELECT * FROM `categoriecompte` order by libelleCategorieCompte";
        
        // Convertit les résultats de requête en tableau d'objets du domaine
        $categories = $this->getDb()->fetchAll($sql);
        foreach ($categories as $row) {
            if($row['ID'] != "1"){
                
                if (array_key_exists('id', $row)) {
                $idCategorie = $row['id'];
                $categories[$idCategorie] = $this->buildDomainObject($row);
                }
            }
        }
        return $categories;
    }

    /**
     * Crée un objet Type à partir d'une ligne de résultat BD
     *
     * @param array $row La ligne de résultat BD
     *
     * @return \GSB\Domain\Type
     */
    protected function buildDomainObject($row) {
        $categorie = new CategorieCompte();
        $categorie->setId($row['ID']);
        $categorie->setLibelleCategorieCompte($row['libelleCategorieCompte']);
        return $categorie;
    }
    
    public function saveCategorieCompte($libelle)
	{
		$data = array(
			'libelleCategorieCompte' => $libelle
			);
		$this->getDb()->insert('categorieCompte', $data);
	}
    
    public function findAllCategorieCompte() {
        $sql = "SELECT * FROM `categorieCompte` order by libelleCategorieCompte";
        
        // Convertit les résultats de requête en tableau d'objets du domaine
        $categories = $this->getDb()->fetchAll($sql);
        foreach ($categories as $row) {
            if (array_key_exists('id', $row)) {
            $idCategorie = $row['id'];
            $categories[$idCategorie] = $this->buildDomainObject($row);
            }
        }
        return $categories;
    }
    
    public function DeleteCategorieCompte($id) {
        $sql = "DELETE FROM `categorieCompte` WHERE ID = ?";
        $this->getDb()->executeQuery($sql, array($id));
    }
    
    public function modificationCategorieCompte($idCatDel, $libelle)
    {   
        $sql = "UPDATE compte SET libelleCategorieCompte = ? WHERE IDCategorieCompte=?";
        $this->getDb()->executeUpdate($sql, array( $idCategorieCompte, $libelle));
    }
    
    
}