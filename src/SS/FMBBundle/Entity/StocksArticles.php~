<?php

namespace SS\FMBBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StocksArticles
 *
 * @ORM\Table(name="stocks_articles", indexes={@ORM\Index(name="id_stock", columns={"id_stock"}), @ORM\Index(name="ref_article", columns={"ref_article"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class StocksArticles
{
    /**
     * @var float
     *
     * @ORM\Column(name="qte", type="float", precision=10, scale=0, nullable=false)
     */
    private $qte;

    /**
     * @var string
     *
     * @ORM\Column(name="ref_stock_article", type="string", length=32)
     * @ORM\Id
     */
    private $refStockArticle;

    /**
     * @var \SS\FMBBundle\Entity\Articles
     *
     * @ORM\ManyToOne(targetEntity="SS\FMBBundle\Entity\Articles")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ref_article", referencedColumnName="ref_article")
     * })
     */
    private $refArticle;

    /**
     * @var \SS\FMBBundle\Entity\Stocks
     *
     * @ORM\ManyToOne(targetEntity="SS\FMBBundle\Entity\Stocks")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_stock", referencedColumnName="id_stock")
     * })
     */
    private $idStock;

    /**
     * @ORM\OneToMany(targetEntity="SS\FMBBundle\Entity\StocksArticlesSn", mappedBy="refStockArticle" ,cascade={"persist","remove"})
     */
    private $stocksArticlesSn;

public function __toString()
{
 return $this->refStockArticle;
}

    /**
     * Set qte
     *
     * @param float $qte
     * @return StocksArticles
     */
    public function setQte($qte)
    {
        $this->qte = $qte;

        return $this;
    }

    /**
     * Get qte
     *
     * @return float 
     */
    public function getQte()
    {
        return $this->qte;
    }

    /**
     * Get refStockArticle
     *
     * @return string 
     */
    public function getRefStockArticle()
    {
        return $this->refStockArticle;
    }
    /**
     * @ORM\PrePersist
     */
    public function geerateRefStockArticle()
    {
        $this->refStockArticle = uniqid();
    }
    /**
     * Set refArticle
     *
     * @param \SS\FMBBundle\Entity\Articles $refArticle
     * @return StocksArticles
     */
    public function setRefArticle(\SS\FMBBundle\Entity\Articles $refArticle = null)
    {
        $this->refArticle = $refArticle;

        return $this;
    }

    /**
     * Get refArticle
     *
     * @return \SS\FMBBundle\Entity\Articles
     */
    public function getRefArticle()
    {
        return $this->refArticle;
    }

    /**
     * Set idStock
     *
     * @param \SS\FMBBundle\Entity\Stocks $idStock
     * @return StocksArticles
     */
    public function setIdStock(\SS\FMBBundle\Entity\Stocks $idStock = null)
    {
        $this->idStock = $idStock;

        return $this;
    }

    /**
     * Get idStock
     *
     * @return \SS\FMBBundle\Entity\Stocks
     */
    public function getIdStock()
    {
        return $this->idStock;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->stocksArticlesSn = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add stocksArticlesSn
     *
     * @param \SS\FMBBundle\Entity\StocksArticlesSn $stocksArticlesSn
     * @return StocksArticles
     */
    public function addStocksArticlesSn(\SS\FMBBundle\Entity\StocksArticlesSn $stocksArticlesSn)
    {
        $this->stocksArticlesSn[] = $stocksArticlesSn;
        $stocksArticlesSn->setRefStockArticle($this);
        return $this;
    }

    /**
     * Remove stocksArticlesSn
     *
     * @param \SS\FMBBundle\Entity\StocksArticlesSn $stocksArticlesSn
     */
    public function removeStocksArticlesSn(\SS\FMBBundle\Entity\StocksArticlesSn $stocksArticlesSn)
    {
        $this->stocksArticlesSn->removeElement($stocksArticlesSn);
    }

    /**
     * Get stocksArticlesSn
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getStocksArticlesSn()
    {
        return $this->stocksArticlesSn;
    }

    /**
     * Set refStockArticle
     *
     * @param string $refStockArticle
     * @return StocksArticles
     */
    public function setRefStockArticle($refStockArticle)
    {
        $this->refStockArticle = $refStockArticle;

        return $this;
    }
}
