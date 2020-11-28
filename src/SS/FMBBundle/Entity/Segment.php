<?php

namespace SS\FMBBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Segment
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="SS\FMBBundle\Repository\SegmentRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Segment
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
     * @ORM\Column(name="nomSegment", type="string", length=255)
     */
    private $nomSegment;
    /**
     * @var float
     *
     * @ORM\Column(name="longeur", type="decimal",scale=2)
     */
    private $longeur;

    /**
     * @ORM\ManyToOne(targetEntity="SS\FMBBundle\Entity\Filiere", inversedBy="segments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $filiere;
    /**
     * @ORM\OneToMany(targetEntity="SS\FMBBundle\Entity\Flotteur", mappedBy="segment",cascade={"persist","merge","remove"},fetch="LAZY")
     */
    private $flotteurs;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->flotteurs = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return $this->filiere . ' ' . $this->getNomSegment();
    }

    /**
     * Get nomSegment
     *
     * @return string
     */
    public function getNomSegment()
    {
        return $this->nomSegment;
    }

    /**
     * Set nomSegment
     *
     * @param string $nomSegment
     * @return Segment
     */
    public function setNomSegment($nomSegment)
    {
        $this->nomSegment = $nomSegment;

        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function generateFlotteur()
    {
        $nb = $this->getLongeur() / 5;
        for ($i = 0; $i < $nb; $i++) {
            $flotteur = new Flotteur();
            $flotteur->setNomFlotteur($this->nomSegment . $i);
            $this->addFlotteur($flotteur);
        }
    }

    /**
     * Get longeur
     *
     * @return string
     */
    public function getLongeur()
    {
        return $this->longeur;
    }

    /**
     * Set longeur
     *
     * @param string $longeur
     * @return Segment
     */
    public function setLongeur($longeur)
    {
        $this->longeur = $longeur;

        return $this;
    }

    /**
     * Add flotteurs
     *
     * @param \SS\FMBBundle\Entity\Flotteur $flotteurs
     * @return Segment
     */
    public function addFlotteur(\SS\FMBBundle\Entity\Flotteur $flotteurs)
    {
        $this->flotteurs[] = $flotteurs;
        $flotteurs->setSegment($this);
        return $this;
    }

    /**
     * @ORM\PostUpdate()
     */
    public function correcteurFlotteur()
    {
        $annb = count($this->flotteurs);
        $nb = (($this->getLongeur() / 5) - count($this->flotteurs));
        if ($nb > 0) {
            for ($i = ($annb - 1); $i < ($annb + $nb); $i++) {
                $flotteur = new Flotteur();
                $flotteur->setNomFlotteur($this->nomSegment . $i);
                $this->addFlotteur($flotteur);
            }
        } else {
            var_dump($nb);
        }
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
     * Get filiere
     *
     * @return \SS\FMBBundle\Entity\Filiere
     */
    public function getFiliere()
    {
        return $this->filiere;
    }

    /**
     * Set filiere
     *
     * @param \SS\FMBBundle\Entity\Filiere $filiere
     * @return Segment
     */
    public function setFiliere(\SS\FMBBundle\Entity\Filiere $filiere)
    {
        $this->filiere = $filiere;

        return $this;
    }

    /**
     * Remove flotteurs
     *
     * @param \SS\FMBBundle\Entity\Flotteur $flotteurs
     */
    public function removeFlotteur(\SS\FMBBundle\Entity\Flotteur $flotteurs)
    {
        $this->flotteurs->removeElement($flotteurs);
    }

    /**
     * Get flotteurs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFlotteurs()
    {
        return $this->flotteurs;
    }
}
