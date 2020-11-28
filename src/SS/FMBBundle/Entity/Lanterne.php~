<?php
namespace SS\FMBBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Lanterne
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="SS\FMBBundle\Repository\LanterneRepository")
 */
class Lanterne
{
    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(name="nomLanterne", type="string", length=255)
     */
    private $nomLanterne;
    /**
     * @var integer
     * @ORM\Column(name="nbrpoche", type="integer")
     */
    private $nbrpoche;
    /**
     * @var integer
     * @ORM\Column(name="nbrtotaleEnStock", type="integer")
     */
    private $nbrTotaleEnStock;
    /**
     * @ORM\OneToMany(targetEntity="SS\FMBBundle\Entity\StocksLanternes", mappedBy="lanterne",cascade={"persist","remove"},fetch="EXTRA_LAZY")
     */
    private $stockslanternes;
    /**
     * @ORM\ManyToOne(targetEntity="SS\FMBBundle\Entity\Magasins",inversedBy="lanternes")
     * @ORM\JoinColumn(name="magasin", referencedColumnName="id_magasin",nullable=false)
     */
    private $parc;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->stockslanternes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return $this->getNomLanterne();
    }

    /**
     * Get nomLanterne
     *
     * @return string
     */
    public function getNomLanterne()
    {
        return $this->nomLanterne;
    }

    /**
     * Set nomLanterne
     *
     * @param string $nomLanterne
     * @return Lanterne
     */
    public function setNomLanterne($nomLanterne)
    {
        $this->nomLanterne = $nomLanterne;

        return $this;
    }

    /**
     * Add stockslanternes
     * @param \SS\FMBBundle\Entity\StocksLanternes $stockslanternes
     * @return Lanterne
     */
    public function addStockslanterne(\SS\FMBBundle\Entity\StocksLanternes $stockslanternes)
    {
        $this->stockslanternes[] = $stockslanternes;
        $stockslanternes->setLanterne($this);

        return $this;
    }

    /**
     * Get nbrpoche
     *
     * @return integer
     */
    public function getNbrpoche()
    {
        return $this->nbrpoche;
    }

    /**
     * Set nbrpoche
     *
     * @param integer $nbrpoche
     * @return Lanterne
     */
    public function setNbrpoche($nbrpoche)
    {
        $this->nbrpoche = $nbrpoche;

        return $this;
    }

    /**
     * Remove stockslanternes
     *
     * @param \SS\FMBBundle\Entity\StocksLanternes $stockslanternes
     */
    public function removeStockslanterne(\SS\FMBBundle\Entity\StocksLanternes $stockslanternes)
    {
        $this->stockslanternes->removeElement($stockslanternes);
    }

    /**
     * Get stockslanternes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getStockslanternes()
    {
        return $this->stockslanternes;
    }


    /**
     * Get parc
     *
     * @return \SS\FMBBundle\Entity\Magasins
     */
    public function getParc()
    {
        return $this->parc;
    }

    /**
     * Set parc
     *
     * @param \SS\FMBBundle\Entity\Magasins $parc
     * @return StocksLanternes
     */
    public function setParc(\SS\FMBBundle\Entity\Magasins $parc)
    {
        $this->parc = $parc;

        return $this;
    }

    /**
     * Get nbrTotaleEnStock
     *
     * @return integer
     */
    public function getNbrTotaleEnStock()
    {
        return $this->nbrTotaleEnStock;
    }

    /**
     * Set nbrTotaleEnStock
     *
     * @param integer $nbrTotaleEnStock
     * @return Lanterne
     */
    public function setNbrTotaleEnStock($nbrTotaleEnStock)
    {
        $this->nbrTotaleEnStock = $nbrTotaleEnStock;

        return $this;
    }
}
