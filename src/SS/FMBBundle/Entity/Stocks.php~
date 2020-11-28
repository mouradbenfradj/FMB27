<?php

namespace SS\FMBBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Stocks
 *
 * @ORM\Table(name="stocks", indexes={@ORM\Index(name="actif", columns={"actif"}), @ORM\Index(name="ref_adr_stock", columns={"ref_adr_stock"})})
 * @ORM\Entity
 */
class Stocks
{
    /**
     * @var string
     *
     * @ORM\Column(name="lib_stock", type="string", length=32, nullable=false)
     */
    private $libStock;

    /**
     * @var string
     *
     * @ORM\Column(name="abrev_stock", type="string", length=32, nullable=false)
     */
    private $abrevStock;

    /**
     * @var boolean
     *
     * @ORM\Column(name="actif", type="boolean", nullable=false)
     */
    private $actif;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_stock", type="smallint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idStock;

    /**
     * @var \SS\FMBBundle\Entity\Adresses
     *
     * @ORM\ManyToOne(targetEntity="SS\FMBBundle\Entity\Adresses")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ref_adr_stock", referencedColumnName="ref_adresse")
     * })
     */
    private $refAdrStock;

    public function __toString()
    {
        return $this->libStock;
    }


    /**
     * Set libStock
     *
     * @param string $libStock
     * @return Stocks
     */
    public function setLibStock($libStock)
    {
        $this->libStock = $libStock;

        return $this;
    }

    /**
     * Get libStock
     *
     * @return string
     */
    public function getLibStock()
    {
        return $this->libStock;
    }

    /**
     * Set abrevStock
     *
     * @param string $abrevStock
     * @return Stocks
     */
    public function setAbrevStock($abrevStock)
    {
        $this->abrevStock = $abrevStock;

        return $this;
    }

    /**
     * Get abrevStock
     *
     * @return string
     */
    public function getAbrevStock()
    {
        return $this->abrevStock;
    }

    /**
     * Set actif
     *
     * @param boolean $actif
     * @return Stocks
     */
    public function setActif($actif)
    {
        $this->actif = $actif;

        return $this;
    }

    /**
     * Get actif
     *
     * @return boolean
     */
    public function getActif()
    {
        return $this->actif;
    }

    /**
     * Get idStock
     *
     * @return integer
     */
    public function getIdStock()
    {
        return $this->idStock;
    }

    /**
     * Set refAdrStock
     *
     * @param \SS\FMBBundle\Entity\Adresses $refAdrStock
     * @return Stocks
     */
    public function setRefAdrStock(\SS\FMBBundle\Entity\Adresses $refAdrStock = null)
    {
        $this->refAdrStock = $refAdrStock;

        return $this;
    }

    /**
     * Get refAdrStock
     *
     * @return \SS\FMBBundle\Entity\Adresses
     */
    public function getRefAdrStock()
    {
        return $this->refAdrStock;
    }
}
