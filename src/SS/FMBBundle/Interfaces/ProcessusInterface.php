<?php
/**
 * Created by PhpStorm.
 * User: Sniper
 * Date: 08/08/2016
 * Time: 12:11
 */

namespace SS\FMBBundle\Interfaces;


use SS\FMBBundle\Entity\Processus;

interface ProcessusInterface
{
    public function definirNiveauAlerte($emplacement, $dateActuel, $cycle);

    public function cycleArticle(Processus $processusActuel, \DateTime $dateDeRecherche, \DateTime $dateDeMAE);

    public function dateProchainProcessus($processusActuel, $dateMAE);

    public function dateFinProcessus($processusDebut, $processusActuel, $dateMAE, $processusTable);

    public function processusArticle($processusActuel, $dateDeRecherche, $dateDeMAE);


}