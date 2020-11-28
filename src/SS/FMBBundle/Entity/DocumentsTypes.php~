<?php

namespace SS\FMBBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DocumentsTypes
 *
 * @ORM\Table(name="documents_types", indexes={@ORM\Index(name="actif", columns={"actif"}), @ORM\Index(name="id_pdf_modele", columns={"id_pdf_modele"}), @ORM\Index(name="id_type_groupe", columns={"id_type_groupe"})})
 * @ORM\Entity
 */
class DocumentsTypes
{
    /**
     * @var string
     *
     * @ORM\Column(name="lib_type_doc", type="string", length=64, nullable=false)
     */
    private $libTypeDoc;

    /**
     * @var string
     *
     * @ORM\Column(name="lib_type_printed", type="string", length=64, nullable=false)
     */
    private $libTypePrinted;

    /**
     * @var string
     *
     * @ORM\Column(name="code_doc", type="string", length=32, nullable=false)
     */
    private $codeDoc ='';

    /**
     * @var boolean
     *
     * @ORM\Column(name="id_type_groupe", type="boolean", nullable=false)
     */
    private $idTypeGroupe=' ';

    /**
     * @var boolean
     *
     * @ORM\Column(name="actif", type="boolean", nullable=false)
     */
    private $actif = false;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_type_doc", type="smallint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idTypeDoc;

    /**
     * @var \SS\FMBBundle\Entity\PdfModeles
     *
     * @ORM\ManyToOne(targetEntity="SS\FMBBundle\Entity\PdfModeles")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_pdf_modele", referencedColumnName="id_pdf_modele")
     * })
     */
    private $idPdfModele;

    public function __toString()
    {
        return $this->getLibTypeDoc();
    }

    /**
     * Set libTypeDoc
     *
     * @param string $libTypeDoc
     * @return DocumentsTypes
     */
    public function setLibTypeDoc($libTypeDoc)
    {
        $this->libTypeDoc = $libTypeDoc;

        return $this;
    }

    /**
     * Get libTypeDoc
     *
     * @return string
     */
    public function getLibTypeDoc()
    {
        return $this->libTypeDoc;
    }

    /**
     * Set libTypePrinted
     *
     * @param string $libTypePrinted
     * @return DocumentsTypes
     */
    public function setLibTypePrinted($libTypePrinted)
    {
        $this->libTypePrinted = $libTypePrinted;

        return $this;
    }

    /**
     * Get libTypePrinted
     *
     * @return string
     */
    public function getLibTypePrinted()
    {
        return $this->libTypePrinted;
    }

    /**
     * Set codeDoc
     *
     * @param string $codeDoc
     * @return DocumentsTypes
     */
    public function setCodeDoc($codeDoc)
    {
        $this->codeDoc = $codeDoc;

        return $this;
    }

    /**
     * Get codeDoc
     *
     * @return string
     */
    public function getCodeDoc()
    {
        return $this->codeDoc;
    }

    /**
     * Set idTypeGroupe
     *
     * @param boolean $idTypeGroupe
     * @return DocumentsTypes
     */
    public function setIdTypeGroupe($idTypeGroupe)
    {
        $this->idTypeGroupe = $idTypeGroupe;

        return $this;
    }

    /**
     * Get idTypeGroupe
     *
     * @return boolean
     */
    public function getIdTypeGroupe()
    {
        return $this->idTypeGroupe;
    }

    /**
     * Set actif
     *
     * @param boolean $actif
     * @return DocumentsTypes
     */
    public function setActif($actif)
    {
        $this->actif = $actif;

        return $this;
    }

    /**
     * Get actif
     *
     * @return boolean
     */
    public function getActif()
    {
        return $this->actif;
    }

    /**
     * Get idTypeDoc
     *
     * @return integer
     */
    public function getIdTypeDoc()
    {
        return $this->idTypeDoc;
    }

    /**
     * Set idPdfModele
     *
     * @param \SS\FMBBundle\Entity\PdfModeles $idPdfModele
     * @return DocumentsTypes
     */
    public function setIdPdfModele(\SS\FMBBundle\Entity\PdfModeles $idPdfModele = null)
    {
        $this->idPdfModele = $idPdfModele;

        return $this;
    }


    /**
     * Get idPdfModele
     *
     * @return \SS\FMBBundle\Entity\PdfModeles
     */
    public function getIdPdfModele()
    {
        return $this->idPdfModele;
    }
}
