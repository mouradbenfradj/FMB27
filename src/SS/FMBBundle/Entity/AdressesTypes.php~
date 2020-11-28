<?php

namespace SS\FMBBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AdressesTypes
 *
 * @ORM\Table(name="adresses_types")
 * @ORM\Entity
 */
class AdressesTypes
{
    /**
     * @var string
     *
     * @ORM\Column(name="adresse_type", type="string", length=64, nullable=false)
     */
    private $adresseType;

    /**
     * @var integer
     *
     * @ORM\Column(name="defaut", type="smallint", nullable=false)
     */
    private $defaut;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_adresse_type", type="smallint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idAdresseType;



    /**
     * Set adresseType
     *
     * @param string $adresseType
     * @return AdressesTypes
     */
    public function setAdresseType($adresseType)
    {
        $this->adresseType = $adresseType;

        return $this;
    }

    /**
     * Get adresseType
     *
     * @return string 
     */
    public function getAdresseType()
    {
        return $this->adresseType;
    }

    /**
     * Set defaut
     *
     * @param integer $defaut
     * @return AdressesTypes
     */
    public function setDefaut($defaut)
    {
        $this->defaut = $defaut;

        return $this;
    }

    /**
     * Get defaut
     *
     * @return integer 
     */
    public function getDefaut()
    {
        return $this->defaut;
    }

    /**
     * Get idAdresseType
     *
     * @return integer 
     */
    public function getIdAdresseType()
    {
        return $this->idAdresseType;
    }
}
