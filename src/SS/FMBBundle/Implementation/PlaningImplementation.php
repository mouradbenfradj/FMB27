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
use SS\FMBBundle\Interfaces\PlaningInterface;

class PlaningImplementation implements PlaningInterface
{
    private $em;
    private $processusImplementation;

    public function __construct()
    {
        $ctp = func_num_args();
        $args = func_get_args();
        switch ($ctp) {
            case 0:
                $this->em = null;
                $this->processusImplementation = new ProcessusImplementation();
                break;
            case 1:
                $this->em = $args[0];
                break;
            default:
                break;
        }
    }

    public function getDateRedWarning($processusStock, $nowDate, $dateMAE, $processusBase)
    {
        $processusActuel = $this->processusImplementation->processusArticle($processusStock, $nowDate, $dateMAE);
        $datefinProcessus = $this->processusImplementation->dateProchainProcessus($processusActuel, $dateMAE);
        if ($processusActuel == $processusStock) {
            $redWarning = new DateTime($datefinProcessus->format("Y-m-d"));
            $redWarning->modify($processusStock->getAlerteRouge()['jours'] . ' day');
            $redWarning->modify($processusStock->getAlerteRouge()['mois'] . ' month');
            $redWarning->modify($processusStock->getAlerteRouge()['annee'] . ' year');
        } else {
            do {
                $processusStock = $processusStock->getIdProcessusSuivant();
                $datefinProcessus = $this->processusImplementation->dateProchainProcessus($processusActuel, $datefinProcessus);

                $redWarning = new DateTime($datefinProcessus->format("Y-m-d"));
                $redWarning->modify($processusStock->getAlerteRouge()['jours'] . ' day');
                $redWarning->modify($processusStock->getAlerteRouge()['mois'] . ' month');
                $redWarning->modify($processusStock->getAlerteRouge()['annee'] . ' year');
            } while ($processusStock != $processusActuel);
        }
        return $redWarning;
    }

    public function getDateYellowWarning($processusStock, $nowDate, $dateMAE, $processusBase)
    {
        $processusActuel = $this->processusImplementation->processusArticle($processusStock, $nowDate, $dateMAE);
        $datefinProcessus = $this->processusImplementation->dateProchainProcessus($processusActuel, $dateMAE);
        if ($processusActuel == $processusStock) {
            $yellowWarning = new DateTime($datefinProcessus->format("Y-m-d"));
            $yellowWarning->modify($processusStock->getAlerteJaune()['jours'] . ' day');
            $yellowWarning->modify($processusStock->getAlerteJaune()['mois'] . ' month');
            $yellowWarning->modify($processusStock->getAlerteJaune()['annee'] . ' year');
        } else {
            do {
                $processusStock = $processusStock->getIdProcessusSuivant();
                $datefinProcessus = $this->processusImplementation->dateProchainProcessus($processusActuel, $datefinProcessus);
                $yellowWarning = new DateTime($datefinProcessus->format("Y-m-d"));
                $yellowWarning->modify($processusStock->getAlerteJaune()['jours'] . ' day');
                $yellowWarning->modify($processusStock->getAlerteJaune()['mois'] . ' month');
                $yellowWarning->modify($processusStock->getAlerteJaune()['annee'] . ' year');
            } while ($processusStock != $processusActuel);
        }
        return $yellowWarning;
    }
}