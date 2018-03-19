<?php

namespace budget\DAO;

use budget\Domain\CategorieTransaction;

class CategorieTransactionDAO extends DAO
{

    /**
     * Renvoie un type à partir de son identifiant
     *
     * @param integer $id L'identifiant du type
     *
     * @return \GSB\Domain\Type|Lève une exception si aucun Type  ne correspond
     */
    public function find($id) {
        $sql = "select * from categorieTransaction where id = ?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("Aucune categorie de transaction n'a été trouvé");
            //throw new \Exception("aucun ".$id);
        
    }

    /**
     * Crée un objet Type à partir d'une ligne de résultat BD
     *
     * @param array $row La ligne de résultat BD
     *
     * @return \GSB\Domain\Type
     */
    protected function buildDomainObject($row) {
        $categorie = new CategorieTransaction();
        $categorie->setID($row['ID']);
        $categorie->setLibelleCategorieTransaction($row['libelleCategorieTansaction']);
        return $categorie;
    }
    
    public function saveCategorieTransaction($libelle)
	{
		$data = array(
			'libelleCategorieTansaction' => $libelle
			);
		$this->getDb()->insert('categorieTransaction', $data);
	}
    
    public function findAllCategoriesTransactions() {
        $sql = "SELECT * FROM `categorieTransaction` order by libelleCategorieTansaction";
        
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
    
    
}