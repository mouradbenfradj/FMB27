<?php

namespace SS\FMBBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Emplacement
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="SS\FMBBundle\Repository\EmplacementRepository")
 */
class Emplacement
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
     * @ORM\Column(name="place", type="integer")
     */
    private $place;
    /**
     * @ORM\OneToOne(targetEntity="SS\FMBBundle\Entity\StocksCordes", inversedBy="emplacement",fetch="EAGER")
     * @ORM\JoinColumn(nullable=true)
     */
    private $stockscorde;
    /**
     * @ORM\OneToOne(targetEntity="SS\FMBBundle\Entity\StocksPochesBS", inversedBy="emplacement",fetch="EAGER")
     * @ORM\JoinColumn(nullable=true)
     */
    private $stockspoches;
    /**
     * @ORM\OneToOne(targetEntity="SS\FMBBundle\Entity\StocksLanternes", inversedBy="emplacement")
     * @ORM\JoinColumn(nullable=true,  referencedColumnName="id")
     */
    private $stockslanterne;
    /**
     * @ORM\ManyToOne(targetEntity="SS\FMBBundle\Entity\Flotteur", inversedBy="emplacements",cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $flotteur;
    /**
     *
     * @ORM\Column(name="date_remplissage", type="date",nullable=true)
     */
    private $dateDeRemplissage;

    /**
     * Get place
     *
     * @return integer
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * Set place
     *
     * @param integer $place
     * @return Emplacement
     */
    public function setPlace($place)
    {
        $this->place = $place;

        return $this;
    }

    public function __toString()
    {
        return "".$this->getId();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return "".$this->id;
    }

    /**
     * Get flotteur
     *
     * @return \SS\FMBBundle\Entity\Flotteur
     */
    public function getFlotteur()
    {
        return $this->flotteur;
    }

    /**
     * Set flotteur
     *
     * @param \SS\FMBBundle\Entity\Flotteur $flotteur
     * @return Emplacement
     */
    public function setFlotteur(\SS\FMBBundle\Entity\Flotteur $flotteur)
    {
        $this->flotteur = $flotteur;

        return $this;
    }


    /**
     * Get dateDeRemplissage
     *
     * @return \DateTime
     */
    public function getDateDeRemplissage()
    {
        return $this->dateDeRemplissage;
    }

    /**
     * Set dateDeRemplissage
     *
     * @param \DateTime $dateDeRemplissage
     * @return Emplacement
     */
    public function setDateDeRemplissage($dateDeRemplissage)
    {
        $this->dateDeRemplissage = $dateDeRemplissage;

        return $this;
    }

    /**
     * Get stockslanterne
     *
     * @return \SS\FMBBundle\Entity\StocksLanternes
     */
    public function getStockslanterne()
    {
        return $this->stockslanterne;
    }

    /**
     * Set stockslanterne
     *
     * @param \SS\FMBBundle\Entity\StocksLanternes $stockslanterne
     * @return Emplacement
     */
    public function setStockslanterne(\SS\FMBBundle\Entity\StocksLanternes $stockslanterne = null)
    {
        $this->stockslanterne = $stockslanterne;
        return $this;
    }

    /**
     * Get stockscorde
     *
     * @return \SS\FMBBundle\Entity\StocksCordes
     */
    public function getStockscorde()
    {
        return $this->stockscorde;
    }

    /**
     * Set stockscorde
     *
     * @param \SS\FMBBundle\Entity\StocksCordes $stockscorde
     * @return Emplacement
     */
    public function setStockscorde(\SS\FMBBundle\Entity\StocksCordes $stockscorde = null)
    {
        $this->stockscorde = $stockscorde;

        return $this;
    }


    /**
     * Set stockspoches
     *
     * @param \SS\FMBBundle\Entity\StocksPochesBS $stockspoches
     * @return Emplacement
     */
    public function setStockspoches(\SS\FMBBundle\Entity\StocksPochesBS $stockspoches = null)
    {
        $this->stockspoches = $stockspoches;

        return $this;
    }

    /**
     * Get stockspoches
     *
     * @return \SS\FMBBundle\Entity\StocksPochesBS 
     */
    public function getStockspoches()
    {
        return $this->stockspoches;
    }
}
