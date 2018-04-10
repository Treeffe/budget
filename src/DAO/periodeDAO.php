<?php

namespace budget\DAO;

use budget\Domain\Periode;

class PeriodeDAO extends DAO
{

    /**
     * Renvoie un type à partir de son identifiant
     *
     * @param integer $id L'identifiant du type
     *
     * @return \GSB\Domain\Type|Lève une exception si aucun Type  ne correspond
     */
    public function find($id) {
        $sql = "select * from periode where id = ?";
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
        $periode = new Periode();
        $periode->setID($row['ID']);
        $periode->setLibellePeriode($row['libellePeriode']);
        return $periode;
    }
    
    public function savePeriode($libelle)
	{
		$data = array(
			'libellePeriode' => $libelle
			);
		$this->getDb()->insert('periode', $data);
	}
    
    public function findAllPeriodes() {
        $sql = "SELECT * FROM `periode` order by libellePeriode";
        
        // Convertit les résultats de requête en tableau d'objets du domaine
        $periodes = $this->getDb()->fetchAll($sql);
        foreach ($periodes as $row) {
            if (array_key_exists('id', $row)) {
            $idPeriode = $row['id'];
            $periodes[$idPeriode] = $this->buildDomainObject($row);
            }
        }
        return $periodes;
    }
    
    public function DeletePeriode($id){
        $sql = "DELETE FROM `periode` WHERE ID = ?";
        $this->getDb()->executeQuery($sql, array($id));
    }
    
    public function modificationPeriode($idPeriode, $libelle)
    {   
        $sql = "UPDATE periode SET libellePeriode=? WHERE ID= ?";
        $test = $this->getDb()->executeUpdate($sql, array( $libelle, $idPeriode));
    }
}