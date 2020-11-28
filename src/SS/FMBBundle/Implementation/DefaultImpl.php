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
use SS\FMBBundle\Interfaces\DefaultInterface;

class DefaultImpl implements DefaultInterface
{
    protected $em;

    public function __construct($entitymanager)
    {
        $this->em = $entitymanager;
    }

    public function calculerQuantiterLanterne($tableauPoches)
    {
        $somme = 0;
        foreach ($tableauPoches->getPoches() as $poches) {
            $somme = $somme + $poches->getQuantite();
        }

        if ($somme != 0) {
            return $somme;
        }
    }

    public function viderPoche($poche, $qte)
    {
        // TODO: Implement viderPoche() method.
    }

    public function modifierQtePoche($poche, $qte)
    {
        // TODO: Implement modifierQtePoche() method.
    }

    public function remplirPoche($i, $qte, $nbrPocheLanterne)
    {
        $poche = new Poche();
        $poche->setEmplacement($i);
        if ($i == 1) {
            $poche->setQuantite(((int)($qte / $nbrPocheLanterne)) + ((int)($qte % $nbrPocheLanterne)));
        } else {
            $poche->setQuantite((int)($qte / $nbrPocheLanterne));
        }
        return $poche;
    }

    public function ordonnanceurTableau($filieres)
    {
        //11978
        $tableau = $this->distainctTable($filieres, 'fiId');
        die();
        var_dump($filieres);


        return $tableau;
    }

    public function distainctTable($tableau, $colonne)
    {  //11798
        foreach ($tableau as $key => $value) {
            $tab[$value[$colonne]] = $value;
        }
        foreach ($tab as $key => $value) {
            var_dump($key);
        }
        die();
        var_dump($tableau);

        die();
        return $tableau;
    }

    public function DefinirNiveauAlerte($emplacement, $dateActuel, $cycle)
    {
        $dc = new DateTime($emplacement['dateDeRemplissage']->format("Y-m-d"));
        $idCycleArticle = 0;

        if ($emplacement['stockscorde']) {
            $idCycleArticle = $emplacement['processusc'];
        }
        foreach ($cycle as $item) {
            if ($item->getId() == $idCycleArticle) {
                $cycleArticle = $item;
            }
            if ($item->getIdProcessusParent()) {
                if ($item->getIdProcessusParent()->getId() == $idCycleArticle) {
                    $cycleSuivant = $item;
                }
            }
        }
        $dc->modify($cycleArticle->getDuree()['jours'] . ' day');
        $dc->modify($cycleArticle->getDuree()['mois'] . ' month');
        $dc->modify($cycleArticle->getDuree()['annee'] . ' year');
        $aj = new DateTime($dc->format("Y-m-d"));
        $aj->modify($cycleArticle->getAlerteJaune()['jours'] . '  day');
        $aj->modify($cycleArticle->getAlerteJaune()['mois'] . ' month');
        $aj->modify($cycleArticle->getAlerteJaune()['annee'] . '  year');
        $ar = new DateTime($dc->format("Y-m-d"));
        $ar->modify($cycleArticle->getAlerteRouge()['jours'] . '  day');
        $ar->modify($cycleArticle->getAlerteRouge()['mois'] . ' month');
        $ar->modify($cycleArticle->getAlerteRouge()['annee'] . '  year');

        var_dump($emplacement);
        var_dump($emplacement['dateDeRemplissage']->format("Y-m-d"));
        var_dump($dc);
        var_dump($aj);
        var_dump($ar);
        if ($ar < $dateActuel) {
            return 3;
        } elseif ($aj > $dateActuel) {
            return 1;
        } else {
            return 2;
        }
        die();

        die();


        return 0;
    }
}