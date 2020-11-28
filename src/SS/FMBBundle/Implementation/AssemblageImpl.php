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
use SS\FMBBundle\Interfaces\AssemblageInterface;
use SS\FMBBundle\Interfaces\DefaultInterface;

class AssemblageImpl implements AssemblageInterface
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

    public function compareCordePocheAssemble($obj1, $obj2)
    {
        $test = false;
        if (count($obj1->getPocheAssemblage()) == count($obj2->getPocheAssemblage())) {
            foreach ($obj1->getPocheAssemblage() as $poche1) {
                $test = false;
                foreach ($obj2->getPocheAssemblage() as $poche2) {
                    if (($poche1->getPochesbs() === $poche2->getPochesbs())
                        && ($poche1->getQuantiter() === $poche2->getQuantiter())
                        && ($poche1->getArticle() === $poche2->getArticle())
                        && ($poche1->getDateAssemblage() == $poche2->getDateAssemblage())
                    ) {
                        $test = true;
                    }
                }
            }
        }
        return $test;
    }

    public function comparePochePocheAssemble($obj1, $obj2)
    {
        $test = false;
        foreach ($obj1->getPocheAssemblage() as $poche1) {
            foreach ($obj2->getPocheAssemblage() as $poche2) {
                if (($poche1->getPochesbs() === $poche2->getPochesbs())
                    && ($poche1->getQuantiter() === $poche2->getQuantiter())
                    && ($poche1->getArticle() === $poche2->getArticle())
                    && ($poche1->getDateAssemblage() == $poche2->getDateAssemblage())
                ) {
                    $test = true;
                }
            }

        }
        return $test;
    }

    public function tableauPoche($listePoche, $listPoche)
    {
        $tabPoche = array();
        $key = 0;
        foreach ($listPoche as $pocheCorde1) {
            foreach ($listPoche as $pocheCorde2) {
                if ($pocheCorde1->compareAPoche($pocheCorde2)) {
                    if (!isset($tabPoche[$key]['listPoche'])) {
                        $tabPoche[$key]['listPoche'] = array();
                        $tabPoche[$key]['nbrPoche'] = 0;
                    }
                    $trv = false;
                    for ($verif = $key; $verif >= 0; $verif--) {
                        if (in_array($pocheCorde2, $tabPoche[$verif]['listPoche'])) {
                            $trv = true;
                        }
                    }
                    if (!$trv) {
                        $tabPoche[$key]['nbrPoche'] = $tabPoche[$key]['nbrPoche'] + 1;
                        array_push($tabPoche[$key]['listPoche'], $pocheCorde2);
                    }
                    if (!in_array($pocheCorde2, $tabPoche[$key]['listPoche'])) {

                    }
                }
            }

            $key++;
        }
        for ($i = 0; $i <= max(array_keys($tabPoche)); $i++) {
            if ($tabPoche[$i]['nbrPoche'] == 0) {
                unset($tabPoche[$i]);
            }
        }
        return $tabPoche;

    }
}