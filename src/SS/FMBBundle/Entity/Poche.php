<?php

namespace SS\FMBBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Poche
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="SS\FMBBundle\Repository\PocheRepository")
 */
class Poche
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @var integer
     *
     * @ORM\Column(name="quantite", type="integer")
     */
    private $quantite;
    /**
     * @var integer
     *
     * @ORM\Column(name="emplacement", type="integer")
     */
    private $emplacement;
    /**
     * @ORM\ManyToOne(targetEntity="SS\FMBBundle\Entity\StocksLanternes", inversedBy="poches")
     * @ORM\JoinColumn(nullable=false)
     */
    private $stocklanterne;

    public function __toString()
    {
        return "" . $this->id;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->setQuantite(0);
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set quantite
     *
     * @param integer $quantite
     * @return Poche
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;

        return $this;
    }

    /**
     * Get quantite
     *
     * @return integer 
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * Set emplacement
     *
     * @param integer $emplacement
     * @return Poche
     */
    public function setEmplacement($emplacement)
    {
        $this->emplacement = $emplacement;

        return $this;
    }

    /**
     * Get emplacement
     *
     * @return integer 
     */
    public function getEmplacement()
    {
        return $this->emplacement;
    }

    /**
     * Set stocklanterne
     *
     * @param \SS\FMBBundle\Entity\StocksLanternes $stocklanterne
     * @return Poche
     */
    public function setStocklanterne(\SS\FMBBundle\Entity\StocksLanternes $stocklanterne)
    {
        $this->stocklanterne = $stocklanterne;

        return $this;
    }

    /**
     * Get stocklanterne
     *
     * @return \SS\FMBBundle\Entity\StocksLanternes 
     */
    public function getStocklanterne()
    {
        return $this->stocklanterne;
    }
}
