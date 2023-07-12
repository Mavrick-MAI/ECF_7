<?php

namespace WebAppSeller\Models;

class Module extends \Phalcon\Mvc\Model
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
     * @Column(column="id_application", type="integer", nullable=false)
     */
    protected $id_application;

    /**
     *
     * @var string
     * @Column(column="libelle", type="string", length=100, nullable=false)
     */
    protected $libelle;

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
     * Method to set the value of field libelle
     *
     * @param string $libelle
     * @return $this
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

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
     * Returns the value of field id_application
     *
     * @return integer
     */
    public function getIdApplication()
    {
        return $this->id_application;
    }

    /**
     * Returns the value of field libelle
     *
     * @return string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("ecf_7");
        $this->setSource("module");
        $this->hasMany('id', 'WebAppSeller\Models\Composant', 'id_module', ['alias' => 'Composant']);
        $this->belongsTo('id_application', 'WebAppSeller\Models\Application', 'id', ['alias' => 'Application']);
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Module[]|Module|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Module|\Phalcon\Mvc\Model\ResultInterface|\Phalcon\Mvc\ModelInterface|null
     */
    public static function findFirst($parameters = null): ?\Phalcon\Mvc\ModelInterface
    {
        return parent::findFirst($parameters);
    }

}
