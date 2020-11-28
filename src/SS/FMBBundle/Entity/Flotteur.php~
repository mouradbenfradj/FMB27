<?php

namespace SS\FMBBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Flotteur
 *
 * @ORM\Table()
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="SS\FMBBundle\Repository\FlotteurRepository")
 */
class Flotteur
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
     * @ORM\Column(name="nomFlotteur", type="string", length=255)
     */
    private $nomFlotteur;

    /**
     * @ORM\ManyToOne(targetEntity="SS\FMBBundle\Entity\Segment", inversedBy="flotteurs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $segment;

    /**
     * @ORM\OneToMany(targetEntity="SS\FMBBundle\Entity\Emplacement", mappedBy="flotteur",cascade={"persist","remove"},fetch="LAZY")
     */
    private $emplacements;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->emplacements = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @ORM\PrePersist
     */
    public function generateEmplacement()
    {
        for ($j = 1; $j < 11; $j++) {
            $emplacement = new Emplacement();
            $emplacement->setPlace($j);
            $this->addEmplacement($emplacement);
        }
    }

    /**
     * Add emplacements
     *
     * @param \SS\FMBBundle\Entity\Emplacement $emplacements
     * @return Flotteur
     */
    public function addEmplacement(\SS\FMBBundle\Entity\Emplacement $emplacements)
    {
        $this->emplacements[] = $emplacements;
        $emplacements->setFlotteur($this);

        return $this;
    }

    public function __toString()
    {
        return $this->nomFlotteur;
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
     * Get nomFlotteur
     *
     * @return string
     */
    public function getNomFlotteur()
    {
        return $this->nomFlotteur;
    }

    /**
     * Set nomFlotteur
     *
     * @param string $nomFlotteur
     * @return Flotteur
     */
    public function setNomFlotteur($nomFlotteur)
    {
        $this->nomFlotteur = $nomFlotteur;

        return $this;
    }

    /**
     * Get segment
     *
     * @return \SS\FMBBundle\Entity\Segment
     */
    public function getSegment()
    {
        return $this->segment;
    }

    /**
     * Set segment
     *
     * @param \SS\FMBBundle\Entity\Segment $segment
     * @return Flotteur
     */
    public function setSegment(\SS\FMBBundle\Entity\Segment $segment)
    {
        $this->segment = $segment;
        return $this;
    }

    /**
     * Remove emplacements
     *
     * @param \SS\FMBBundle\Entity\Emplacement $emplacements
     */
    public function removeEmplacement(\SS\FMBBundle\Entity\Emplacement $emplacements)
    {
        $this->emplacements->removeElement($emplacements);
    }

    /**
     * Get emplacements
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEmplacements()
    {
        return $this->emplacements;
    }
}
