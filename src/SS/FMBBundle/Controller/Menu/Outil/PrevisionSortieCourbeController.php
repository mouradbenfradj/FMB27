<?php

namespace SS\FMBBundle\Controller\Menu\Outil;

use SS\FMBBundle\Implementation\DefaultImpl;
use SS\FMBBundle\Implementation\ProcessusImplementation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PrevisionSortieCourbeController extends Controller
{
    public function previsionSortieCourbeAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $tableauPrevisionSelect = array();
        $tableauPrevision = array();
        $datePrevision = null;
        $choix = 0;
        $parcs = $em->getRepository('SSFMBBundle:Magasins')->findAll();

        if ($request->isMethod('POST')) {
            $implementation = new DefaultImpl($em);
            $datePrevisionVoulut = new \DateTime($request->get('datePrevision'));
            $parcCherche = $request->get('parcCherche');
            $parcCherche = intval($parcCherche);
            $tableauPrevisionSelect = array_merge_recursive(
                $em->getRepository('SSFMBBundle:StocksPochesBS')
                    ->createQueryBuilder('sp')
                    ->join('sp.pochesbs', 'poche')
                    ->where('sp.dateDeMiseAEau IS NOT NULL')
                    ->andWhere('sp.dateDeRetirement IS NULL')
                    ->andWhere('poche.parc = :parc')
                    ->setParameter('parc', $parcCherche)
                    ->leftJoin('sp.article', 'articlesn')
                    ->leftJoin('articlesn.refStockArticle', 'refStockArticle')
                    ->getQuery()
                    ->getResult(),
                $em->getRepository('SSFMBBundle:StocksLanternes')
                    ->createQueryBuilder('sl')
                    ->join('sl.lanterne', 'lanterne')
                    ->where('sl.dateDeMiseAEau IS NOT NULL')
                    ->andWhere('sl.dateDeRetirement IS NULL')
                    ->andWhere('lanterne.parc = :parc')
                    ->setParameter('parc', $parcCherche)
                    ->leftJoin('sl.article', 'articlesn')
                    ->leftJoin('articlesn.refStockArticle', 'refStockArticle')
                    ->getQuery()->getResult(),
                $em->getRepository('SSFMBBundle:StocksCordes')
                    ->createQueryBuilder('sc')
                    ->join('sc.corde', 'corde')
                    ->where('sc.dateDeMiseAEau IS NOT NULL')
                    ->andWhere('sc.dateDeRetirement IS NULL')
                    ->andWhere('corde.parc = :parc')
                    ->setParameter('parc', $parcCherche)
                    ->leftJoin('sc.article', 'articlesn')
                    ->leftJoin('articlesn.refStockArticle', 'refStockArticle')
                    ->getQuery()
                    ->getResult());
            $processusImplementation = new ProcessusImplementation($em);
            $cycleKey = array();
            switch ($choix) {
                case 0 :
                    $datePrevision = new \DateTime();
                    $it = 0;
                    do {

                        foreach ($tableauPrevisionSelect as $objet) {
                            if (($objet->getDateDeMiseAEau()) && ($objet->getDateDeRetirement() == null)) {

                                $classe = $em->getRepository(get_class($objet))->find($objet);
                                if (method_exists($objet, 'getLanterne')) {
                                    $quantiter = $implementation->calculerQuantiterLanterne($classe);
                                    $magasine = $classe->getLanterne()->getParc();
                                    $cycle = $processusImplementation->processusArticle($objet->getProcessus(), $datePrevision, $objet->getDateDeMiseAEau())->getAbrevProcessus() . '' . $processusImplementation->cycleArticle($objet->getProcessus(), $datePrevision, $objet->getDateDeMiseAEau());
                                } else if (method_exists($objet, 'getCorde')) {
                                    $quantiter = $classe->getQuantiter();
                                    $magasine = $classe->getCorde()->getParc();
                                    $cycle = $processusImplementation->processusArticle($objet->getProcessus(), $datePrevision, $objet->getDateDeMiseAEau())->getAbrevProcessus() . '' . $processusImplementation->cycleArticle($objet->getProcessus(), $datePrevision, $objet->getDateDeMiseAEau());
                                } else {
                                    $quantiter = $classe->getQuantiter();
                                    $magasine = $classe->getPochesbs()->getParc();
                                    $cycle = $processusImplementation->processusArticle($objet->getProcessus(), $datePrevision, $objet->getDateDeMiseAEau())->getAbrevProcessus() . '' . $processusImplementation->cycleArticle($objet->getProcessus(), $datePrevision, $objet->getDateDeMiseAEau());
                                }
                                if ($request->get('mesure') == 'piece') {
                                    if ($request->get('rendu') == '53') {
                                        $quantiter = $quantiter * 0.533;
                                    }
                                } else if ($request->get('mesure') == 'duozaine') {
                                    if ($request->get('rendu') == '100') {
                                        $quantiter = $quantiter / 12;
                                    } elseif ($request->get('rendu') == '53') {
                                        $quantiter = ($quantiter / 12) * 0.533;
                                    }
                                }
                                if (!isset($tableauPrevision[$magasine->getIdMagasin()][$it])) {
                                    $tableauPrevision[$magasine->getIdMagasin()][$it] = array('nomParc' => $magasine->getAbrevMagasin(), 'cycle' => array());
                                }

                                if (!in_array($cycle, $cycleKey)) {
                                    $cycleKey[] = $cycle;
                                }
                                foreach ($cycleKey as $keycycle) {
                                    if (!isset($tableauPrevision[$magasine->getIdMagasin()][$it]['cycle'][$keycycle])) {
                                        $tableauPrevision[$magasine->getIdMagasin()][$it]['cycle'][$keycycle] = array('article' => array());
                                    }
                                }
                                if (!isset($tableauPrevision[$magasine->getIdMagasin()][$it]['cycle'][$cycle])) {
                                    $tableauPrevision[$magasine->getIdMagasin()][$it]['cycle'][$cycle] = array('article' => array());
                                }
                                if (is_null($objet->getArticle()->getRefStockArticle())) {
                                } else {
                                    if (!isset($tableauPrevision[$magasine->getIdMagasin()][$it]['cycle'][$cycle]['article'][$objet->getArticle()->getRefStockArticle()->getRefArticle()->getRefArticle()])) {
                                        $tableauPrevision[$magasine->getIdMagasin()][$it]['cycle'][$cycle]['article'][$objet->getArticle()->getRefStockArticle()->getRefArticle()->getRefArticle()] = array('nomArticle' => $objet->getArticle()->getRefStockArticle()->getRefArticle()->getLibArticle(), 'qteEau' => $quantiter, 'qteStock' => $objet->getArticle()->getSnQte());
                                    } else {
                                        $tableauPrevision[$magasine->getIdMagasin()][$it]['cycle'][$cycle]['article'][$objet->getArticle()->getRefStockArticle()->getRefArticle()->getRefArticle()]['qteEau'] = $tableauPrevision[$magasine->getIdMagasin()][$it]['cycle'][$cycle]['article'][$objet->getArticle()->getRefStockArticle()->getRefArticle()->getRefArticle()]['qteEau'] + $quantiter;
                                        $tableauPrevision[$magasine->getIdMagasin()][$it]['cycle'][$cycle]['article'][$objet->getArticle()->getRefStockArticle()->getRefArticle()->getRefArticle()]['qteStock'] = $tableauPrevision[$magasine->getIdMagasin()][$it]['cycle'][$cycle]['article'][$objet->getArticle()->getRefStockArticle()->getRefArticle()->getRefArticle()]['qteStock'] + $objet->getArticle()->getSnQte();
                                    }
                                }
                            }
                        }

                        $datePrevision->modify('+1 month');
                        $it++;

                    } while ($datePrevision <= $datePrevisionVoulut);
                    $ittest = 0;
                    for ($ittest; $ittest < $it; $ittest++) {
                        // foreach ($tableauPrevision[intval($parcCherche)][$ittest]['cycle'] as $key => $value) {
                        //var_dump($tableauPrevision[intval($parcCherche)][$ittest]['cycle']);
                        // var_dump($key);
                        foreach ($cycleKey as $keycycle) {
                            if (!isset($tableauPrevision[$magasine->getIdMagasin()][$ittest]['cycle'][$keycycle])) {
                                $tableauPrevision[$magasine->getIdMagasin()][$ittest]['cycle'][$keycycle] = array('article' => array());
                            }
                        }
                        //     }
                    }
                    $ittest = 0;
                    for ($ittest; $ittest < $it; $ittest++) {
                        foreach ($tableauPrevision[intval($parcCherche)][$ittest]['cycle'] as $key => $value) {
                            //var_dump($tableauPrevision[intval($parcCherche)][$ittest]['cycle']);

                        }
                    }
                    break;
                case 1 :
                    foreach ($tableauPrevisionSelect as $objet) {
                        if (($objet->getDateDeMiseAEau()) && ($objet->getDateDeRetirement() == null)) {
                            $datePrevision = new \DateTime();
                            $it = 0;
                            $ancycle = '';
                            do {
                                $classe = $em->getRepository(get_class($objet))->find($objet);
                                if (method_exists($objet, 'getLanterne')) {
                                    $quantiter = $implementation->calculerQuantiterLanterne($classe);
                                    $magasine = $classe->getLanterne()->getParc();
                                    $cycle = $processusImplementation->processusArticle($objet->getProcessus(), $datePrevision, $objet->getDateDeMiseAEau())->getAbrevProcessus() . '' . $processusImplementation->cycleArticle($objet->getProcessus(), $datePrevision, $objet->getDateDeMiseAEau());
                                } else if (method_exists($objet, 'getCorde')) {
                                    $quantiter = $classe->getQuantiter();
                                    $magasine = $classe->getCorde()->getParc();
                                    $cycle = $processusImplementation->processusArticle($objet->getProcessus(), $datePrevision, $objet->getDateDeMiseAEau())->getAbrevProcessus() . '' . $processusImplementation->cycleArticle($objet->getProcessus(), $datePrevision, $objet->getDateDeMiseAEau());
                                } else {
                                    $quantiter = $classe->getQuantiter();
                                    $magasine = $classe->getPochesbs()->getParc();
                                    $cycle = $processusImplementation->processusArticle($objet->getProcessus(), $datePrevision, $objet->getDateDeMiseAEau())->getAbrevProcessus() . '' . $processusImplementation->cycleArticle($objet->getProcessus(), $datePrevision, $objet->getDateDeMiseAEau());
                                }
                                if (!isset($tableauPrevision[$magasine->getIdMagasin()])) {
                                    $tableauPrevision[$magasine->getIdMagasin()] = array('nomParc' => $magasine->getAbrevMagasin(), 'cycle' => array());
                                }

                                if (!isset($tableauPrevision[$magasine->getIdMagasin()]['cycle'][$cycle])) {
                                    $tableauPrevision[$magasine->getIdMagasin()]['cycle'][$cycle] = array('article' => array());
                                }
                                if (!isset($tableauPrevision[$magasine->getIdMagasin()]['cycle'][$cycle]['article'][$objet->getArticle()->getRefStockArticle()->getRefArticle()->getRefArticle()])) {
                                    $tableauPrevision[$magasine->getIdMagasin()]['cycle'][$cycle]['article'][$objet->getArticle()->getRefStockArticle()->getRefArticle()->getRefArticle()] = array('nomArticle' => $objet->getArticle()->getRefStockArticle()->getRefArticle()->getLibArticle(), 'qteEau' => $quantiter, 'qteStock' => $objet->getArticle()->getSnQte());
                                } else {
                                    $tableauPrevision[$magasine->getIdMagasin()]['cycle'][$cycle]['article'][$objet->getArticle()->getRefStockArticle()->getRefArticle()->getRefArticle()]['qteEau'] = $tableauPrevision[$magasine->getIdMagasin()]['cycle'][$cycle]['article'][$objet->getArticle()->getRefStockArticle()->getRefArticle()->getRefArticle()]['qteEau'] + $quantiter;
                                    $tableauPrevision[$magasine->getIdMagasin()]['cycle'][$cycle]['article'][$objet->getArticle()->getRefStockArticle()->getRefArticle()->getRefArticle()]['qteStock'] = $tableauPrevision[$magasine->getIdMagasin()]['cycle'][$cycle]['article'][$objet->getArticle()->getRefStockArticle()->getRefArticle()->getRefArticle()]['qteStock'] + $objet->getArticle()->getSnQte();
                                }
                                $datePrevision->modify('+1 day');
                                $it++;
                            } while ($datePrevision <= $datePrevisionVoulut);

                        }
                    }
                    break;
            }

        }

        krsort($tableauPrevision);
        return $this->render('@SSFMB/Outil/previsionFutureCourbe.html.twig', array('parcs' => $parcs, 'choix' => $choix, 'datePrevision' => $datePrevision, 'historiquePrevision' => $tableauPrevision));
    }

}