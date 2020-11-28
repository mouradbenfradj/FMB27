<?php

namespace SS\FMBBundle\Controller\Menu\Outil;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class HistoriqueOperationController extends Controller
{
    public function historiqueOperationAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $tableauOperationSelect = array();
        $tableauOperation = array();
        if ($request->isMethod('POST')) {
            $tableauOperationSelect = array_merge_recursive($em->getRepository('SSFMBBundle:StocksPochesBS')->findAll(), $em->getRepository('SSFMBBundle:StocksLanternes')->findAll(), $em->getRepository('SSFMBBundle:StocksCordes')->findAll());
            $dateDebut = new \DateTime($request->get('start'));
            $dateFin = new \DateTime($request->get('end'));
            $choix = $request->get('operationCherche');
            switch ($choix) {
                case 0 :
                    foreach ($tableauOperationSelect as $key => $value) {
                        if (method_exists($value, 'getDateAssemblage')) {
                            $max = max(array($value->getDateDeCreation(), $value->getDateDeMiseAEau(), $value->getDateDeRetraitTransfert(), $value->getDateDeMAETransfert(), $value->getDateChaussement(), $value->getDateDeRetirement(), $value->getDateAssemblage()));
                            $max_key = array_search($max, array($value->getDateDeCreation(), $value->getDateDeMiseAEau(), $value->getDateDeRetraitTransfert(), $value->getDateDeMAETransfert(), $value->getDateChaussement(), $value->getDateDeRetirement(), $value->getDateAssemblage()));
                        } else {
                            $max = max(array($value->getDateDeCreation(), $value->getDateDeMiseAEau(), $value->getDateDeRetraitTransfert(), $value->getDateDeMAETransfert(), $value->getDateChaussement(), $value->getDateDeRetirement()));
                            $max_key = array_search($max, array($value->getDateDeCreation(), $value->getDateDeMiseAEau(), $value->getDateDeRetraitTransfert(), $value->getDateDeMAETransfert(), $value->getDateChaussement(), $value->getDateDeRetirement()));
                        }
                        $classe = $em->getRepository(get_class($value))->find($value);
                        if (method_exists($value, 'getLanterne')) {
                            $nomClasse = $classe->getLanterne()->getNomLanterne();
                            $magasine = $classe->getLanterne()->getParc()->getAbrevMagasin();
                        } else if (method_exists($value, 'getCorde')) {
                            $nomClasse = $classe->getCorde()->getNomCorde();
                            $magasine = $classe->getCorde()->getParc()->getAbrevMagasin();
                        } else {
                            $nomClasse = $classe->getPochesbs()->getNomPoche();
                            $magasine = $classe->getPochesbs()->getParc()->getAbrevMagasin();

                        }
                        if ($dateDebut <= $max) {
                            if ($max <= $dateFin) {
                                if (is_null($value->getArticle()->getRefStockArticle())) {
                                } else {
                                    if (!isset($tableauOperation[date_format($max, 'Y-m-d')][$max_key][$value->getArticle()->getRefStockArticle()->getRefArticle()->getLibArticle()][$value->getArticle()->getNumeroSerie()][$magasine][$nomClasse]))
                                        $tableauOperation[date_format($max, 'Y-m-d')][$max_key][$value->getArticle()->getRefStockArticle()->getRefArticle()->getLibArticle()][$value->getArticle()->getNumeroSerie()][$magasine][$nomClasse] = array();
                                    array_push($tableauOperation[date_format($max, 'Y-m-d')][$max_key][$value->getArticle()->getRefStockArticle()->getRefArticle()->getLibArticle()][$value->getArticle()->getNumeroSerie()][$magasine][$nomClasse], $value);
                                }
                            }
                        }
                    }
                    break;
                case 1 :
                    foreach ($tableauOperationSelect as $key => $value) {
                        $max = max(array($value->getDateDeCreation()));
                        $classe = $em->getRepository(get_class($value))->find($value);
                        if (method_exists($value, 'getLanterne')) {
                            $nomClasse = $classe->getLanterne()->getNomLanterne();
                            $magasine = $classe->getLanterne()->getParc()->getAbrevMagasin();
                        } else if (method_exists($value, 'getCorde')) {
                            $nomClasse = $classe->getCorde()->getNomCorde();
                            $magasine = $classe->getCorde()->getParc()->getAbrevMagasin();
                        } else {
                            $nomClasse = $classe->getPochesbs()->getNomPoche();
                            $magasine = $classe->getPochesbs()->getParc()->getAbrevMagasin();
                        }
                        if ($dateDebut <= $max) {
                            if ($max <= $dateFin) {
                                if (!isset($tableauOperation[date_format($max, 'Y-m-d')][0][$value->getArticle()->getRefStockArticle()->getRefArticle()->getLibArticle()][$value->getArticle()->getNumeroSerie()][$magasine][$nomClasse]))
                                    $tableauOperation[date_format($max, 'Y-m-d')][0][$value->getArticle()->getRefStockArticle()->getRefArticle()->getLibArticle()][$value->getArticle()->getNumeroSerie()][$magasine][$nomClasse] = array();
                                array_push($tableauOperation[date_format($max, 'Y-m-d')][0][$value->getArticle()->getRefStockArticle()->getRefArticle()->getLibArticle()][$value->getArticle()->getNumeroSerie()][$magasine][$nomClasse], $value);
                            }
                        }
                    }
                    break;
                case 2 :
                    foreach ($tableauOperationSelect as $key => $value) {
                        $max = max(array($value->getDateDeMiseAEau()));
                        $classe = $em->getRepository(get_class($value))->find($value);
                        if (method_exists($value, 'getLanterne')) {
                            $nomClasse = $classe->getLanterne()->getNomLanterne();
                            $magasine = $classe->getLanterne()->getParc()->getAbrevMagasin();
                        } else if (method_exists($value, 'getCorde')) {
                            $nomClasse = $classe->getCorde()->getNomCorde();
                            $magasine = $classe->getCorde()->getParc()->getAbrevMagasin();
                        } else {
                            $nomClasse = $classe->getPochesbs()->getNomPoche();
                            $magasine = $classe->getPochesbs()->getParc()->getAbrevMagasin();
                        }
                        if ($dateDebut <= $max) {
                            if ($max <= $dateFin) {
                                if (is_null($value->getArticle()->getRefStockArticle())) {
                                } else {
                                    if (!isset($tableauOperation[date_format($max, 'Y-m-d')][1][$value->getArticle()->getRefStockArticle()->getRefArticle()->getLibArticle()][$value->getArticle()->getNumeroSerie()][$magasine][$nomClasse]))
                                        $tableauOperation[date_format($max, 'Y-m-d')][1][$value->getArticle()->getRefStockArticle()->getRefArticle()->getLibArticle()][$value->getArticle()->getNumeroSerie()][$magasine][$nomClasse] = array();
                                    array_push($tableauOperation[date_format($max, 'Y-m-d')][1][$value->getArticle()->getRefStockArticle()->getRefArticle()->getLibArticle()][$value->getArticle()->getNumeroSerie()][$magasine][$nomClasse], $value);
                                }
                            }
                        }
                    }
                    break;
                case 3 :
                    foreach ($tableauOperationSelect as $key => $value) {
                        $max = max(array($value->getDateDeRetirement()));
                        $classe = $em->getRepository(get_class($value))->find($value);
                        if (method_exists($value, 'getLanterne')) {
                            $nomClasse = $classe->getLanterne()->getNomLanterne();
                            $magasine = $classe->getLanterne()->getParc()->getAbrevMagasin();
                        } else if (method_exists($value, 'getCorde')) {
                            $nomClasse = $classe->getCorde()->getNomCorde();
                            $magasine = $classe->getCorde()->getParc()->getAbrevMagasin();
                        } else {
                            $nomClasse = $classe->getPochesbs()->getNomPoche();
                            $magasine = $classe->getPochesbs()->getParc()->getAbrevMagasin();
                        }
                        if ($dateDebut <= $max) {
                            if ($max <= $dateFin) {
                                if (is_null($value->getArticle()->getRefStockArticle())) {
                                } else {
                                    if (!isset($tableauOperation[date_format($max, 'Y-m-d')][5][$value->getArticle()->getRefStockArticle()->getRefArticle()->getLibArticle()][$value->getArticle()->getNumeroSerie()][$magasine][$nomClasse]))
                                        $tableauOperation[date_format($max, 'Y-m-d')][5][$value->getArticle()->getRefStockArticle()->getRefArticle()->getLibArticle()][$value->getArticle()->getNumeroSerie()][$magasine][$nomClasse] = array();
                                    array_push($tableauOperation[date_format($max, 'Y-m-d')][5][$value->getArticle()->getRefStockArticle()->getRefArticle()->getLibArticle()][$value->getArticle()->getNumeroSerie()][$magasine][$nomClasse], $value);
                                }
                            }
                        }
                    }
                    break;
                case 4 :
                    foreach ($tableauOperationSelect as $key => $value) {
                        if (method_exists($value, 'getDateAssemblage')) {
                            $max = max(array($value->getDateAssemblage()));
                            $classe = $em->getRepository(get_class($value))->find($value);
                            if (method_exists($value, 'getLanterne')) {
                                $nomClasse = $classe->getLanterne()->getNomLanterne();
                                $magasine = $classe->getLanterne()->getParc()->getAbrevMagasin();
                            } else if (method_exists($value, 'getCorde')) {
                                $nomClasse = $classe->getCorde()->getNomCorde();
                                $magasine = $classe->getCorde()->getParc()->getAbrevMagasin();
                            } else {
                                $nomClasse = $classe->getPochesbs()->getNomPoche();
                                $magasine = $classe->getPochesbs()->getParc()->getAbrevMagasin();
                            }
                            if ($dateDebut <= $max) {
                                if ($max <= $dateFin) {
                                    if (is_null($value->getArticle()->getRefStockArticle())) {
                                    } else {
                                        if (!isset($tableauOperation[date_format($max, 'Y-m-d')][6][$value->getArticle()->getRefStockArticle()->getRefArticle()->getLibArticle()][$value->getArticle()->getNumeroSerie()][$magasine][$nomClasse]))
                                            $tableauOperation[date_format($max, 'Y-m-d')][6][$value->getArticle()->getRefStockArticle()->getRefArticle()->getLibArticle()][$value->getArticle()->getNumeroSerie()][$magasine][$nomClasse] = array();
                                        array_push($tableauOperation[date_format($max, 'Y-m-d')][6][$value->getArticle()->getRefStockArticle()->getRefArticle()->getLibArticle()][$value->getArticle()->getNumeroSerie()][$magasine][$nomClasse], $value);
                                    }
                                }
                            }
                        }
                    }
                    break;
                case 5 :
                    foreach ($tableauOperationSelect as $key => $value) {
                        $max = max(array($value->getDateDeRetraitTransfert()));
                        $classe = $em->getRepository(get_class($value))->find($value);
                        if (method_exists($value, 'getLanterne')) {
                            $nomClasse = $classe->getLanterne()->getNomLanterne();
                            $magasine = $classe->getLanterne()->getParc()->getAbrevMagasin();
                        } else if (method_exists($value, 'getCorde')) {
                            $nomClasse = $classe->getCorde()->getNomCorde();
                            $magasine = $classe->getCorde()->getParc()->getAbrevMagasin();
                        } else {
                            $nomClasse = $classe->getPochesbs()->getNomPoche();
                            $magasine = $classe->getPochesbs()->getParc()->getAbrevMagasin();
                        }
                        if ($dateDebut <= $max) {
                            if ($max <= $dateFin) {
                                if (is_null($value->getArticle()->getRefStockArticle())) {
                                } else {
                                    if (!isset($tableauOperation[date_format($max, 'Y-m-d')][2][$value->getArticle()->getRefStockArticle()->getRefArticle()->getLibArticle()][$value->getArticle()->getNumeroSerie()][$magasine][$nomClasse]))
                                        $tableauOperation[date_format($max, 'Y-m-d')][2][$value->getArticle()->getRefStockArticle()->getRefArticle()->getLibArticle()][$value->getArticle()->getNumeroSerie()][$magasine][$nomClasse] = array();
                                    array_push($tableauOperation[date_format($max, 'Y-m-d')][2][$value->getArticle()->getRefStockArticle()->getRefArticle()->getLibArticle()][$value->getArticle()->getNumeroSerie()][$magasine][$nomClasse], $value);
                                }
                            }
                        }
                    }
                    break;
                case 6 :
                    foreach ($tableauOperationSelect as $key => $value) {
                        $max = max(array($value->getDateDeMAETransfert()));
                        $classe = $em->getRepository(get_class($value))->find($value);
                        if (method_exists($value, 'getLanterne')) {
                            $nomClasse = $classe->getLanterne()->getNomLanterne();
                            $magasine = $classe->getLanterne()->getParc()->getAbrevMagasin();
                        } else if (method_exists($value, 'getCorde')) {
                            $nomClasse = $classe->getCorde()->getNomCorde();
                            $magasine = $classe->getCorde()->getParc()->getAbrevMagasin();
                        } else {
                            $nomClasse = $classe->getPochesbs()->getNomPoche();
                            $magasine = $classe->getPochesbs()->getParc()->getAbrevMagasin();
                        }
                        if ($dateDebut <= $max) {
                            if ($max <= $dateFin) {
                                if (is_null($value->getArticle()->getRefStockArticle())) {
                                } else {
                                    if (!isset($tableauOperation[date_format($max, 'Y-m-d')][3][$value->getArticle()->getRefStockArticle()->getRefArticle()->getLibArticle()][$value->getArticle()->getNumeroSerie()][$magasine][$nomClasse]))
                                        $tableauOperation[date_format($max, 'Y-m-d')][3][$value->getArticle()->getRefStockArticle()->getRefArticle()->getLibArticle()][$value->getArticle()->getNumeroSerie()][$magasine][$nomClasse] = array();
                                    array_push($tableauOperation[date_format($max, 'Y-m-d')][3][$value->getArticle()->getRefStockArticle()->getRefArticle()->getLibArticle()][$value->getArticle()->getNumeroSerie()][$magasine][$nomClasse], $value);
                                }
                            }
                        }
                    }
                    break;
                case 7 :
                    foreach ($tableauOperationSelect as $key => $value) {
                        $max = max(array($value->getDateChaussement()));
                        $classe = $em->getRepository(get_class($value))->find($value);
                        if (method_exists($value, 'getLanterne')) {
                            $nomClasse = $classe->getLanterne()->getNomLanterne();
                            $magasine = $classe->getLanterne()->getParc()->getAbrevMagasin();
                        } else if (method_exists($value, 'getCorde')) {
                            $nomClasse = $classe->getCorde()->getNomCorde();
                            $magasine = $classe->getCorde()->getParc()->getAbrevMagasin();
                        } else {
                            $nomClasse = $classe->getPochesbs()->getNomPoche();
                            $magasine = $classe->getPochesbs()->getParc()->getAbrevMagasin();
                        }
                        if ($dateDebut <= $max) {
                            if ($max <= $dateFin) {
                                if (is_null($value->getArticle()->getRefStockArticle())) {
                                } else {
                                    if (!isset($tableauOperation[date_format($max, 'Y-m-d')][4][$value->getArticle()->getRefStockArticle()->getRefArticle()->getLibArticle()][$value->getArticle()->getNumeroSerie()][$magasine][$nomClasse]))
                                        $tableauOperation[date_format($max, 'Y-m-d')][4][$value->getArticle()->getRefStockArticle()->getRefArticle()->getLibArticle()][$value->getArticle()->getNumeroSerie()][$magasine][$nomClasse] = array();
                                    array_push($tableauOperation[date_format($max, 'Y-m-d')][4][$value->getArticle()->getRefStockArticle()->getRefArticle()->getLibArticle()][$value->getArticle()->getNumeroSerie()][$magasine][$nomClasse], $value);
                                }
                            }
                        }
                    }
                    break;
            }
        } else {
            foreach ($tableauOperationSelect as $key => $value) {
                if (method_exists($value, 'getDateAssemblage')) {
                    $max = max(array($value->getDateDeCreation(), $value->getDateDeMiseAEau(), $value->getDateDeRetraitTransfert(), $value->getDateDeMAETransfert(), $value->getDateChaussement(), $value->getDateDeRetirement(), $value->getDateAssemblage()));
                    $max_key = array_search($max, array($value->getDateDeCreation(), $value->getDateDeMiseAEau(), $value->getDateDeRetraitTransfert(), $value->getDateDeMAETransfert(), $value->getDateChaussement(), $value->getDateDeRetirement(), $value->getDateAssemblage()));
                } else {
                    $max = max(array($value->getDateDeCreation(), $value->getDateDeMiseAEau(), $value->getDateDeRetraitTransfert(), $value->getDateDeMAETransfert(), $value->getDateChaussement(), $value->getDateDeRetirement()));
                    $max_key = array_search($max, array($value->getDateDeCreation(), $value->getDateDeMiseAEau(), $value->getDateDeRetraitTransfert(), $value->getDateDeMAETransfert(), $value->getDateChaussement(), $value->getDateDeRetirement()));
                }
                $classe = $em->getRepository(get_class($value))->find($value);
                if (method_exists($value, 'getLanterne')) {
                    $nomClasse = $classe->getLanterne()->getNomLanterne();
                    $magasine = $classe->getLanterne()->getParc()->getAbrevMagasin();
                } else if (method_exists($value, 'getCorde')) {
                    $nomClasse = $classe->getCorde()->getNomCorde();
                    $magasine = $classe->getCorde()->getParc()->getAbrevMagasin();
                } else {
                    $nomClasse = $classe->getPochesbs()->getNomPoche();
                    $magasine = $classe->getPochesbs()->getParc()->getAbrevMagasin();
                }
                if (is_null($value->getArticle()->getRefStockArticle())) {
                } else {
                    if (!isset($tableauOperation[date_format($max, 'Y-m-d')][$max_key][$value->getArticle()->getRefStockArticle()->getRefArticle()->getLibArticle()][$value->getArticle()->getNumeroSerie()][$magasine][$nomClasse]))
                        $tableauOperation[date_format($max, 'Y-m-d')][$max_key][$value->getArticle()->getRefStockArticle()->getRefArticle()->getLibArticle()][$value->getArticle()->getNumeroSerie()][$magasine][$nomClasse] = array();
                    array_push($tableauOperation[date_format($max, 'Y-m-d')][$max_key][$value->getArticle()->getRefStockArticle()->getRefArticle()->getLibArticle()][$value->getArticle()->getNumeroSerie()][$magasine][$nomClasse], $value);
                }
            }
        }
        krsort($tableauOperation);
        return $this->render('@SSFMB/Outil/historiqueOperation.html.twig', array('historiqueOperation' => $tableauOperation));
    }

}