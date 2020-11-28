<?php
/**
 * Created by PhpStorm.
 * User: Sniper
 * Date: 08/08/2016
 * Time: 12:09
 */

namespace SS\FMBBundle\Implementation;


use DateTime;
use SS\FMBBundle\Entity\Lot;
use SS\FMBBundle\Entity\Poche;
use SS\FMBBundle\Entity\Processus;
use SS\FMBBundle\Interfaces\DefaultInterface;
use SS\FMBBundle\Interfaces\ProcessusInterface;

class ProcessusImplementation implements ProcessusInterface
{
    protected $em;

    public function __construct()
    {
        $ctp = func_num_args();
        $args = func_get_args();
        switch ($ctp) {
            case 0:
                $this->em = null;
                break;
            case 1:
                $this->em = $args[0];
                break;
            default:
                break;
        }
    }

    public function definirNiveauAlerte($emplacement, $dateActuel, $cycle)
    {
        // TODO: Implement DefinirNiveauAlerte() method.
    }


    public function cycleArticle(Processus $processusActuel, \DateTime $dateDeRecherche, \DateTime $dateDeMAE)
    {
        $processus = $processusActuel;
        $dateRecherche = $dateDeRecherche;
        $dateDebut = $dateDeMAE;
        $dateProchainProcessus = $this->dateProchainProcessus($processus, $dateDebut);
        if ($processus->getIdProcessusSuivant()) {
            $suivant = true;
            while (!(($dateDebut <= $dateRecherche) && ($dateRecherche < $dateProchainProcessus)) && $suivant) {
                $dateDebut = $dateProchainProcessus;
                $dateProchainProcessus = $this->dateProchainProcessus($processus->getIdProcessusSuivant(), $dateDebut);
                $processus = $processus->getIdProcessusSuivant();
                if (!$processus->getIdProcessusSuivant()) {
                    $suivant = false;
                }
            }
        }
        $differance = $dateRecherche->diff($dateDebut);
        $nbday = $differance->d;
        $nbmonth = $differance->m;
        $nbmonth = $nbmonth + $processus->getNumeroDebCycle();
        $nbyear = $differance->y;
        if ($nbyear > 0)
            $nbmonth = $nbmonth + ($nbyear * 12);
        if ($nbmonth > ($processus->getLimiteDuCycle())) {
            $nbmonth = $processus->getLimiteDuCycle();
        }

        ///////
        return $nbmonth;
    }

    public function processusArticle($processusActuel, $dateDeRecherche, $dateDeMAE)
    {
        $processus = $processusActuel;
        $dateRecherche = $dateDeRecherche;
        $dateDebut = $dateDeMAE;
        $dateProchainProcessus = $this->dateProchainProcessus($processus, $dateDebut);
        if ($processus->getIdProcessusSuivant()) {
            $suivant = true;
            while (!(($dateDebut <= $dateRecherche) && ($dateRecherche < $dateProchainProcessus)) && $suivant) {
                $dateDebut = $dateProchainProcessus;
                $dateProchainProcessus = $this->dateProchainProcessus($processus->getIdProcessusSuivant(), $dateDebut);
                $processus = $processus->getIdProcessusSuivant();
                if (!$processus->getIdProcessusSuivant()) {
                    $suivant = false;
                }
            }
        }

        return $processus;
    }

    public function dateProchainProcessus($processusActuel, $dateMAE)
    {
        $processus = $processusActuel;
        $date = new DateTime($dateMAE->format("Y-m-d"));
        $date->modify($processus->getDuree()['jours'] . ' day');
        $date->modify($processus->getDuree()['mois'] . ' month');
        $date->modify($processus->getDuree()['annee'] . ' year');
        return $date;
    }


    public function dateFinProcessus($processusDebut, $processusActuel, $dateMAE, $processusTable)
    {
        $date = new DateTime($dateMAE->format("Y-m-d"));
        do {
            $processus = $processusDebut;
            $date->modify($processus->getDuree()['jours'] . ' day');
            $date->modify($processus->getDuree()['mois'] . ' month');
            $date->modify($processus->getDuree()['annee'] . ' year');
            $processusDebut = $processus->getIdProcessusSuivant();
        } while ($processus != $processusActuel);
        return $date;
    }
}