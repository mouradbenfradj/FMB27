<?php

namespace SS\FMBBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ArtCategsSpecificites
 *
 * @ORM\Table(name="art_categs_specificites")
 * @ORM\Entity
 */
class ArtCategsSpecificites
{
    /**
     * @var string
     *
     * @ORM\Column(name="lib_modele_spe", type="string", length=255, nullable=false)
     */
    private $libModeleSpe;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_modele_spe", type="smallint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idModeleSpe;



    /**
     * Set libModeleSpe
     *
     * @param string $libModeleSpe
     * @return ArtCategsSpecificites
     */
    public function setLibModeleSpe($libModeleSpe)
    {
        $this->libModeleSpe = $libModeleSpe;

        return $this;
    }

    /**
     * Get libModeleSpe
     *
     * @return string 
     */
    public function getLibModeleSpe()
    {
        return $this->libModeleSpe;
    }

    /**
     * Get idModeleSpe
     *
     * @return integer 
     */
    public function getIdModeleSpe()
    {
        return $this->idModeleSpe;
    }
}
