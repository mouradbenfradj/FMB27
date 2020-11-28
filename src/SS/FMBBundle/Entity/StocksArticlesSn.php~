<?php

namespace SS\FMBBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StocksArticlesSn
 *
 * @ORM\Table(name="stocks_articles_sn", indexes={@ORM\Index(name="numero_serie", columns={"numero_serie"}), @ORM\Index(name="ref_stock_article", columns={"ref_stock_article"})})
 * @ORM\Entity(repositoryClass="SS\FMBBundle\Repository\StocksArticlesSnRepository")
 */
class StocksArticlesSn
{
    /**
     * @var float
     *
     * @ORM\Column(name="sn_qte", type="float", precision=10, scale=0, nullable=false)
     */
    private $snQte;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_serie", type="string", length=32)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $numeroSerie;

    /**
     * @var \SS\FMBBundle\Entity\StocksArticles
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="SS\FMBBundle\Entity\StocksArticles")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ref_stock_article", referencedColumnName="ref_stock_article")
     * })
     */
    private $refStockArticle;


    public function __toString()
    {
        return $this->numeroSerie;
    }


    /**
     * Set snQte
     *
     * @param float $snQte
     * @return StocksArticlesSn
     */
    public function setSnQte($snQte)
    {
        $this->snQte = $snQte;

        return $this;
    }

    /**
     * Get snQte
     *
     * @return float
     */
    public function getSnQte()
    {
        return $this->snQte;
    }

    /**
     * Set numeroSerie
     *
     * @param string $numeroSerie
     * @return StocksArticlesSn
     */
    public function setNumeroSerie($numeroSerie)
    {
        $this->numeroSerie = $numeroSerie;

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
     * Set refStockArticle
     *
     * @param \SS\FMBBundle\Entity\StocksArticles $refStockArticle
     * @return StocksArticlesSn
     */
    public function setRefStockArticle(\SS\FMBBundle\Entity\StocksArticles $refStockArticle)
    {
        $this->refStockArticle = $refStockArticle;
        return $this;
    }

    /**
     * Get refStockArticle
     *
     * @return \SS\FMBBundle\Entity\StocksArticles
     */
    public function getRefStockArticle()
    {
        return $this->refStockArticle;
    }
}
