<?php
/**
 * Created by PhpStorm.
 * User: Sniper
 * Date: 08/08/2016
 * Time: 12:11
 */

namespace SS\FMBBundle\Interfaces;


interface DefaultInterface
{
    public function remplirPoche($i, $qte, $nbrPocheLanterne);

    public function viderPoche($poche, $qte);

    public function modifierQtePoche($poche, $qte);

    public function calculerQuantiterLanterne($tableauPoches);

    public function ordonnanceurTableau($filieres);

    public function distainctTable($tableau, $colonne);

    public function DefinirNiveauAlerte($emplacement, $dateActuel, $cycle);
}