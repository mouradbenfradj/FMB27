<?php

namespace SS\FMBBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * Processus
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="SS\FMBBundle\Repository\ProcessusRepository")
 * @UniqueEntity(
 *     fields={"idProcessusParent", "id"}
 * )
 */
class Processus
{
    /**
     * @var integer
     *
     * @ORM\Column(name="numeroDebCycle", type="integer", nullable=false)
     */
    private $numeroDebCycle;
    /**
     * @var integer
     *
     * @ORM\Column(name="limiteDuCycle", type="integer", nullable=false)
     */
    private $limiteDuCycle;

    /**
     * @var string
     *
     * @ORM\Column(name="nomProcessus", type="string", length=255, nullable=false)
     */
    private $nomProcessus;
    /**
     * @var string
     *
     * @ORM\Column(name="abrevProcessus", type="string", length=255, nullable=false)
     *
     */
    private $abrevProcessus;
    /**
     * @var array
     *
     * @ORM\Column(name="duree", type="array", nullable=false)
     */
    private $duree = array();
    /**
     * @var array
     *
     * @ORM\Column(name="alerteRougeJours", type="array", nullable=false)
     */
    private $alerteRouge = array();

    /**
     * @var array
     *
     * @ORM\Column(name="alerteJauneJours", type="array", nullable=false)
     */
    private $alerteJaune = array();

    /**
     * @var string
     *
     * @ORM\Column(name="couleur", type="string", nullable=false)
     */
    private $couleur;
    /**
     * @var string
     *
     * @ORM\Column(name="couleurDuFond", type="string", nullable=false)
     */
    private $couleurDuFond;

    /**
     * @var string
     *
     * @ORM\Column(name="articleSortie", type="string", nullable=false)
     */
    private $articleSortie;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @var \SS\FMBBundle\Entity\Processus
     *
     * @ORM\ManyToOne(targetEntity="SS\FMBBundle\Entity\Processus", inversedBy="idProcessusSuivant",fetch="LAZY")
     */
    private $idProcessusParent;
    /**
     * @var \SS\FMBBundle\Entity\Processus
     *
     * @ORM\OneToOne(targetEntity="SS\FMBBundle\Entity\Processus", mappedBy="idProcessusParent",fetch="LAZY")
     */
    private $idProcessusSuivant;

    /**
     * @var \SS\FMBBundle\Entity\Articles
     *
     * @ORM\ManyToOne(targetEntity="SS\FMBBundle\Entity\Articles")
     * @ORM\JoinColumn(name="ref_article", referencedColumnName="ref_article", nullable=false)
     */
    private $articleDebut;
    /**
     * @var \SS\FMBBundle\Entity\Phases
     *
     * @ORM\ManyToOne(targetEntity="SS\FMBBundle\Entity\Phases")
     * @ORM\JoinColumn(nullable=false)
     */
    private $phasesProcessus;

