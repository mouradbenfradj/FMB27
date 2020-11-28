<?php

namespace SS\FMBBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Magasins
 *
 * @ORM\Table(name="magasins", indexes={@ORM\Index(name="id_stock", columns={"id_stock"}), @ORM\Index(name="id_tarif", columns={"id_tarif"}), @ORM\Index(name="actif", columns={"actif"}), @ORM\Index(name="id_mag_enseigne", columns={"id_mag_enseigne"})})
 * @ORM\Entity(repositoryClass="SS\FMBBundle\Repository\ParcRepository")
 */
class Magasins
{
    /**
     * @var string
     *
     * @ORM\Column(name="lib_magasin", type="string", length=64, nullable=false)
     */
    private $libMagasin;

    /**
     * @var string
     *
     * @ORM\Column(name="abrev_magasin", type="string", length=32, nullable=false)
     */
    private $abrevMagasin;

    /**
     * @var string
     *
     * @ORM\Column(name="mode_vente", type="string", nullable=false)
     */
    private $modeVente;

    /**
     * @var boolean
     *
     * @ORM\Column(name="actif", type="boolean", nullable=false)
     */
    private $actif;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_magasin", type="smallint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idMagasin;

    /**
     * @var \SS\FMBBundle\Entity\MagasinsEnseignes
     *
     * @ORM\ManyToOne(targetEntity="SS\FMBBundle\Entity\MagasinsEnseignes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_mag_enseigne", referencedColumnName="id_mag_enseigne")
     * })
     */
    private $idMagEnseigne;

    /**
     * @var \SS\FMBBundle\Entity\TarifsListes
     *
     * @ORM\ManyToOne(targetEntity="SS\FMBBundle\Entity\TarifsListes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_tarif", referencedColumnName="id_tarif")
     * })
     */
    private $idTarif;

