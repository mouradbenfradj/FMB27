<?php

namespace SS\FMBBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Civilites
 *
 * @ORM\Table(name="civilites", indexes={@ORM\Index(name="lib_civ_court", columns={"lib_civ_court"}), @ORM\Index(name="lib_civ_long", columns={"lib_civ_long"})})
 * @ORM\Entity
 */
class Civilites
{
    /**
     * @var string
     *
     * @ORM\Column(name="lib_civ_court", type="string", length=16, nullable=false)
     */
    private $libCivCourt;

    /**
     * @var string
     *
     * @ORM\Column(name="lib_civ_long", type="string", length=64, nullable=false)
     */
    private $libCivLong;

    /**
     * @var string
     *
     * @ORM\Column(name="categorie", type="string", nullable=false)
     */
    private $categorie;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_civilite", type="smallint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCivilite;



    /**
     * Set libCivCourt
     *
     * @param string $libCivCourt
     * @return Civilites
     */
    public function setLibCivCourt($libCivCourt)
    {
        $this->libCivCourt = $libCivCourt;

        return $this;
    }

    /**
     * Get libCivCourt
     *
     * @return string 
     */
    public function getLibCivCourt()
    {
        return $this->libCivCourt;
    }

    /**
     * Set libCivLong
     *
     * @param string $libCivLong
     * @return Civilites
     */
    public function setLibCivLong($libCivLong)
    {
        $this->libCivLong = $libCivLong;

        return $this;
    }

    /**
     * Get libCivLong
     *
     * @return string 
     */
    public function getLibCivLong()
    {
        return $this->libCivLong;
    }

    /**
     * Set categorie
     *
     * @param string $categorie
     * @return Civilites
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return string 
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * Get idCivilite
     *
     * @return integer 
     */
    public function getIdCivilite()
    {
        return $this->idCivilite;
    }
}
