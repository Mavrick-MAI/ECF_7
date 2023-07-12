<?php

namespace WebAppSeller\Models;

class Collaborateur extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(column="id", type="integer", nullable=false)
     */
    protected $id;

    /**
     *
     * @var string
     * @Column(column="nom", type="string", length=20, nullable=false)
     */
    protected $nom;

    /**
     *
     * @var string
     * @Column(column="prenom", type="string", length=30, nullable=false)
     */
    protected $prenom;

    /**
     *
     * @var string
     * @Column(column="niveau", type="string", length='1','2','3', nullable=false)
     */
    protected $niveau;

    /**
     *
     * @var integer
     * @Column(column="prime_embauche", type="integer", nullable=false)
     */
    protected $prime_embauche;

    /**
     * Method to set the value of field id
     *
     * @param integer $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Method to set the value of field nom
     *
     * @param string $nom
     * @return $this
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Method to set the value of field prenom
     *
     * @param string $prenom
     * @return $this
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Method to set the value of field niveau
     *
     * @param string $niveau
     * @return $this
     */
    public function setNiveau($niveau)
    {
        $this->niveau = $niveau;

        return $this;
    }

    /**
     * Method to set the value of field prime_embauche
     *
     * @param integer $prime_embauche
     * @return $this
     */
    public function setPrimeEmbauche($prime_embauche)
    {
        $this->prime_embauche = $prime_embauche;

        return $this;
    }

    /**
     * Returns the value of field id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the value of field nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Returns the value of field prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Returns the value of field niveau
     *
     * @return string
     */
    public function getNiveau()
    {
        return $this->niveau;
    }

    /**
     * Returns the value of field prime_embauche
     *
     * @return integer
     */
    public function getPrimeEmbauche()
    {
        return $this->prime_embauche;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("ecf_7");
        $this->setSource("collaborateur");
        $this->hasMany('id', 'WebAppSeller\Models\ChefDeProjet', 'id_collaborateur', ['alias' => 'ChefDeProjet']);
        $this->hasMany('id', 'WebAppSeller\Models\Developpeur', 'id_collaborateur', ['alias' => 'Developpeur']);
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Collaborateur[]|Collaborateur|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Collaborateur|\Phalcon\Mvc\Model\ResultInterface|\Phalcon\Mvc\ModelInterface|null
     */
    public static function findFirst($parameters = null): ?\Phalcon\Mvc\ModelInterface
    {
        return parent::findFirst($parameters);
    }

}