    /**
     * @var \SS\FMBBundle\Entity\Stocks
     *
     * @ORM\ManyToOne(targetEntity="SS\FMBBundle\Entity\Stocks")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_stock", referencedColumnName="id_stock")
     * })
     */
    private $idStock;
    /**
     * @ORM\OneToMany(targetEntity="SS\FMBBundle\Entity\Filiere", mappedBy="parc" ,cascade={"persist","remove"},fetch="LAZY")
     * @ORM\OrderBy({"nomFiliere" = "asc"})
     */
    private $filieres;
    /**
     * @ORM\OneToMany(targetEntity="SS\FMBBundle\Entity\Corde", mappedBy="parc" ,cascade={"persist","remove"},fetch="EXTRA_LAZY")
     */
    private $cordes;
    /**
     * @ORM\OneToMany(targetEntity="SS\FMBBundle\Entity\Lanterne", mappedBy="parc" ,cascade={"persist","remove"},fetch="EXTRA_LAZY")
     */
    private $lanternes;
    /**
     * @ORM\OneToMany(targetEntity="SS\FMBBundle\Entity\PochesBS", mappedBy="parc" ,cascade={"persist","remove"},fetch="EXTRA_LAZY")
     */
    private $poches;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->filieres = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return $this->libMagasin;
    }

    /**
     * Get libMagasin
     *
     * @return string
     */
    public function getLibMagasin()
    {
        return $this->libMagasin;
    }

    /**
     * Set libMagasin
     *
     * @param string $libMagasin
     * @return Magasins
     */
    public function setLibMagasin($libMagasin)
    {
        $this->libMagasin = $libMagasin;

        return $this;
    }

    /**
     * Get abrevMagasin
     *
     * @return string
     */
    public function getAbrevMagasin()
    {
        return $this->abrevMagasin;
    }

    /**
     * Set abrevMagasin
     *
     * @param string $abrevMagasin
     * @return Magasins
     */
    public function setAbrevMagasin($abrevMagasin)
    {
        $this->abrevMagasin = $abrevMagasin;

        return $this;
    }

    /**
     * Get modeVente
     *
     * @return string
     */
    public function getModeVente()
    {
        return $this->modeVente;
    }

    /**
     * Set modeVente
     *
     * @param string $modeVente
     * @return Magasins
     */
    public function setModeVente($modeVente)
    {
        $this->modeVente = $modeVente;

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
     * Set actif
     *
     * @param boolean $actif
     * @return Magasins
     */
    public function setActif($actif)
    {
        $this->actif = $actif;

        return $this;
    }

    /**
     * Get idMagasin
     *
     * @return integer
     */
    public function getIdMagasin()
    {
        return $this->idMagasin;
    }

    /**
     * Get idMagEnseigne
     *
     * @return \SS\FMBBundle\Entity\MagasinsEnseignes
     */
    public function getIdMagEnseigne()
    {
        return $this->idMagEnseigne;
    }

    /**
     * Set idMagEnseigne
     *
     * @param \SS\FMBBundle\Entity\MagasinsEnseignes $idMagEnseigne
     * @return Magasins
     */
    public function setIdMagEnseigne(\SS\FMBBundle\Entity\MagasinsEnseignes $idMagEnseigne = null)
    {
        $this->idMagEnseigne = $idMagEnseigne;

        return $this;
    }

    /**
     * Get idTarif
     *
     * @return \SS\FMBBundle\Entity\TarifsListes
     */
    public function getIdTarif()
    {
        return $this->idTarif;
    }

    /**
     * Set idTarif
     *
     * @param \SS\FMBBundle\Entity\TarifsListes $idTarif
     * @return Magasins
     */
    public function setIdTarif(\SS\FMBBundle\Entity\TarifsListes $idTarif = null)
    {
        $this->idTarif = $idTarif;

        return $this;
    }

    /**
     * Get idStock
     *
     * @return \SS\FMBBundle\Entity\Stocks
     */
    public function getIdStock()
    {
        return $this->idStock;
    }

    /**
     * Set idStock
     *
     * @param \SS\FMBBundle\Entity\Stocks $idStock
     * @return Magasins
     */
    public function setIdStock(\SS\FMBBundle\Entity\Stocks $idStock = null)
    {
        $this->idStock = $idStock;

        return $this;
    }

    /**
     * Add filieres
     *
     * @param \SS\FMBBundle\Entity\Filiere $filieres
     * @return Magasins
     */
    public function addFiliere(\SS\FMBBundle\Entity\Filiere $filieres)
    {
        $this->filieres[] = $filieres;

        return $this;
    }

    /**
     * Remove filieres
     *
     * @param \SS\FMBBundle\Entity\Filiere $filieres
     */
    public function removeFiliere(\SS\FMBBundle\Entity\Filiere $filieres)
    {
        $this->filieres->removeElement($filieres);
    }

    /**
     * Get filieres
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFilieres()
    {
        return $this->filieres;
    }

    /**
     * Add cordes
     *
     * @param \SS\FMBBundle\Entity\Corde $cordes
     * @return Magasins
     */
    public function addCorde(\SS\FMBBundle\Entity\Corde $cordes)
    {
        $this->cordes[] = $cordes;

        return $this;
    }

    /**
     * Remove cordes
     *
     * @param \SS\FMBBundle\Entity\Corde $cordes
     */
    public function removeCorde(\SS\FMBBundle\Entity\Corde $cordes)
    {
        $this->cordes->removeElement($cordes);
    }

    /**
     * Get cordes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCordes()
    {
        return $this->cordes;
    }

    /**
     * Add lanternes
     *
     * @param \SS\FMBBundle\Entity\Lanterne $lanternes
     * @return Magasins
     */
    public function addLanterne(\SS\FMBBundle\Entity\Lanterne $lanternes)
    {
        $this->lanternes[] = $lanternes;

        return $this;
    }

    /**
     * Remove lanternes
     *
     * @param \SS\FMBBundle\Entity\Lanterne $lanternes
     */
    public function removeLanterne(\SS\FMBBundle\Entity\Lanterne $lanternes)
    {
        $this->lanternes->removeElement($lanternes);
    }

    /**
     * Get lanternes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLanternes()
    {
        return $this->lanternes;
    }

    /**
     * Add poches
     *
     * @param \SS\FMBBundle\Entity\PochesBS $poches
     * @return Magasins
     */
    public function addPoch(\SS\FMBBundle\Entity\PochesBS $poches)
    {
        $this->poches[] = $poches;

        return $this;
    }

    /**
     * Remove poches
     *
     * @param \SS\FMBBundle\Entity\PochesBS $poches
     */
    public function removePoch(\SS\FMBBundle\Entity\PochesBS $poches)
    {
        $this->poches->removeElement($poches);
    }

    /**
     * Get poches
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPoches()
    {
        return $this->poches;
    }
}
