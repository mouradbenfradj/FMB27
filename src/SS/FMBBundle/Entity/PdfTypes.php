<?php

namespace SS\FMBBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PdfTypes
 *
 * @ORM\Table(name="pdf_types")
 * @ORM\Entity
 */
class PdfTypes
{
    /**
     * @var string
     *
     * @ORM\Column(name="lib_pdf_type", type="string", length=64, nullable=false)
     */
    private $libPdfType;

    /**
     * @var boolean
     *
     * @ORM\Column(name="id_pdf_type", type="boolean")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPdfType;



    /**
     * Set libPdfType
     *
     * @param string $libPdfType
     * @return PdfTypes
     */
    public function setLibPdfType($libPdfType)
    {
        $this->libPdfType = $libPdfType;

        return $this;
    }

    /**
     * Get libPdfType
     *
     * @return string 
     */
    public function getLibPdfType()
    {
        return $this->libPdfType;
    }

    /**
     * Get idPdfType
     *
     * @return boolean 
     */
    public function getIdPdfType()
    {
        return $this->idPdfType;
    }
}
