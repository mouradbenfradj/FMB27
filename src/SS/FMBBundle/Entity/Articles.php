<?php

namespace SS\FMBBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Articles
 *
 * @ORM\Table(name="articles", uniqueConstraints={@ORM\UniqueConstraint(name="ref_interne", columns={"ref_interne"})}, indexes={@ORM\Index(name="lib_article", columns={"lib_article"}), @ORM\Index(name="ref_art_categ", columns={"ref_art_categ"}), @ORM\Index(name="ref_constructeur", columns={"ref_constructeur"}), @ORM\Index(name="dispo", columns={"dispo"}), @ORM\Index(name="ref_oem", columns={"ref_oem"}), @ORM\Index(name="id_tva", columns={"id_tva"}), @ORM\Index(name="id_valo", columns={"id_valo"}), @ORM\Index(name="id_modele_spe", columns={"id_modele_spe"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class Articles
{
    /**
     * @var string
     *
     * @ORM\Column(name="ref_oem", type="string", length=64, nullable=true)
     */
    private $refOem;

    /**
     * @var string
     *
     * @ORM\Column(name="ref_interne", type="string", length=32, nullable=true)
     */
    private $refInterne;

    /**
     * @var string
     *
     * @ORM\Column(name="lib_article", type="string", length=250, nullable=false)
     */
    private $libArticle;

    /**
     * @var string
     *
     * @ORM\Column(name="lib_ticket", type="string", length=64, nullable=false)
     */
    private $libTicket;

    /**
     * @var string
     *
     * @ORM\Column(name="desc_courte", type="blob", length=16777215, nullable=false)
     */
    private $descCourte;

    /**
     * @var string
     *
     * @ORM\Column(name="desc_longue", type="blob", length=16777215, nullable=false)
     */
    private $descLongue;

    /**
     * @var string
     *
     * @ORM\Column(name="ref_art_categ", type="string", length=32, nullable=false)
     */
    private $refArtCateg;

    /**
     * @var string
     *
     * @ORM\Column(name="modele", type="string", nullable=false)
     */
    private $modele;

    /**
     * @var string
     *
     * @ORM\Column(name="ref_constructeur", type="string", length=32, nullable=true)
     */
    private $refConstructeur;

    /**
     * @var float
     *
     * @ORM\Column(name="prix_public_ht", type="float", precision=10, scale=0, nullable=true)
     */
    private $prixPublicHt;

    /**
     * @var float
     *
     * @ORM\Column(name="prix_achat_ht", type="float", precision=10, scale=0, nullable=true)
     */
    private $prixAchatHt;

    /**
     * @var float
     *
     * @ORM\Column(name="paa_ht", type="float", precision=10, scale=0, nullable=true)
     */
    private $paaHt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="paa_last_maj", type="datetime", nullable=false)
     */
    private $paaLastMaj;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_tva", type="smallint", nullable=true)
     */
    private $idTva;

    /**
     * @var integer
     *
     * @ORM\Column(name="promo", type="smallint", nullable=false)
     */
    private $promo;

    /**
     * @var float
     *
     * @ORM\Column(name="valo_indice", type="float", precision=10, scale=0, nullable=false)
     */
    private $valoIndice;

    /**
     * @var boolean
     *
     * @ORM\Column(name="lot", type="boolean", nullable=false)
     */
    private $lot;

    /**
     * @var boolean
     *
     * @ORM\Column(name="composant", type="boolean", nullable=false)
     */
    private $composant;

    /**
     * @var boolean
     *
     * @ORM\Column(name="variante", type="boolean", nullable=false)
     */
    private $variante;

    /**
     * @var boolean
     *
     * @ORM\Column(name="gestion_sn", type="boolean", nullable=false)
     */
    private $gestionSn;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_debut_dispo", type="datetime", nullable=false)
     */
    private $dateDebutDispo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_fin_dispo", type="datetime", nullable=false)
     */
    private $dateFinDispo;

    /**
     * @var boolean
     *
     * @ORM\Column(name="dispo", type="boolean", nullable=false)
     */
    private $dispo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_creation", type="datetime", nullable=false)
     */
    private $dateCreation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_modification", type="datetime", nullable=false)
     */
    private $dateModification;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_compte_achat", type="string", length=10, nullable=true)
     */
    private $numeroCompteAchat;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_compte_vente", type="string", length=10, nullable=true)
     */
    private $numeroCompteVente;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_achetable", type="boolean", nullable=false)
     */
    private $isAchetable;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_vendable", type="boolean", nullable=false)
     */
    private $isVendable;

    /**
     * @var string
     *
     * @ORM\Column(name="ref_article", type="string", length=32)
     * @ORM\Id
     */
    private $refArticle;

    /**
     * @var \SS\FMBBundle\Entity\ArtCategsSpecificites
     *
     * @ORM\ManyToOne(targetEntity="SS\FMBBundle\Entity\ArtCategsSpecificites")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_modele_spe", referencedColumnName="id_modele_spe")
     * })
     */
    private $idModeleSpe;

    /**
     * @var \SS\FMBBundle\Entity\ArticlesValorisations
     *
     * @ORM\ManyToOne(targetEntity="SS\FMBBundle\Entity\ArticlesValorisations")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_valo", referencedColumnName="id_valo")
     * })
     */
    private $idValo;

    public function __toString()
    {
        return $this->libArticle;
    }

    /**
     * @ORM\PrePersist
     */
    public function setRefArticle()
    {
        $this->refArticle = uniqid();
    }

    /**
     * Set refOem
     *
     * @param string $refOem
     * @return Articles
     */
    public function setRefOem($refOem)
    {
        $this->refOem = $refOem;

        return $this;
    }

    /**
     * Get refOem
     *
     * @return string
     */
    public function getRefOem()
    {
        return $this->refOem;
    }

    /**
     * Set refInterne
     *
     * @param string $refInterne
     * @return Articles
     */
    public function setRefInterne($refInterne)
    {
        $this->refInterne = $refInterne;

        return $this;
    }

    /**
     * Get refInterne
     *
     * @return string
     */
    public function getRefInterne()
    {
        return $this->refInterne;
    }

    /**
     * Set libArticle
     *
     * @param string $libArticle
     * @return Articles
     */
    public function setLibArticle($libArticle)
    {
        $this->libArticle = $libArticle;

        return $this;
    }

    /**
     * Get libArticle
     *
     * @return string
     */
    public function getLibArticle()
    {
        return $this->libArticle;
    }

    /**
     * Set libTicket
     *
     * @param string $libTicket
     * @return Articles
     */
    public function setLibTicket($libTicket)
    {
        $this->libTicket = $libTicket;

        return $this;
    }

    /**
     * Get libTicket
     *
     * @return string
     */
    public function getLibTicket()
    {
        return $this->libTicket;
    }

    /**
     * Set descCourte
     *
     * @param string $descCourte
     * @return Articles
     */
    public function setDescCourte($descCourte)
    {
        $this->descCourte = $descCourte;

        return $this;
    }

    /**
     * Get descCourte
     *
     * @return string
     */
    public function getDescCourte()
    {
        return $this->descCourte;
    }

    /**
     * Set descLongue
     *
     * @param string $descLongue
     * @return Articles
     */
    public function setDescLongue($descLongue)
    {
        $this->descLongue = $descLongue;

        return $this;
    }

    /**
     * Get descLongue
     *
     * @return string
     */
    public function getDescLongue()
    {
        return $this->descLongue;
    }

    /**
     * Set refArtCateg
     *
     * @param string $refArtCateg
     * @return Articles
     */
    public function setRefArtCateg($refArtCateg)
    {
        $this->refArtCateg = $refArtCateg;

        return $this;
    }

    /**
     * Get refArtCateg
     *
     * @return string
     */
    public function getRefArtCateg()
    {
        return $this->refArtCateg;
    }

    /**
     * Set modele
     *
     * @param string $modele
     * @return Articles
     */
    public function setModele($modele)
    {
        $this->modele = $modele;

        return $this;
    }

    /**
     * Get modele
     *
     * @return string
     */
    public function getModele()
    {
        return $this->modele;
    }

    /**
     * Set refConstructeur
     *
     * @param string $refConstructeur
     * @return Articles
     */
    public function setRefConstructeur($refConstructeur)
    {
        $this->refConstructeur = $refConstructeur;

        return $this;
    }

    /**
     * Get refConstructeur
     *
     * @return string
     */
    public function getRefConstructeur()
    {
        return $this->refConstructeur;
    }

    /**
     * Set prixPublicHt
     *
     * @param float $prixPublicHt
     * @return Articles
     */
    public function setPrixPublicHt($prixPublicHt)
    {
        $this->prixPublicHt = $prixPublicHt;

        return $this;
    }

    /**
     * Get prixPublicHt
     *
     * @return float
     */
    public function getPrixPublicHt()
    {
        return $this->prixPublicHt;
    }

    /**
     * Set prixAchatHt
     *
     * @param float $prixAchatHt
     * @return Articles
     */
    public function setPrixAchatHt($prixAchatHt)
    {
        $this->prixAchatHt = $prixAchatHt;

        return $this;
    }

    /**
     * Get prixAchatHt
     *
     * @return float
     */
    public function getPrixAchatHt()
    {
        return $this->prixAchatHt;
    }

    /**
     * Set paaHt
     *
     * @param float $paaHt
     * @return Articles
     */
    public function setPaaHt($paaHt)
    {
        $this->paaHt = $paaHt;

        return $this;
    }

    /**
     * Get paaHt
     *
     * @return float
     */
    public function getPaaHt()
    {
        return $this->paaHt;
    }

    /**
     * Set paaLastMaj
     *
     * @param \DateTime $paaLastMaj
     * @return Articles
     */
    public function setPaaLastMaj($paaLastMaj)
    {
        $this->paaLastMaj = $paaLastMaj;

        return $this;
    }

    /**
     * Get paaLastMaj
     *
     * @return \DateTime
     */
    public function getPaaLastMaj()
    {
        return $this->paaLastMaj;
    }

    /**
     * Set idTva
     *
     * @param integer $idTva
     * @return Articles
     */
    public function setIdTva($idTva)
    {
        $this->idTva = $idTva;

        return $this;
    }

    /**
     * Get idTva
     *
     * @return integer
     */
    public function getIdTva()
    {
        return $this->idTva;
    }

    /**
     * Set promo
     *
     * @param integer $promo
     * @return Articles
     */
    public function setPromo($promo)
    {
        $this->promo = $promo;

        return $this;
    }

    /**
     * Get promo
     *
     * @return integer
     */
    public function getPromo()
    {
        return $this->promo;
    }

    /**
     * Set valoIndice
     *
     * @param float $valoIndice
     * @return Articles
     */
    public function setValoIndice($valoIndice)
    {
        $this->valoIndice = $valoIndice;

        return $this;
    }

    /**
     * Get valoIndice
     *
     * @return float
     */
    public function getValoIndice()
    {
        return $this->valoIndice;
    }

    /**
     * Set lot
     *
     * @param boolean $lot
     * @return Articles
     */
    public function setLot($lot)
    {
        $this->lot = $lot;

        return $this;
    }

    /**
     * Get lot
     *
     * @return boolean
     */
    public function getLot()
    {
        return $this->lot;
    }

    /**
     * Set composant
     *
     * @param boolean $composant
     * @return Articles
     */
    public function setComposant($composant)
    {
        $this->composant = $composant;

        return $this;
    }

    /**
     * Get composant
     *
     * @return boolean
     */
    public function getComposant()
    {
        return $this->composant;
    }

    /**
     * Set variante
     *
     * @param boolean $variante
     * @return Articles
     */
    public function setVariante($variante)
    {
        $this->variante = $variante;

        return $this;
    }

    /**
     * Get variante
     *
     * @return boolean
     */
    public function getVariante()
    {
        return $this->variante;
    }

    /**
     * Set gestionSn
     *
     * @param boolean $gestionSn
     * @return Articles
     */
    public function setGestionSn($gestionSn)
    {
        $this->gestionSn = $gestionSn;

        return $this;
    }

    /**
     * Get gestionSn
     *
     * @return boolean
     */
    public function getGestionSn()
    {
        return $this->gestionSn;
    }

    /**
     * Set dateDebutDispo
     *
     * @param \DateTime $dateDebutDispo
     * @return Articles
     */
    public function setDateDebutDispo($dateDebutDispo)
    {
        $this->dateDebutDispo = $dateDebutDispo;

        return $this;
    }

    /**
     * Get dateDebutDispo
     *
     * @return \DateTime
     */
    public function getDateDebutDispo()
    {
        return $this->dateDebutDispo;
    }

    /**
     * Set dateFinDispo
     *
     * @param \DateTime $dateFinDispo
     * @return Articles
     */
    public function setDateFinDispo($dateFinDispo)
    {
        $this->dateFinDispo = $dateFinDispo;

        return $this;
    }

    /**
     * Get dateFinDispo
     *
     * @return \DateTime
     */
    public function getDateFinDispo()
    {
        return $this->dateFinDispo;
    }

    /**
     * Set dispo
     *
     * @param boolean $dispo
     * @return Articles
     */
    public function setDispo($dispo)
    {
        $this->dispo = $dispo;

        return $this;
    }

    /**
     * Get dispo
     *
     * @return boolean
     */
    public function getDispo()
    {
        return $this->dispo;
    }

    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     * @return Articles
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set dateModification
     *
     * @param \DateTime $dateModification
     * @return Articles
     */
    public function setDateModification($dateModification)
    {
        $this->dateModification = $dateModification;

        return $this;
    }

    /**
     * Get dateModification
     *
     * @return \DateTime
     */
    public function getDateModification()
    {
        return $this->dateModification;
    }

    /**
     * Set numeroCompteAchat
     *
     * @param string $numeroCompteAchat
     * @return Articles
     */
    public function setNumeroCompteAchat($numeroCompteAchat)
    {
        $this->numeroCompteAchat = $numeroCompteAchat;

        return $this;
    }

    /**
     * Get numeroCompteAchat
     *
     * @return string
     */
    public function getNumeroCompteAchat()
    {
        return $this->numeroCompteAchat;
    }

    /**
     * Set numeroCompteVente
     *
     * @param string $numeroCompteVente
     * @return Articles
     */
    public function setNumeroCompteVente($numeroCompteVente)
    {
        $this->numeroCompteVente = $numeroCompteVente;

        return $this;
    }

    /**
     * Get numeroCompteVente
     *
     * @return string
     */
    public function getNumeroCompteVente()
    {
        return $this->numeroCompteVente;
    }

    /**
     * Set isAchetable
     *
     * @param boolean $isAchetable
     * @return Articles
     */
    public function setIsAchetable($isAchetable)
    {
        $this->isAchetable = $isAchetable;

        return $this;
    }

    /**
     * Get isAchetable
     *
     * @return boolean
     */
    public function getIsAchetable()
    {
        return $this->isAchetable;
    }

    /**
     * Set isVendable
     *
     * @param boolean $isVendable
     * @return Articles
     */
    public function setIsVendable($isVendable)
    {
        $this->isVendable = $isVendable;

        return $this;
    }

    /**
     * Get isVendable
     *
     * @return boolean
     */
    public function getIsVendable()
    {
        return $this->isVendable;
    }

    /**
     * Get refArticle
     *
     * @return string
     */
    public function getRefArticle()
    {
        return $this->refArticle;
    }

    /**
     * Set idModeleSpe
     *
     * @param \SS\FMBBundle\Entity\ArtCategsSpecificites $idModeleSpe
     * @return Articles
     */
    public function setIdModeleSpe(\SS\FMBBundle\Entity\ArtCategsSpecificites $idModeleSpe = null)
    {
        $this->idModeleSpe = $idModeleSpe;

        return $this;
    }

    /**
     * Get idModeleSpe
     *
     * @return \SS\FMBBundle\Entity\ArtCategsSpecificites
     */
    public function getIdModeleSpe()
    {
        return $this->idModeleSpe;
    }

    /**
     * Set idValo
     *
     * @param \SS\FMBBundle\Entity\ArticlesValorisations $idValo
     * @return Articles
     */
    public function setIdValo(\SS\FMBBundle\Entity\ArticlesValorisations $idValo = null)
    {
        $this->idValo = $idValo;

        return $this;
    }

    /**
     * Get idValo
     *
     * @return \SS\FMBBundle\Entity\ArticlesValorisations
     */
    public function getIdValo()
    {
        return $this->idValo;
    }
}
