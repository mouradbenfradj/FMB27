<?php

namespace SS\FMBBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TarifsListes
 *
 * @ORM\Table(name="tarifs_listes")
 * @ORM\Entity
 */
class TarifsListes
{
    /**
     * @var string
     *
     * @ORM\Column(name="lib_tarif", type="string", length=32, nullable=false)
     */
    private $libTarif;

    /**
     * @var string
     *
     * @ORM\Column(name="desc_tarif", type="text", length=16777215, nullable=false)
     */
    private $descTarif;

    /**
     * @var string
     *
     * @ORM\Column(name="marge_moyenne", type="string", length=32, nullable=false)
     */
    private $margeMoyenne;

    /**
     * @var integer
     *
     * @ORM\Column(name="ordre", type="smallint", nullable=false)
     */
    private $ordre;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_tarif", type="smallint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idTarif;



    /**
     * Set libTarif
     *
     * @param string $libTarif
     * @return TarifsListes
     */
    public function setLibTarif($libTarif)
    {
        $this->libTarif = $libTarif;

        return $this;
    }

    /**
     * Get libTarif
     *
     * @return string 
     */
    public function getLibTarif()
    {
        return $this->libTarif;
    }

    /**
     * Set descTarif
     *
     * @param string $descTarif
     * @return TarifsListes
     */
    public function setDescTarif($descTarif)
    {
        $this->descTarif = $descTarif;

        return $this;
    }

    /**
     * Get descTarif
     *
     * @return string 
     */
    public function getDescTarif()
    {
        return $this->descTarif;
    }

    /**
     * Set margeMoyenne
     *
     * @param string $margeMoyenne
     * @return TarifsListes
     */
    public function setMargeMoyenne($margeMoyenne)
    {
        $this->margeMoyenne = $margeMoyenne;

        return $this;
    }

    /**
     * Get margeMoyenne
     *
     * @return string 
     */
    public function getMargeMoyenne()
    {
        return $this->margeMoyenne;
    }

    /**
     * Set ordre
     *
     * @param integer $ordre
     * @return TarifsListes
     */
    public function setOrdre($ordre)
    {
        $this->ordre = $ordre;

        return $this;
    }

    /**
     * Get ordre
     *
     * @return integer 
     */
    public function getOrdre()
    {
        return $this->ordre;
    }

    /**
     * Get idTarif
     *
     * @return integer 
     */
    public function getIdTarif()
    {
        return $this->idTarif;
    }
}
