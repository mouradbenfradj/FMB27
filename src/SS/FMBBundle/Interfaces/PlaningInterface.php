<?php
/**
 * Created by PhpStorm.
 * User: Sniper
 * Date: 08/08/2016
 * Time: 12:11
 */

namespace SS\FMBBundle\Interfaces;


use SS\FMBBundle\Entity\Processus;

interface PlaningInterface
{
    public function getDateRedWarning($processusStock, $nowDate, $dateMAE, $processusBase);

    public function getDateYellowWarning($processusStock, $nowDate, $dateMAE, $processusBase);
}