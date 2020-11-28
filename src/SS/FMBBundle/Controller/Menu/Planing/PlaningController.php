<?php

namespace SS\FMBBundle\Controller\Menu\Planing;

use DateTime;
use SS\FMBBundle\Implementation\PlaningImplementation;
use SS\FMBBundle\Implementation\ProcessusImplementation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PlaningController extends Controller
{
    public function planingdetravailleAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $nowDate = new DateTime("now");
        $tableAlertProcessus = array();
        $parc = $em->getRepository('SSFMBBundle:Magasins')->findOneByIdMagasin($request->get('idparc'));
        $processus = $em->getRepository('SSFMBBundle:Processus')->findAll();
        if ($parc) {
            $planingImplementation = new PlaningImplementation();
            $processusImplementation = new ProcessusImplementation();

            $lanternesfabriquer = $em->getRepository('SSFMBBundle:StocksLanternes')->getLanternePreparerYellowWarning($parc);
            $lanternesfabriquerurgent = $em->getRepository('SSFMBBundle:StocksLanternes')->getLanternePreparerRedWarning($parc);
            foreach ($lanternesfabriquer as $lanterne) {
                if (!isset($tableAlertProcessus['processus a éfféctué']['Lanterne Preparé'][$lanterne['nomLanterne']][$lanterne['libArticle']][$lanterne['numeroSerie']][$lanterne['dateDeCreation']->format('Y-m-d')])) {
                    $tableAlertProcessus['processus a éfféctué']['Lanterne Preparé'][$lanterne['nomLanterne']][$lanterne['libArticle']][$lanterne['numeroSerie']][$lanterne['dateDeCreation']->format('Y-m-d')] = array();
                    $tableAlertProcessus['processus a éfféctué']['classColor'] = 'bg-warning';
                }
                array_push($tableAlertProcessus['processus a éfféctué']['Lanterne Preparé'][$lanterne['nomLanterne']][$lanterne['libArticle']][$lanterne['numeroSerie']][$lanterne['dateDeCreation']->format('Y-m-d')], $lanterne['quantiter']);
            }
            foreach ($lanternesfabriquerurgent as $lanterne) {
                if (!isset($tableAlertProcessus['processus urgent']['Lanterne Preparé'][$lanterne['nomLanterne']][$lanterne['libArticle']][$lanterne['numeroSerie']][$lanterne['dateDeCreation']->format('Y-m-d')])) {
                    $tableAlertProcessus['processus urgent']['Lanterne Preparé'][$lanterne['nomLanterne']][$lanterne['libArticle']][$lanterne['numeroSerie']][$lanterne['dateDeCreation']->format('Y-m-d')] = array();
                    $tableAlertProcessus['processus urgent']['classColor'] = 'bg-danger';
                }
                array_push($tableAlertProcessus['processus urgent']['Lanterne Preparé'][$lanterne['nomLanterne']][$lanterne['libArticle']][$lanterne['numeroSerie']][$lanterne['dateDeCreation']->format('Y-m-d')], $lanterne['quantiter']);
            }
            $cordesfabriquer = $em->getRepository('SSFMBBundle:StocksCordes')->getCordePreparerYellowWarning($parc);
            $cordesfabriquerurgent = $em->getRepository('SSFMBBundle:StocksCordes')->getCordePreparerRedWarning($parc);
            foreach ($cordesfabriquer as $corde) {
                if (!isset($tableAlertProcessus['processus a éfféctué']['Corde Preparé'][$corde['nomCorde']][$corde['libArticle']][$corde['numeroSerie']][$corde['dateDeCreation']->format('Y-m-d')])) {
                    $tableAlertProcessus['processus a éfféctué']['Corde Preparé'][$corde['nomCorde']][$corde['libArticle']][$corde['numeroSerie']][$corde['dateDeCreation']->format('Y-m-d')] = array();
                    $tableAlertProcessus['processus a éfféctué']['classColor'] = 'bg-warning';
                }
                array_push($tableAlertProcessus['processus a éfféctué']['Corde Preparé'][$corde['nomCorde']][$corde['libArticle']][$corde['numeroSerie']][$corde['dateDeCreation']->format('Y-m-d')], $corde['quantiter']);

            }

            foreach ($cordesfabriquerurgent as $corde) {
                if (!isset($tableAlertProcessus['processus urgent']['Corde Preparé'][$corde['nomCorde']][$corde['libArticle']][$corde['numeroSerie']][$corde['dateDeCreation']->format('Y-m-d')])) {
                    $tableAlertProcessus['processus urgent']['Corde Preparé'][$corde['nomCorde']][$corde['libArticle']][$corde['numeroSerie']][$corde['dateDeCreation']->format('Y-m-d')] = array();
                    $tableAlertProcessus['processus urgent']['classColor'] = 'bg-danger';
                }
                array_push($tableAlertProcessus['processus urgent']['Corde Preparé'][$corde['nomCorde']][$corde['libArticle']][$corde['numeroSerie']][$corde['dateDeCreation']->format('Y-m-d')], $corde['quantiter']);
            }

            $places = $em->getRepository('SSFMBBundle:Emplacement')->getTotaleEmplacementByParc($parc);
            foreach ($places as $place) {
                if ($place->getStockslanterne()) {
                    $stock = $place->getStockslanterne();
                    $conteneur = $place->getStockslanterne()->getLanterne()->getNomLanterne();
                    $quantiter = 0;
                    foreach ($place->getStockslanterne()->getPoches() as $qte) {
                        $quantiter = $quantiter + $qte->getQuantite();
                    }

                } else if ($place->getStockscorde()) {
                    $stock = $place->getStockscorde();
                    $conteneur = $place->getStockscorde()->getCorde()->getNomCorde();
                    $quantiter = $place->getStockscorde()->getQuantiter();
                } else if ($place->getStockspoches()) {
                    $stock = $place->getStockspoches();
                    $conteneur = $place->getStockspoches()->getPoche()->getNomPoche();
                    $quantiter = $place->getStockspoches()->getQuantiter();
                }
                if ($place->getDateDeRemplissage()) {
                    $processusStock = $stock->getProcessus();
                    if ($processusStock) {
                        $processusActuel = $processusImplementation->processusArticle($processusStock, $nowDate, $place->getDateDeRemplissage());
                        $cycleArticle = $processusImplementation->cycleArticle($processusStock, $nowDate, $place->getDateDeRemplissage());
                        $yellowWarning = $planingImplementation->getDateYellowWarning($processusStock, $nowDate, $place->getDateDeRemplissage(), $processus);
                        $redWarning = $planingImplementation->getDateRedWarning($processusStock, $nowDate, $place->getDateDeRemplissage(), $processus);
                        $dateRetrait = $processusImplementation->dateFinProcessus($processusStock, $processusActuel, $place->getDateDeRemplissage(), $processus);
                        $greenFirst = false;
                        $yellowFirst = false;
                        $redFirst = false;
                        if ((($nowDate < $yellowWarning) && ($yellowWarning < $redWarning)) || (($nowDate < $redWarning) && ($yellowWarning > $redWarning)) || ($yellowWarning == $redWarning)) {
                            $greenFirst = true;
                        } elseif (($nowDate < $yellowWarning) && ($nowDate > $redWarning)) {
                            $redFirst = true;
                        } elseif (($nowDate > $yellowWarning) && ($nowDate < $redWarning)) {
                            $yellowFirst = true;
                        } elseif ((($nowDate > $yellowWarning) && ($nowDate > $redWarning)) && ($yellowWarning > $redWarning)) {
                            $yellowFirst = true;
                        } elseif ((($nowDate > $yellowWarning) && ($nowDate > $redWarning)) && ($yellowWarning < $redWarning)) {
                            $redFirst = true;
                        }
                        if ($place->getFlotteur()->getSegment()->getFiliere()->getAireDeTravaille()) {
                            $phaseProcessusPFiliere = $processusActuel->getPhasesProcessus()->getNomPhase() . " Sur l'air de travaille ";
                        } else {
                            $phaseProcessusPFiliere = $processusActuel->getPhasesProcessus()->getNomPhase();
                        }
                        if ($greenFirst) {
                            if (!isset($tableAlertProcessus['processus en cour'][$phaseProcessusPFiliere][$place->getFlotteur()->getSegment()->getFiliere()->getNomFiliere()][$place->getFlotteur()->getSegment()->getNomSegment()][$place->getFlotteur()->getNomFlotteur()][$place->getplace()][$conteneur][$stock->getArticle()->getRefStockArticle()->getRefArticle()->getLibArticle()][$stock->getArticle()->getNumeroSerie()][$place->getDateDeRemplissage()->format('Y-m-d')][$processusActuel->getAbrevProcessus() . '' . $cycleArticle][$dateRetrait->format('Y-m-d')][$quantiter])) {
                                $tableAlertProcessus['processus en cour'][$phaseProcessusPFiliere][$place->getFlotteur()->getSegment()->getFiliere()->getNomFiliere()][$place->getFlotteur()->getSegment()->getNomSegment()][$place->getFlotteur()->getNomFlotteur()][$place->getplace()][$conteneur][$stock->getArticle()->getRefStockArticle()->getRefArticle()->getLibArticle()][$stock->getArticle()->getNumeroSerie()][$place->getDateDeRemplissage()->format('Y-m-d')][$processusActuel->getAbrevProcessus() . '' . $cycleArticle][$dateRetrait->format('Y-m-d')][$quantiter] = array();
                                $tableAlertProcessus['processus en cour']['classColor'] = 'bg-success';
                            }
                            array_push($tableAlertProcessus['processus en cour'][$phaseProcessusPFiliere][$place->getFlotteur()->getSegment()->getFiliere()->getNomFiliere()][$place->getFlotteur()->getSegment()->getNomSegment()][$place->getFlotteur()->getNomFlotteur()][$place->getplace()][$conteneur][$stock->getArticle()->getRefStockArticle()->getRefArticle()->getLibArticle()][$stock->getArticle()->getNumeroSerie()][$place->getDateDeRemplissage()->format('Y-m-d')][$processusActuel->getAbrevProcessus() . '' . $cycleArticle][$dateRetrait->format('Y-m-d')][$quantiter], $quantiter);
                        }
                        if ($yellowFirst) {
                            if (!isset($tableAlertProcessus['processus a éfféctué'][$phaseProcessusPFiliere][$place->getFlotteur()->getSegment()->getFiliere()->getNomFiliere()][$place->getFlotteur()->getSegment()->getNomSegment()][$place->getFlotteur()->getNomFlotteur()][$place->getplace()][$conteneur][$stock->getArticle()->getRefStockArticle()->getRefArticle()->getLibArticle()][$stock->getArticle()->getNumeroSerie()][$place->getDateDeRemplissage()->format('Y-m-d')][$processusActuel->getAbrevProcessus() . '' . $cycleArticle][$dateRetrait->format('Y-m-d')][$quantiter])) {
                                $tableAlertProcessus['processus a éfféctué'][$phaseProcessusPFiliere][$place->getFlotteur()->getSegment()->getFiliere()->getNomFiliere()][$place->getFlotteur()->getSegment()->getNomSegment()][$place->getFlotteur()->getNomFlotteur()][$place->getplace()][$conteneur][$stock->getArticle()->getRefStockArticle()->getRefArticle()->getLibArticle()][$stock->getArticle()->getNumeroSerie()][$place->getDateDeRemplissage()->format('Y-m-d')][$processusActuel->getAbrevProcessus() . '' . $cycleArticle][$dateRetrait->format('Y-m-d')][$quantiter] = array();
                                $tableAlertProcessus['processus a éfféctué']['classColor'] = 'bg-warning';
                            }
                            array_push($tableAlertProcessus['processus a éfféctué'][$phaseProcessusPFiliere][$place->getFlotteur()->getSegment()->getFiliere()->getNomFiliere()][$place->getFlotteur()->getSegment()->getNomSegment()][$place->getFlotteur()->getNomFlotteur()][$place->getplace()][$conteneur][$stock->getArticle()->getRefStockArticle()->getRefArticle()->getLibArticle()][$stock->getArticle()->getNumeroSerie()][$place->getDateDeRemplissage()->format('Y-m-d')][$processusActuel->getAbrevProcessus() . '' . $cycleArticle][$dateRetrait->format('Y-m-d')][$quantiter], $quantiter);
                        }
                        if ($redFirst) {
                            if (!isset($tableAlertProcessus['processus urgent'][$phaseProcessusPFiliere][$place->getFlotteur()->getSegment()->getFiliere()->getNomFiliere()][$place->getFlotteur()->getSegment()->getNomSegment()][$place->getFlotteur()->getNomFlotteur()][$place->getplace()][$conteneur][$stock->getArticle()->getRefStockArticle()->getRefArticle()->getLibArticle()][$stock->getArticle()->getNumeroSerie()][$place->getDateDeRemplissage()->format('Y-m-d')][$processusActuel->getAbrevProcessus() . '' . $cycleArticle][$dateRetrait->format('Y-m-d')][$quantiter][$quantiter])) {
                                $tableAlertProcessus['processus urgent'][$phaseProcessusPFiliere][$place->getFlotteur()->getSegment()->getFiliere()->getNomFiliere()][$place->getFlotteur()->getSegment()->getNomSegment()][$place->getFlotteur()->getNomFlotteur()][$place->getplace()][$conteneur][$stock->getArticle()->getRefStockArticle()->getRefArticle()->getLibArticle()][$stock->getArticle()->getNumeroSerie()][$place->getDateDeRemplissage()->format('Y-m-d')][$processusActuel->getAbrevProcessus() . '' . $cycleArticle][$dateRetrait->format('Y-m-d')][$quantiter] = array();
                                $tableAlertProcessus['processus urgent']['classColor'] = 'bg-danger';
                            }
                            array_push($tableAlertProcessus['processus urgent'][$phaseProcessusPFiliere][$place->getFlotteur()->getSegment()->getFiliere()->getNomFiliere()][$place->getFlotteur()->getSegment()->getNomSegment()][$place->getFlotteur()->getNomFlotteur()][$place->getplace()][$conteneur][$stock->getArticle()->getRefStockArticle()->getRefArticle()->getLibArticle()][$stock->getArticle()->getNumeroSerie()][$place->getDateDeRemplissage()->format('Y-m-d')][$processusActuel->getAbrevProcessus() . '' . $cycleArticle][$dateRetrait->format('Y-m-d')][$quantiter], $quantiter);
                        }
                    }
                }
            }
        }
        return $this->render('@SSFMB/Default/planingdetravaille.html.twig',
            array(
                'entity' => $parc,
                'tableDesProcessus' => $tableAlertProcessus));
    }

}

