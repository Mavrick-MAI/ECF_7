<?php

namespace WebAppSeller\Models;

class Projet extends \Phalcon\Mvc\Model
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
     * @var integer
     * @Column(column="id_client", type="integer", nullable=false)
     */
    protected $id_client;

    /**
     *
     * @var integer
     * @Column(column="id_developpeur", type="integer", nullable=true)
     */
    protected $id_developpeur;

    /**
     *
     * @var integer
     * @Column(column="id_chef_de_projet", type="integer", nullable=true)
     */
    protected $id_chef_de_projet;

    /**
     *
     * @var string
     * @Column(column="type", type="string", length='1','2','3', nullable=false)
     */
    protected $type;

    /**
     *
     * @var integer
     * @Column(column="id_application", type="integer", nullable=true)
     */
    protected $id_application;

    /**
     *
     * @var integer
     * @Column(column="id_module", type="integer", nullable=true)
     */
    protected $id_module;

    /**
     *
     * @var integer
     * @Column(column="id_composant", type="integer", nullable=true)
     */
    protected $id_composant;

    /**
     *
     * @var integer
     * @Column(column="prix", type="integer", nullable=false)
     */
    protected $prix;

    /**
     *
     * @var string
     * @Column(column="statut", type="string", length='0','1','2','3','4', nullable=false)
     */
    protected $statut;

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
     * Method to set the value of field id_client
     *
     * @param integer $id_client
     * @return $this
     */
    public function setIdClient($id_client)
    {
        $this->id_client = $id_client;

        return $this;
    }

    /**
     * Method to set the value of field id_developpeur
     *
     * @param integer $id_developpeur
     * @return $this
     */
    public function setIdDeveloppeur($id_developpeur)
    {
        $this->id_developpeur = $id_developpeur;

        return $this;
    }

    /**
     * Method to set the value of field id_chef_de_projet
     *
     * @param integer $id_chef_de_projet
     * @return $this
     */
    public function setIdChefDeProjet($id_chef_de_projet)
    {
        $this->id_chef_de_projet = $id_chef_de_projet;

        return $this;
    }

    /**
     * Method to set the value of field type
     *
     * @param string $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Method to set the value of field id_application
     *
     * @param integer $id_application
     * @return $this
     */
    public function setIdApplication($id_application)
    {
        $this->id_application = $id_application;

        return $this;
    }

    /**
     * Method to set the value of field id_module
     *
     * @param integer $id_module
     * @return $this
     */
    public function setIdModule($id_module)
    {
        $this->id_module = $id_module;

        return $this;
    }

    /**
     * Method to set the value of field id_composant
     *
     * @param integer $id_composant
     * @return $this
     */
    public function setIdComposant($id_composant)
    {
        $this->id_composant = $id_composant;

        return $this;
    }

    /**
     * Method to set the value of field prix
     *
     * @param integer $prix
     * @return $this
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Method to set the value of field statut
     *
     * @param string $statut
     * @return $this
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;

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
     * Returns the value of field id_client
     *
     * @return integer
     */
    public function getIdClient()
    {
        return $this->id_client;
    }

    /**
     * Returns the value of field id_developpeur
     *
     * @return integer
     */
    public function getIdDeveloppeur()
    {
        return $this->id_developpeur;
    }

    /**
     * Returns the value of field id_chef_de_projet
     *
     * @return integer
     */
    public function getIdChefDeProjet()
    {
        return $this->id_chef_de_projet;
    }

    /**
     * Returns the value of field type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Returns the value of field id_application
     *
     * @return integer
     */
    public function getIdApplication()
    {
        return $this->id_application;
    }

    /**
     * Returns the value of field id_module
     *
     * @return integer
     */
    public function getIdModule()
    {
        return $this->id_module;
    }

    /**
     * Returns the value of field id_composant
     *
     * @return integer
     */
    public function getIdComposant()
    {
        return $this->id_composant;
    }

    /**
     * Returns the value of field prix
     *
     * @return integer
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Returns the value of field statut
     *
     * @return string
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("ecf_7");
        $this->setSource("projet");
        $this->belongsTo('id_chef_de_projet', 'WebAppSeller\Models\ChefDeProjet', 'id', ['alias' => 'ChefDeProjet']);
        $this->belongsTo('id_client', 'WebAppSeller\Models\Client', 'id', ['alias' => 'Client']);
        $this->belongsTo('id_developpeur', 'WebAppSeller\Models\Developpeur', 'id', ['alias' => 'Developpeur']);
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Projet[]|Projet|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Projet|\Phalcon\Mvc\Model\ResultInterface|\Phalcon\Mvc\ModelInterface|null
     */
    public static function findFirst($parameters = null): ?\Phalcon\Mvc\ModelInterface
    {
        return parent::findFirst($parameters);
    }

}
