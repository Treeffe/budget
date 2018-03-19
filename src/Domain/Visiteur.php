<?php

namespace budget\Domain;

use Symfony\Component\Security\Core\User\UserInterface;

class Visiteur implements UserInterface
{
    /**
     * Identifiant.
     *
     * @var integer
     */
    private $id;

    /**
     *  .
     *
     * @var string
     */
    private $nom;

    /**Nom
     *
     *
     * @var string
     */
    private $prenom;

    /**prenom.
     *
     *
     * @var string
     */
    private $adresse;

    /**Adresse.
     *
     *
     * @var integer
     */
    private $cp;

    /**Code postal
     *
     *
     * @var String
     */
    private $ville;
    /**
     * Ville
     *
     * @var String
     */


    private $login;

    private $password;
    /**

     * Salt that was originally used to encode the password.

     *

     * @var string

     */

    private $salt;


    /**

     * Role.

     * Values : ROLE_USER or ROLE_ADMIN.

     *

     * @var string

     */

    private $role;


    /**

     * @inheritDoc

     */
    private $username;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }


    public function getNom() {
        return $this->nom;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function getPrenom() {
        return $this->prenom;
    }

    public function setPrenom($prenom) {
        $this->prenom = $prenom;
    }

    public function getAdresse() {
        return $this->adresse;
    }

    public function setAdresse($adresse) {
        $this->adresse = $adresse;
    }

    public function getCp() {
        return $this->cp;
    }

    public function setCp($cp) {
        $this->cp = $cp;
    }

    public function getVille() {
        return $this->ville;
    }

    public function setVille($ville) {
        $this->ville = $ville;
    }

    public function getPwd() {
        return $this->pwd;
    }

    public function setPwd($pwd) {
        $this->pwd = $pwd;
    }

    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
    }


    public function getPassword() {
        return $this->password;

    }

    public function setPassword($password) {

        $this->password = $password;

    }


    /**

     * @inheritDoc

     */

    public function getSalt()

    {

        return $this->salt;

    }


    public function setSalt($salt)

    {

        $this->salt = $salt;

    }


    public function getRole()

    {

        return $this->role;

    }


    public function setRole($role) {

        $this->role = $role;

    }
    /**

     * @inheritDoc

     */

    public function getRoles()

    {

        return array($this->getRole());

    }


    /**

     * @inheritDoc

     */

    public function eraseCredentials() {

        // Nothing to do here

    }
}
