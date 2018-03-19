<?php

namespace budget\DAO;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use budget\Domain\Visiteur;


class VisiteurDAO extends DAO implements UserProviderInterface
{
    
    public function find($id) {
        $sql = "select * from visiteur where idUser=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No user matching id " . $id);
    }

    /**
     * {@inheritDoc}
     */
public function loadUserByUsername($username)

    {
        $sql = "select * from visiteur where loginUser=?";
        $row = $this->getDb()->fetchAssoc($sql, array($username));

        if ($row)

            return $this->buildDomainObject($row);
        else

            throw new UsernameNotFoundException(sprintf('User "%s" not found.', $username));
  }
    /**
    * {@inheritDoc}
    */

    public function refreshUser(UserInterface $visiteur)

    {
        $class = get_class($visiteur);

        if (!$this->supportsClass($class)) {

            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $class));
        }

        return $this->loadUserByUsername($visiteur->getUsername());
  }
    /**
     * {@inheritDoc}
     */
    public function supportsClass($class)
    {
        return 'budget\Domain\Visiteur' === $class;
    }

    /**
     * Creates a User object based on a DB row.
     *
     * @param array $row The DB row containing User data.
     * 
     */
    protected function buildDomainObject($row) {
        $visiteur= new Visiteur();
        $visiteur->setId($row['idUser']);
        $visiteur->setNom($row['nomUser']);
        $visiteur->setPrenom($row['prenomUser']);
        $visiteur->setUsername($row['loginUser']);
        $visiteur->setPassword($row['mdpUser']);
        $visiteur->setSalt($row['salt']);
        $visiteur->setRole($row['role']);
        return $visiteur;
    }
    
   
    public function save(Visiteur $visiteur) {
       
        	 if ($visiteur->getId()) {
              $userData = array(
                 'nom_visiteur' => $visiteur->getNom(),
                 'prenom_visiteur' => $visiteur->getPrenom(),
                 'login_visiteur' => $visiteur->getUsername(),
                 'pwd_visiteur' => $visiteur->getPassword(), 
                 'salt' => $visiteur->getSalt(),
                 'role' => 'role',
                 'adresse_visiteur' => $visiteur->getAdresse(),
                 'cp_visiteur' => $visiteur->getCp(),
                 'ville_visiteur' => $visiteur->getVille());
             // The user has already been saved : update it
             $this->getDb()->update('visiteur', $userData, array('id_visiteur' => $visiteur->getId()));
         } else {
             $userData = array(
          	'nom_visiteur' => $visiteur->getNom(),
          	'prenom_visiteur' => $visiteur->getPrenom(),
              'login_visiteur' => $visiteur->getUsername(),
              'pwd_visiteur' => $visiteur->getPassword(), 
              'salt' => $visiteur->getSalt(),
	    'role' => 'role');
              // The user has never been saved : insert it
				 $this->getDb()->insert('visiteur', $userData);
				 // Get the id of the newly created user and set it on the entity.
              $id = $this->getDb()->lastInsertId();
              $visiteur->setId($id);
			 	}      
											}
}