<?php

namespace SS\FMBBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DocumentsEtats
 *
 * @ORM\Table(name="documents_etats", indexes={@ORM\Index(name="ordre", columns={"ordre"}), @ORM\Index(name="id_type_doc", columns={"id_type_doc"})})
 * @ORM\Entity
 */
class DocumentsEtats
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_type_doc", type="smallint", nullable=false)
     */
    private $idTypeDoc;

    /**
     * @var string
     *
     * @ORM\Column(name="lib_etat_doc", type="string", length=32, nullable=false)
     */
    private $libEtatDoc;

    /**
     * @var boolean
     *
     * @ORM\Column(name="ordre", type="boolean", nullable=false)
     */
    private $ordre;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_open", type="boolean", nullable=false)
     */
    private $isOpen;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_etat_doc", type="smallint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idEtatDoc;



    /**
     * Set idTypeDoc
     *
     * @param integer $idTypeDoc
     * @return DocumentsEtats
     */
    public function setIdTypeDoc($idTypeDoc)
    {
        $this->idTypeDoc = $idTypeDoc;

        return $this;
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
     * Set libEtatDoc
     *
     * @param string $libEtatDoc
     * @return DocumentsEtats
     */
    public function setLibEtatDoc($libEtatDoc)
    {
        $this->libEtatDoc = $libEtatDoc;

        return $this;
    }

    /**
     * Get libEtatDoc
     *
     * @return string 
     */
    public function getLibEtatDoc()
    {
        return $this->libEtatDoc;
    }

    /**
     * Set ordre
     *
     * @param boolean $ordre
     * @return DocumentsEtats
     */
    public function setOrdre($ordre)
    {
        $this->ordre = $ordre;

        return $this;
    }

    /**
     * Get ordre
     *
     * @return boolean 
     */
    public function getOrdre()
    {
        return $this->ordre;
    }

    /**
     * Set isOpen
     *
     * @param boolean $isOpen
     * @return DocumentsEtats
     */
    public function setIsOpen($isOpen)
    {
        $this->isOpen = $isOpen;

        return $this;
    }

    /**
     * Get isOpen
     *
     * @return boolean 
     */
    public function getIsOpen()
    {
        return $this->isOpen;
    }

    /**
     * Get idEtatDoc
     *
     * @return integer 
     */
    public function getIdEtatDoc()
    {
        return $this->idEtatDoc;
    }
}
