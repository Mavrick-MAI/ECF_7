<?php

namespace WebAppSeller\Models;

use Phalcon\Validation;
use Phalcon\Validation\Validator\InclusionIn;

class Composant extends \Phalcon\Mvc\Model
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
     * @Column(column="id_module", type="integer", nullable=true)
     */
    protected $id_module;

    /**
     *
     * @var string
     * @Column(column="libelle", type="string", length=100, nullable=false)
     */
    protected $libelle;

    /**
     *
     * @var string
     * @Column(column="type", type="string", length='1','2','3', nullable=false)
     */
    protected $type;

    /**
     *
     * @var integer
     * @Column(column="charge", type="integer", nullable=false)
     */
    protected $charge;

    /**
     *
     * @var integer
     * @Column(column="progression", type="integer", nullable=true)
     */
    protected $progression;

    const _TYPE_1_FRONTEND_ = 1;
    const _TYPE_2_BACKEND_ = 2;
    const _TYPE_3_DATABASE_ = 3;

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
     * Method to set the value of field charge
     *
     * @param integer $charge
     * @return $this
     */
    public function setCharge($charge)
    {
        $this->charge = $charge;

        return $this;
    }

    /**
     * Method to set the value of field progression
     *
     * @param integer $progression
     * @return $this
     */
    public function setProgression($progression)
    {
        $this->progression = $progression;

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
     * Returns the value of field id_module
     *
     * @return integer
     */
    public function getIdModule()
    {
        return $this->id_module;
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
     * Returns the value of field type
     *
     * @return string
     */
    public function getType()
    {
        return intval($this->type);
    }

    /**
     * @return string
     */
    public function getTypeLibelle(): string
    {
        switch ($this->getType())
        {
            case self::_TYPE_1_FRONTEND_ : return "FRONTEND";
            case self::_TYPE_2_BACKEND_ : return "BACKEND";
            case self::_TYPE_3_DATABASE_ : return "DATABASE";
            default: return 'Type unknown';
        }
    }

    /**
     * Returns the value of field charge
     *
     * @return integer
     */
    public function getCharge()
    {
        return $this->charge;
    }

    /**
     * Returns the value of field progression
     *
     * @return integer
     */
    public function getProgression()
    {
        return $this->progression;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("ecf_7");
        $this->setSource("composant");
        $this->belongsTo('id_module', 'WebAppSeller\Models\Module', 'id', ['alias' => 'Module']);
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Composant[]|Composant|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Composant|\Phalcon\Mvc\Model\ResultInterface|\Phalcon\Mvc\ModelInterface|null
     */
    public static function findFirst($parameters = null): ?\Phalcon\Mvc\ModelInterface
    {
        return parent::findFirst($parameters);
    }

    /**
     * @return bool
     */
    public function validation(): bool
    {
        $validator = new Validation();
        $this->add = $validator->add(
            'type',
            new InclusionIn(
                [
                    'template' => "Le champ :field doit avoir une valeur comprise entre 1 et 3",
                    'message' => "Le champ :field doit avoir une valeur comprise entre 1 et 3",
                    'domain' => [
                        self::_TYPE_1_FRONTEND_,
                        self::_TYPE_2_BACKEND_,
                        self::_TYPE_3_DATABASE_,
                    ],
                ]
            )
        );
        return $this->validate($validator);
    }
}
