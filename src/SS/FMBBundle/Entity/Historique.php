<?php

namespace SS\FMBBundle\Entity;

use DateTime;
use DateTimeZone;
use Doctrine\ORM\Mapping as ORM;

/**
 * Historique
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="SS\FMBBundle\Repository\HistoriqueRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Historique
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
     * @var DateTime
     *
     * @ORM\Column(name="dateOp", type="datetime")
     */
    private $dateOp;
    /**
     * @var string
     *
     * @ORM\Column(name="operation", type="string")
     */
    private $operation;
    /**
     * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User")
     */
    private $utilisateur;
    /**
     * @var array
     *
     * @ORM\Column(name="tache_effectuer", type="array",nullable=true)
     */
    private $tacheEffectuer = array();


    /**
     * @ORM\PrePersist
     */
    public function generateDate()
    {
        $date = new DateTime(date("Y-m-d  H:i:s"), new DateTimeZone("Europe/Madrid"));
        $date =  date_modify($date, "+1 hour");
        $this->setDateOp($date);
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
     * Set dateOp
     *
     * @param DateTime $dateOp
     * @return Historique
     */
    public function setDateOp($dateOp)
    {
        $this->dateOp = $dateOp;

        return $this;
    }

    /**
     * Get dateOp
     *
     * @return DateTime
     */
    public function getDateOp()
    {
        return $this->dateOp;
    }

    /**
     * Set utilisateur
     *
     * @param \Application\Sonata\UserBundle\Entity\User $utilisateur
     * @return Historique
     */
    public function setUtilisateur(\Application\Sonata\UserBundle\Entity\User $utilisateur = null)
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * Get utilisateur
     *
     * @return \Application\Sonata\UserBundle\Entity\User
     */
    public function getUtilisateur()
    {
        return $this->utilisateur;
    }

    /**
     * Set operation
     *
     * @param string $operation
     * @return Historique
     */
    public function setOperation($operation)
    {
        $this->operation = $operation;

        return $this;
    }

    /**
     * Get operation
     *
     * @return string 
     */
    public function getOperation()
    {
        return $this->operation;
    }

    /**
     * Set tacheEffectuer
     *
     * @param array $tacheEffectuer
     * @return Historique
     */
    public function setTacheEffectuer($tacheEffectuer)
    {
        $this->tacheEffectuer = $tacheEffectuer;

        return $this;
    }

    /**
     * Get tacheEffectuer
     *
     * @return array 
     */
    public function getTacheEffectuer()
    {
        return $this->tacheEffectuer;
    }
}
