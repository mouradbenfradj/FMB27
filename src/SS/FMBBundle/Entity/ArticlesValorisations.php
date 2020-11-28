<?php

namespace SS\FMBBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ArticlesValorisations
 *
 * @ORM\Table(name="articles_valorisations")
 * @ORM\Entity
 */
class ArticlesValorisations
{
    /**
     * @var string
     *
     * @ORM\Column(name="groupe", type="string", nullable=false)
     */
    private $groupe;

    /**
     * @var string
     *
     * @ORM\Column(name="lib_valo", type="string", length=64, nullable=false)
     */
    private $libValo;

    /**
     * @var string
     *
     * @ORM\Column(name="abrev_valo", type="string", length=6, nullable=false)
     */
    private $abrevValo;

    /**
     * @var boolean
     *
     * @ORM\Column(name="popup", type="boolean", nullable=false)
     */
    private $popup;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_valo", type="smallint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idValo;



    /**
     * Set groupe
     *
     * @param string $groupe
     * @return ArticlesValorisations
     */
    public function setGroupe($groupe)
    {
        $this->groupe = $groupe;

        return $this;
    }

    /**
     * Get groupe
     *
     * @return string 
     */
    public function getGroupe()
    {
        return $this->groupe;
    }

    /**
     * Set libValo
     *
     * @param string $libValo
     * @return ArticlesValorisations
     */
    public function setLibValo($libValo)
    {
        $this->libValo = $libValo;

        return $this;
    }

    /**
     * Get libValo
     *
     * @return string 
     */
    public function getLibValo()
    {
        return $this->libValo;
    }

    /**
     * Set abrevValo
     *
     * @param string $abrevValo
     * @return ArticlesValorisations
     */
    public function setAbrevValo($abrevValo)
    {
        $this->abrevValo = $abrevValo;

        return $this;
    }

    /**
     * Get abrevValo
     *
     * @return string 
     */
    public function getAbrevValo()
    {
        return $this->abrevValo;
    }

    /**
     * Set popup
     *
     * @param boolean $popup
     * @return ArticlesValorisations
     */
    public function setPopup($popup)
    {
        $this->popup = $popup;

        return $this;
    }

    /**
     * Get popup
     *
     * @return boolean 
     */
    public function getPopup()
    {
        return $this->popup;
    }

    /**
     * Get idValo
     *
     * @return integer 
     */
    public function getIdValo()
    {
        return $this->idValo;
    }
}
