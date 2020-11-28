<?php

namespace SS\FMBBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StocksLanternes
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="SS\FMBBundle\Repository\StocksLanternesRepository")
 */
class StocksLanternes
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
     * @ORM\ManyToOne(targetEntity="SS\FMBBundle\Entity\Lanterne", inversedBy="stockslanternes",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false,  referencedColumnName="nomLanterne")
     */
    private $lanterne;
    /**
     * @ORM\ManyToOne(targetEntity="SS\FMBBundle\Entity\Processus")
     * @ORM\JoinColumn(nullable=true)
     */
    private $processus;

    /**
     * @ORM\OneToMany(targetEntity="SS\FMBBundle\Entity\Poche", mappedBy="stocklanterne",cascade={"persist","remove"},fetch="LAZY")
     */
    private $poches;

    /**
     * @ORM\OneToOne(targetEntity="SS\FMBBundle\Entity\Emplacement", mappedBy="stockslanterne",fetch="LAZY")
     * @ORM\JoinColumn(nullable=true)
     */
    private $emplacement;

    /**
     * @var boolean
     *
     * @ORM\Column(name="pret", type="boolean")
     */
    private $pret =false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="chaussement", type="boolean")
     */
    private $chaussement =false;

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
     * @ORM\Column(name="dateDeRetirement", type="date", nullable=true)
     */
    private $dateDeRetirement;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateChaussement", type="date",nullable=true)
     */
    private $dateChaussement;
    /**
     * @ORM\ManyToOne(targetEntity="SS\FMBBundle\Entity\DocsLines")
     * @ORM\JoinColumn(name="doc_line", referencedColumnName="ref_doc_line")
     */
    private $docLine;
    /**
     * @var integer
     *
     * @ORM\Column(name="cycle_r", type="integer")
     */
    private $cycleR = 0;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->poches = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * @return StocksLanternes
     */
    public function setPret($pret)
    {
        $this->pret = $pret;

        return $this;
    }


    /**
     * Get lanterne
     *
     * @return \SS\FMBBundle\Entity\Lanterne
     */
    public function getLanterne()
    {
        return $this->lanterne;
    }

    /**
     * Set lanterne
     *
     * @param \SS\FMBBundle\Entity\Lanterne $lanterne
     * @return StocksLanternes
     */
    public function setLanterne(\SS\FMBBundle\Entity\Lanterne $lanterne)
    {
        $this->lanterne = $lanterne;

        return $this;
    }

    /**
     * Add poches
     *
     * @param \SS\FMBBundle\Entity\Poche $poches
     * @return StocksLanternes
     */
    public function addPoch(\SS\FMBBundle\Entity\Poche $poches)
    {
        $this->poches[] = $poches;
        $poches->setStocklanterne($this);
        return $this;
    }

    /**
     * Remove poches
     *
     * @param \SS\FMBBundle\Entity\Poche $poches
     */
    public function removePoch(\SS\FMBBundle\Entity\Poche $poches)
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
     * @return StocksLanternes
     */
    public function setEmplacement(\SS\FMBBundle\Entity\Emplacement $emplacement = null)
    {
        $this->emplacement = $emplacement;
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
     * @return StocksLanternes
     */
    public function setDocLine(\SS\FMBBundle\Entity\DocsLines $docLine = null)
    {
        $this->docLine = $docLine;

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
     * @return StocksLanternes
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
     * @return StocksLanternes
     */
    public function setNumeroSerie($numeroSerie)
    {
        $this->numeroSerie = $numeroSerie;

        return $this;
    }

    /**
     * Set chaussement
     *
     * @param boolean $chaussement
     * @return StocksLanternes
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
     * Set cycleR
     *
     * @param integer $cycleR
     * @return StocksLanternes
     */
    public function setCycleR($cycleR)
    {
        $this->cycleR = $cycleR;

        return $this;
    }

    /**
     * Get cycleR
     *
     * @return integer 
     */
    public function getCycleR()
    {
        return $this->cycleR;
    }

    /**
     * Set processus
     *
     * @param \SS\FMBBundle\Entity\Processus $processus
     * @return StocksLanternes
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
     * Set dateDeCreation
     *
     * @param \DateTime $dateDeCreation
     * @return StocksLanternes
     */
    public function setDateDeCreation($dateDeCreation)
    {
        $this->dateDeCreation = $dateDeCreation;

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
     * Set dateDeMiseAEau
     *
     * @param \DateTime $dateDeMiseAEau
     * @return StocksLanternes
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
     * Set dateDeRetraitTransfert
     *
     * @param \DateTime $dateDeRetraitTransfert
     * @return StocksLanternes
     */
    public function setDateDeRetraitTransfert($dateDeRetraitTransfert)
    {
        $this->dateDeRetraitTransfert = $dateDeRetraitTransfert;

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
     * Set dateDeMAETransfert
     *
     * @param \DateTime $dateDeMAETransfert
     * @return StocksLanternes
     */
    public function setDateDeMAETransfert($dateDeMAETransfert)
    {
        $this->dateDeMAETransfert = $dateDeMAETransfert;

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
     * Set dateDeRetirement
     *
     * @param \DateTime $dateDeRetirement
     * @return StocksLanternes
     */
    public function setDateDeRetirement($dateDeRetirement)
    {
        $this->dateDeRetirement = $dateDeRetirement;

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
     * Set dateChaussement
     *
     * @param \DateTime $dateChaussement
     * @return StocksLanternes
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
