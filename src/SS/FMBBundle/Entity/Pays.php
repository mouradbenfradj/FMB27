<?php

namespace SS\FMBBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pays
 *
 * @ORM\Table(name="pays", uniqueConstraints={@ORM\UniqueConstraint(name="pays", columns={"pays"})})
 * @ORM\Entity
 */
class Pays
{
    /**
     * @var string
     *
     * @ORM\Column(name="pays", type="string", length=64, nullable=false)
     */
    private $pays;

    /**
     * @var string
     *
     * @ORM\Column(name="code_pays", type="string", length=2, nullable=false)
     */
    private $codePays;

    /**
     * @var boolean
     *
     * @ORM\Column(name="defaut_id_langage", type="boolean", nullable=false)
     */
    private $defautIdLangage;

    /**
     * @var boolean
     *
     * @ORM\Column(name="use_etat", type="boolean", nullable=false)
     */
    private $useEtat;

    /**
     * @var boolean
     *
     * @ORM\Column(name="affichage", type="boolean", nullable=false)
     */
    private $affichage;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_pays", type="smallint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPays;



    /**
     * Set pays
     *
     * @param string $pays
     * @return Pays
     */
    public function setPays($pays)
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * Get pays
     *
     * @return string 
     */
    public function getPays()
    {
        return $this->pays;
    }

    /**
     * Set codePays
     *
     * @param string $codePays
     * @return Pays
     */
    public function setCodePays($codePays)
    {
        $this->codePays = $codePays;

        return $this;
    }

    /**
     * Get codePays
     *
     * @return string 
     */
    public function getCodePays()
    {
        return $this->codePays;
    }

    /**
     * Set defautIdLangage
     *
     * @param boolean $defautIdLangage
     * @return Pays
     */
    public function setDefautIdLangage($defautIdLangage)
    {
        $this->defautIdLangage = $defautIdLangage;

        return $this;
    }

    /**
     * Get defautIdLangage
     *
     * @return boolean 
     */
    public function getDefautIdLangage()
    {
        return $this->defautIdLangage;
    }

    /**
     * Set useEtat
     *
     * @param boolean $useEtat
     * @return Pays
     */
    public function setUseEtat($useEtat)
    {
        $this->useEtat = $useEtat;

        return $this;
    }

    /**
     * Get useEtat
     *
     * @return boolean 
     */
    public function getUseEtat()
    {
        return $this->useEtat;
    }

    /**
     * Set affichage
     *
     * @param boolean $affichage
     * @return Pays
     */
    public function setAffichage($affichage)
    {
        $this->affichage = $affichage;

        return $this;
    }

    /**
     * Get affichage
     *
     * @return boolean 
     */
    public function getAffichage()
    {
        return $this->affichage;
    }

    /**
     * Get idPays
     *
     * @return integer 
     */
    public function getIdPays()
    {
        return $this->idPays;
    }
}
