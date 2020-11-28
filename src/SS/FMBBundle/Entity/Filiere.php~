<?php

namespace SS\FMBBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Filiere
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="SS\FMBBundle\Repository\FiliereRepository")
 */
class Filiere
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
     * @var string
     *
     * @ORM\Column(name="nomFiliere", type="string", length=255)
     */
    private $nomFiliere;

    /**
     * @var array
     *
     * @ORM\Column(name="observation", type="array",nullable=true)
     */
    private $observation = array();
    /**
     * @ORM\ManyToOne(targetEntity="SS\FMBBundle\Entity\Magasins", inversedBy="filieres")
     * @ORM\JoinColumn(name="magasin", referencedColumnName="id_magasin",nullable=false)
     */
    private $parc;
    /**
     * @ORM\OneToMany(targetEntity="SS\FMBBundle\Entity\Segment", mappedBy="filiere" ,cascade={"persist","merge","remove"},fetch="LAZY")
     */
    private $segments;
    /**
     * @var boolean
     *
     * @ORM\Column(name="aireDeTravaille", type="boolean")
     */
    private $aireDeTravaille;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->segments = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add segments
     *
     * @param \SS\FMBBundle\Entity\Segment $segments
     * @return Filiere
     */
    public function addSegment(\SS\FMBBundle\Entity\Segment $segments)
    {
        $this->segments[] = $segments;
        $segments->setFiliere($this);

        return $this;
    }

    /**
     * Remove segments
     *
     * @param \SS\FMBBundle\Entity\Segment $segments
     */
    public function removeSegment(\SS\FMBBundle\Entity\Segment $segments)
    {
        $this->segments->removeElement($segments);
    }

    /**
     * Get segments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSegments()
    {
        return $this->segments;
    }

    public function __toString()
    {
        return $this->getNomFiliere();
    }

    /**
     * Get nomFiliere
     *
     * @return string
     */
    public function getNomFiliere()
    {
        return $this->nomFiliere;
    }

    /**
     * Set nomFiliere
     *
     * @param string $nomFiliere
     * @return Filiere
     */
    public function setNomFiliere($nomFiliere)
    {
        $this->nomFiliere = $nomFiliere;

        return $this;
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
     * @return Filiere
     */
    public function setParc(\SS\FMBBundle\Entity\Magasins $parc)
    {
        $this->parc = $parc;

        return $this;
    }

    /**
     * Get aireDeTravaille
     *
     * @return boolean
     */
    public function getAireDeTravaille()
    {
        return $this->aireDeTravaille;
    }

    /**
     * Set aireDeTravaille
     *
     * @param boolean $aireDeTravaille
     * @return Filiere
     */
    public function setAireDeTravaille($aireDeTravaille)
    {
        $this->aireDeTravaille = $aireDeTravaille;

        return $this;
    }

    /**
     * Set observation
     *
     * @param array $observation
     * @return Filiere
     */
    public function setObservation($observation)
    {
        $this->observation = $observation;

        return $this;
    }

    /**
     * Get observation
     *
     * @return array
     */
    public function getObservation()
    {
        return $this->observation;
    }
}
