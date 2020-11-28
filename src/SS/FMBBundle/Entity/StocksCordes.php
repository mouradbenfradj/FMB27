<?php

namespace SS\FMBBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Corde
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="SS\FMBBundle\Repository\StocksCordesRepository")
 */
class StocksCordes
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
     * @ORM\ManyToOne(targetEntity="SS\FMBBundle\Entity\Corde", inversedBy="stockscordes",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false,  referencedColumnName="id")
     */
    private $corde;
    /**
     * @ORM\ManyToOne(targetEntity="SS\FMBBundle\Entity\Processus")
     * @ORM\JoinColumn(nullable=true)
     */
    private $processus;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantiter", type="integer")
     */
    private $quantiter;
    /**
     * @ORM\OneToOne(targetEntity="SS\FMBBundle\Entity\Emplacement", mappedBy="stockscorde")
     * @ORM\JoinColumn(nullable=true)
     */
    private $emplacement;
    /**
     * @var boolean
     *
     * @ORM\Column(name="pret", type="boolean")
     */
    private $pret;

    /**
     * @var boolean
     *
     * @ORM\Column(name="chaussement", type="boolean")
     */
    private $chaussement = false;
    /**
     * @ORM\ManyToOne(targetEntity="SS\FMBBundle\Entity\StocksArticlesSn")
     * @Orm\JoinColumns({  @ORM\JoinColumn(name="ref_stock_article", referencedColumnName="ref_stock_article"),@Orm\JoinColumn(name="numero_serie", referencedColumnName="numero_serie")} )
     */
    private $article;
    /**
     * @var string
     *
     * @ORM\Column(name="numero_serie", type="string", length=32)
     */
    private $numeroSerie;

    /**
     *
     * @ORM\Column(name="dateDeCreation", type="date")
     */
    private $dateDeCreation;
    /**
     *
     * @ORM\Column(name="date_de_mise_a_eau", type="date",nullable=true)
     */
    private $dateDeMiseAEau;
    /**
     *
     * @ORM\Column(name="dateDeRetraitTransfert", type="date", nullable=true)
     */
    private $dateDeRetraitTransfert;
    /**
     *
     * @ORM\Column(name="dateDeMAETransfert", type="date", nullable=true)
     */
    private $dateDeMAETransfert;
    /**
     *
     * @ORM\Column(name="dateAssemblage", type="date", nullable=true)
     */
    private $dateAssemblage;

    /**
     * @ORM\OneToMany(targetEntity="SS\FMBBundle\Entity\StocksPochesBS", mappedBy="cordeAssemblage" ,cascade={"persist","merge","remove"})
     */
    private $pocheAssemblage;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateChaussement", type="date",nullable=true)
     */
    private $dateChaussement;

    /**
     *
     * @ORM\Column(name="dateDeRetirement", type="date", nullable=true)
     */
    private $dateDeRetirement;
    /**
     * @ORM\ManyToOne(targetEntity="SS\FMBBundle\Entity\DocsLines")
     * @ORM\JoinColumn(name="doc_line", referencedColumnName="ref_doc_line")
     */
    private $docLine;

    public function __toString()
    {
        return "" . $this->id;
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
     * Get quantiter
     *
     * @return integer
     */
    public function getQuantiter()
    {
        return $this->quantiter;
    }

    /**
     * Set quantiter
     *
     * @param integer $quantiter
     * @return Corde
     */
    public function setQuantiter($quantiter)
    {
        $this->quantiter = $quantiter;

        return $this;
    }

    /**
     * Get emplacement
     *
     * @return \SS\FMBBundle\Entity\Emplacement
     */
    public function getEmplacement()
    {
        return $this->emplacement;
    }

    /**
     * Set emplacement
     *
     * @param \SS\FMBBundle\Entity\Emplacement $emplacement
     * @return Corde
     */
    public function setEmplacement(\SS\FMBBundle\Entity\Emplacement $emplacement = null)
    {
        $this->emplacement = $emplacement;

        return $this;
    }

    /**
     * Get pret
     *
     * @return boolean
     */
    public function getPret()
    {
        return $this->pret;
    }

    /**
     * Set pret
     *
     * @param boolean $pret
     * @return Corde
     */
    public function setPret($pret)
    {
        $this->pret = $pret;

        return $this;
    }

    /**
     * Get dateDeCreation
     *
     * @return \DateTime
     */
    public function getDateDeCreation()
    {
        return $this->dateDeCreation;
    }

    /**
     * Set dateDeCreation
     *
     * @param \DateTime $dateDeCreation
     * @return Corde
     */
    public function setDateDeCreation($dateDeCreation)
    {
        $this->dateDeCreation = $dateDeCreation;

        return $this;
    }

    /**
     * Get corde
     *
     * @return \SS\FMBBundle\Entity\Corde
     */
    public function getCorde()
    {
        return $this->corde;
    }

    /**
     * Set corde
     *
     * @param \SS\FMBBundle\Entity\Corde $corde
     * @return StocksCordes
     */
    public function setCorde(\SS\FMBBundle\Entity\Corde $corde)
    {
        $this->corde = $corde;

        return $this;
    }

    /**
     * Get article
     *
     * @return \SS\FMBBundle\Entity\StocksArticlesSn
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * Set article
     *
     * @param \SS\FMBBundle\Entity\StocksArticlesSn $article
     * @return StocksCordes
     */
    public function setArticle(\SS\FMBBundle\Entity\StocksArticlesSn $article = null)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get numeroSerie
     *
     * @return string
     */
    public function getNumeroSerie()
    {
        return $this->numeroSerie;
    }

    /**
     * Set numeroSerie
     *
     * @param string $numeroSerie
     * @return StocksCordes
     */
    public function setNumeroSerie($numeroSerie)
    {
        $this->numeroSerie = $numeroSerie;

        return $this;
    }

    /**
     * Get docLine
     *
     * @return \SS\FMBBundle\Entity\DocsLines
     */
    public function getDocLine()
    {
        return $this->docLine;
    }

    /**
     * Set docLine
     *
     * @param \SS\FMBBundle\Entity\DocsLines $docLine
     * @return StocksCordes
     */
    public function setDocLine(\SS\FMBBundle\Entity\DocsLines $docLine = null)
    {
        $this->docLine = $docLine;

        return $this;
    }

    /**
     * Get dateDeRetirement
     *
     * @return \DateTime
     */
    public function getDateDeRetirement()
    {
        return $this->dateDeRetirement;
    }

    /**
     * Set dateDeRetirement
     *
     * @param \DateTime $dateDeRetirement
     * @return StocksCordes
     */
    public function setDateDeRetirement($dateDeRetirement)
    {
        $this->dateDeRetirement = $dateDeRetirement;

        return $this;
    }

    /**
     * Get dateDeRetraitTransfert
     *
     * @return \DateTime
     */
    public function getDateDeRetraitTransfert()
    {
        return $this->dateDeRetraitTransfert;
    }

    /**
     * Set dateDeRetraitTransfert
     *
     * @param \DateTime $dateDeRetraitTransfert
     * @return StocksCordes
     */
    public function setDateDeRetraitTransfert($dateDeRetraitTransfert)
    {
        $this->dateDeRetraitTransfert = $dateDeRetraitTransfert;

        return $this;
    }

    /**
     * Get dateDeMAETransfert
     *
     * @return \DateTime
     */
    public function getDateDeMAETransfert()
    {
        return $this->dateDeMAETransfert;
    }

    /**
     * Set dateDeMAETransfert
     *
     * @param \DateTime $dateDeMAETransfert
     * @return StocksCordes
     */
    public function setDateDeMAETransfert($dateDeMAETransfert)
    {
        $this->dateDeMAETransfert = $dateDeMAETransfert;

        return $this;
    }

    /**
     * Set dateDeMiseAEau
     *
     * @param \DateTime $dateDeMiseAEau
     * @return StocksCordes
     */
    public function setDateDeMiseAEau($dateDeMiseAEau)
    {
        $this->dateDeMiseAEau = $dateDeMiseAEau;

        return $this;
    }

    /**
     * Get dateDeMiseAEau
     *
     * @return \DateTime
     */
    public function getDateDeMiseAEau()
    {
        return $this->dateDeMiseAEau;
    }

    /**
     * Set chaussement
     *
     * @param boolean $chaussement
     * @return StocksCordes
     */
    public function setChaussement($chaussement)
    {
        $this->chaussement = $chaussement;

        return $this;
    }

    /**
     * Get chaussement
     *
     * @return boolean
     */
    public function getChaussement()
    {
        return $this->chaussement;
    }

    /**
     * Set processus
     *
     * @param \SS\FMBBundle\Entity\Processus $processus
     * @return StocksCordes
     */
    public function setProcessus(\SS\FMBBundle\Entity\Processus $processus = null)
    {
        $this->processus = $processus;

        return $this;
    }

    /**
     * Get processus
     *
     * @return \SS\FMBBundle\Entity\Processus
     */
    public function getProcessus()
    {
        return $this->processus;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->pocheAssemblage = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set dateAssemblage
     *
     * @param \DateTime $dateAssemblage
     * @return StocksCordes
     */
    public function setDateAssemblage($dateAssemblage)
    {
        $this->dateAssemblage = $dateAssemblage;

        return $this;
    }

    /**
     * Get dateAssemblage
     *
     * @return \DateTime
     */
    public function getDateAssemblage()
    {
        return $this->dateAssemblage;
    }

    /**
     * Add pocheAssemblage
     *
     * @param \SS\FMBBundle\Entity\StocksPochesBS $pocheAssemblage
     * @return StocksCordes
     */
    public function addPocheAssemblage(\SS\FMBBundle\Entity\StocksPochesBS $pocheAssemblage)
    {
        $this->pocheAssemblage[] = $pocheAssemblage;
        return $this;
    }

    /**
     * Remove pocheAssemblage
     *
     * @param \SS\FMBBundle\Entity\StocksPochesBS $pocheAssemblage
     */
    public function removePocheAssemblage(\SS\FMBBundle\Entity\StocksPochesBS $pocheAssemblage)
    {
        $this->pocheAssemblage->removeElement($pocheAssemblage);
    }

    /**
     * Get pocheAssemblage
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPocheAssemblage()
    {
        return $this->pocheAssemblage;
    }

    /**
     * Set dateChaussement
     *
     * @param \DateTime $dateChaussement
     * @return StocksCordes
     */
    public function setDateChaussement($dateChaussement)
    {
        $this->dateChaussement = $dateChaussement;

        return $this;
    }

    /**
     * Get dateChaussement
     *
     * @return \DateTime
     */
    public function getDateChaussement()
    {
        return $this->dateChaussement;
    }
}