    public function __toString()
    {
        return $this->nomProcessus;
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
     * Set numeroDebCycle
     *
     * @param integer $numeroDebCycle
     * @return Processus
     */
    public function setNumeroDebCycle($numeroDebCycle)
    {
        $this->numeroDebCycle = $numeroDebCycle;

        return $this;
    }

    /**
     * Get numeroDebCycle
     *
     * @return integer
     */
    public function getNumeroDebCycle()
    {
        return $this->numeroDebCycle;
    }

    /**
     * Set nomProcessus
     *
     * @param string $nomProcessus
     * @return Processus
     */
    public function setNomProcessus($nomProcessus)
    {
        $this->nomProcessus = $nomProcessus;

        return $this;
    }

    /**
     * Get nomProcessus
     *
     * @return string
     */
    public function getNomProcessus()
    {
        return $this->nomProcessus;
    }

    /**
     * Set abrevProcessus
     *
     * @param string $abrevProcessus
     * @return Processus
     */
    public function setAbrevProcessus($abrevProcessus)
    {
        $this->abrevProcessus = $abrevProcessus;

        return $this;
    }

    /**
     * Get abrevProcessus
     *
     * @return string
     */
    public function getAbrevProcessus()
    {
        return $this->abrevProcessus;
    }

    /**
     * Set duree
     *
     * @param array $duree
     * @return Processus
     */
    public function setDuree($duree)
    {
        $this->duree = $duree;

        return $this;
    }

    /**
     * Get duree
     *
     * @return array
     */
    public function getDuree()
    {
        return $this->duree;
    }

    /**
     * Set alerteRouge
     *
     * @param array $alerteRouge
     * @return Processus
     */
    public function setAlerteRouge($alerteRouge)
    {
        $this->alerteRouge = $alerteRouge;

        return $this;
    }

    /**
     * Get alerteRouge
     *
     * @return array
     */
    public function getAlerteRouge()
    {
        return $this->alerteRouge;
    }

    /**
     * Set alerteJaune
     *
     * @param array $alerteJaune
     * @return Processus
     */
    public function setAlerteJaune($alerteJaune)
    {
        $this->alerteJaune = $alerteJaune;

        return $this;
    }

    /**
     * Get alerteJaune
     *
     * @return array
     */
    public function getAlerteJaune()
    {
        return $this->alerteJaune;
    }

    /**
     * Set couleur
     *
     * @param string $couleur
     * @return Processus
     */
    public function setCouleur($couleur)
    {
        $this->couleur = $couleur;

        return $this;
    }

    /**
     * Get couleur
     *
     * @return string
     */
    public function getCouleur()
    {
        return $this->couleur;
    }

    /**
     * Set articleSortie
     *
     * @param string $articleSortie
     * @return Processus
     */
    public function setArticleSortie($articleSortie)
    {
        $this->articleSortie = $articleSortie;

        return $this;
    }

    /**
     * Get articleSortie
     *
     * @return string
     */
    public function getArticleSortie()
    {
        return $this->articleSortie;
    }

    /**
     * Set articleDebut
     *
     * @param \SS\FMBBundle\Entity\Articles $articleDebut
     * @return Processus
     */
    public function setArticleDebut(\SS\FMBBundle\Entity\Articles $articleDebut = null)
    {
        $this->articleDebut = $articleDebut;

        return $this;
    }

    /**
     * Get articleDebut
     *
     * @return \SS\FMBBundle\Entity\Articles
     */
    public function getArticleDebut()
    {
        return $this->articleDebut;
    }

    /**
     * Set couleurDuFond
     *
     * @param string $couleurDuFond
     * @return Processus
     */
    public function setCouleurDuFond($couleurDuFond)
    {
        $this->couleurDuFond = $couleurDuFond;

        return $this;
    }

    /**
     * Get couleurDuFond
     *
     * @return string
     */
    public function getCouleurDuFond()
    {
        return $this->couleurDuFond;
    }

    /**
     * Set phasesProcessus
     *
     * @param \SS\FMBBundle\Entity\Phases $phasesProcessus
     * @return Processus
     */
    public function setPhasesProcessus(\SS\FMBBundle\Entity\Phases $phasesProcessus = null)
    {
        $this->phasesProcessus = $phasesProcessus;

        return $this;
    }

    /**
     * Get phasesProcessus
     *
     * @return \SS\FMBBundle\Entity\Phases
     */
    public function getPhasesProcessus()
    {
        return $this->phasesProcessus;
    }

    /**
     * Set idProcessusParent
     *
     * @param \SS\FMBBundle\Entity\Processus $idProcessusParent
     * @return Processus
     */
    public function setIdProcessusParent(\SS\FMBBundle\Entity\Processus $idProcessusParent = null)
    {
        $this->idProcessusParent = $idProcessusParent;

        return $this;
    }

    /**
     * Get idProcessusParent
     *
     * @return \SS\FMBBundle\Entity\Processus
     */
    public function getIdProcessusParent()
    {
        return $this->idProcessusParent;
    }

    /**
     * Set idProcessusSuivant
     *
     * @param \SS\FMBBundle\Entity\Processus $idProcessusSuivant
     * @return Processus
     */
    public function setIdProcessusSuivant(\SS\FMBBundle\Entity\Processus $idProcessusSuivant = null)
    {
        $this->idProcessusSuivant = $idProcessusSuivant;

        return $this;
    }

    /**
     * Get idProcessusSuivant
     *
     * @return \SS\FMBBundle\Entity\Processus
     */
    public function getIdProcessusSuivant()
    {
        return $this->idProcessusSuivant;
    }

    /**
     * Set limiteDuCycle
     *
     * @param integer $limiteDuCycle
     * @return Processus
     */
    public function setLimiteDuCycle($limiteDuCycle)
    {
        $this->limiteDuCycle = $limiteDuCycle;

        return $this;
    }

    /**
     * Get limiteDuCycle
     *
     * @return integer
     */
    public function getLimiteDuCycle()
    {
        return $this->limiteDuCycle;
    }
}
