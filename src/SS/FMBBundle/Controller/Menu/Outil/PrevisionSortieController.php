<?php

namespace SS\FMBBundle\Controller\Menu\Outil;

use SS\FMBBundle\Implementation\DefaultImpl;
use SS\FMBBundle\Implementation\ProcessusImplementation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PrevisionSortieController extends Controller
{
    public function previsionSortieAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $tableauPrevisionSelect = array();
        $tableauPrevision = array();
        $datePrevision = null;
        $choix = 0;
        if ($request->isMethod('POST')) {
            $implementation = new DefaultImpl($em);
            $datePrevision = new \DateTime($request->get('datePrevision'));
            $tableauPrevisionSelect = array_merge_recursive($em->getRepository('SSFMBBundle:StocksPochesBS')->createQueryBuilder('sp')->where('sp.dateDeMiseAEau IS NOT NULL')->andWhere('sp.dateDeRetirement IS NULL')->getQuery()->getResult(), $em->getRepository('SSFMBBundle:StocksLanternes')->createQueryBuilder('sl')->where('sl.dateDeMiseAEau IS NOT NULL')->andWhere('sl.dateDeRetirement IS NULL')->getQuery()->getResult(), $em->getRepository('SSFMBBundle:StocksCordes')->createQueryBuilder('sc')->where('sc.dateDeMiseAEau IS NOT NULL')->andWhere('sc.dateDeRetirement IS NULL')->getQuery()->getResult());
            $choix = $request->get('operationCherche');
            $processusImplementation = new ProcessusImplementation($em);

            switch ($choix) {
                case 0 :
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
                            if (!isset($tableauPrevision[$magasine->getIdMagasin()])) {
                                $tableauPrevision[$magasine->getIdMagasin()] = array('nomParc' => $magasine->getAbrevMagasin(), 'cycle' => array());
                            }
                            if (!isset($tableauPrevision[$magasine->getIdMagasin()]['cycle'][$cycle])) {
                                $tableauPrevision[$magasine->getIdMagasin()]['cycle'][$cycle] = array('article' => array());
                            }
                            if (is_null($objet->getArticle()->getRefStockArticle())) {
                            } else {
                                if (!isset($tableauPrevision[$magasine->getIdMagasin()]['cycle'][$cycle]['article'][$objet->getArticle()->getRefStockArticle()->getRefArticle()->getRefArticle()])) {
                                    $tableauPrevision[$magasine->getIdMagasin()]['cycle'][$cycle]['article'][$objet->getArticle()->getRefStockArticle()->getRefArticle()->getRefArticle()] = array('nomArticle' => $objet->getArticle()->getRefStockArticle()->getRefArticle()->getLibArticle(), 'lot' => array());
                                }
                                if (!isset($tableauPrevision[$magasine->getIdMagasin()]['cycle'][$cycle]['article'][$objet->getArticle()->getRefStockArticle()->getRefArticle()->getRefArticle()]['lot'][$objet->getArticle()->getNumeroSerie()])) {
                                    $tableauPrevision[$magasine->getIdMagasin()]['cycle'][$cycle]['article'][$objet->getArticle()->getRefStockArticle()->getRefArticle()->getRefArticle()]['lot'][$objet->getArticle()->getNumeroSerie()] = array('qteEau' => $quantiter, 'qteStock' => $objet->getArticle()->getSnQte());
                                } else {
                                    $tableauPrevision[$magasine->getIdMagasin()]['cycle'][$cycle]['article'][$objet->getArticle()->getRefStockArticle()->getRefArticle()->getRefArticle()]['lot'][$objet->getArticle()->getNumeroSerie()]['qteEau'] = $tableauPrevision[$magasine->getIdMagasin()]['cycle'][$cycle]['article'][$objet->getArticle()->getRefStockArticle()->getRefArticle()->getRefArticle()]['lot'][$objet->getArticle()->getNumeroSerie()]['qteEau'] + $quantiter;
                                }
                            }
                        }
                    }
                    break;
                case 1 :
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
                            if (!isset($tableauPrevision[$magasine->getIdMagasin()])) {
                                $tableauPrevision[$magasine->getIdMagasin()] = array('nomParc' => $magasine->getAbrevMagasin(), 'cycle' => array());
                            }
                            if (!isset($tableauPrevision[$magasine->getIdMagasin()]['cycle'][$cycle])) {
                                $tableauPrevision[$magasine->getIdMagasin()]['cycle'][$cycle] = array('article' => array());
                            }
                            if (is_null($objet->getArticle()->getRefStockArticle())) {
                            } else {
                                if (!isset($tableauPrevision[$magasine->getIdMagasin()]['cycle'][$cycle]['article'][$objet->getArticle()->getRefStockArticle()->getRefArticle()->getRefArticle()])) {
                                    $tableauPrevision[$magasine->getIdMagasin()]['cycle'][$cycle]['article'][$objet->getArticle()->getRefStockArticle()->getRefArticle()->getRefArticle()] = array('nomArticle' => $objet->getArticle()->getRefStockArticle()->getRefArticle()->getLibArticle(), 'qteEau' => $quantiter, 'qteStock' => $objet->getArticle()->getSnQte());
                                } else {
                                    $tableauPrevision[$magasine->getIdMagasin()]['cycle'][$cycle]['article'][$objet->getArticle()->getRefStockArticle()->getRefArticle()->getRefArticle()]['qteEau'] = $tableauPrevision[$magasine->getIdMagasin()]['cycle'][$cycle]['article'][$objet->getArticle()->getRefStockArticle()->getRefArticle()->getRefArticle()]['qteEau'] + $quantiter;
                                    $tableauPrevision[$magasine->getIdMagasin()]['cycle'][$cycle]['article'][$objet->getArticle()->getRefStockArticle()->getRefArticle()->getRefArticle()]['qteStock'] = $tableauPrevision[$magasine->getIdMagasin()]['cycle'][$cycle]['article'][$objet->getArticle()->getRefStockArticle()->getRefArticle()->getRefArticle()]['qteStock'] + $objet->getArticle()->getSnQte();
                                }
                            }
                        }
                    }
                    break;
            }
        }
        krsort($tableauPrevision);
        return $this->render('@SSFMB/Outil/previsionFuture.html.twig', array('choix' => $choix, 'datePrevision' => $datePrevision, 'historiquePrevision' => $tableauPrevision));
    }

}