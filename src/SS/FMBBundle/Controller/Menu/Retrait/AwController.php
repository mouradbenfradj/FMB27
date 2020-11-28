<?php

namespace SS\FMBBundle\Controller\Menu\Retrait;

use DateTime;
use SS\FMBBundle\Entity\Articles;
use SS\FMBBundle\Entity\StocksArticles;
use SS\FMBBundle\Entity\StocksArticlesSn;
use SS\FMBBundle\Entity\StocksArticlesSnVirtuel;
use SS\FMBBundle\Implementation\DefaultImpl;
use SS\FMBBundle\Implementation\ProcessusImplementation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AwController extends Controller
{
    public function retraitLanterneAction(Request $request)
    {
        if ($this->container->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')) {
            $em = $this->getDoctrine()->getManager();
            if ($request->get('idparc') == null) {
                $parcs = null;
                $processus = null;
                $stock = null;
                $articles = null;
            } else {
                $parcs = $em->getRepository('SSFMBBundle:Magasins')->findOneByIdMagasin($request->get('idparc'));
                $processus = $em->getRepository('SSFMBBundle:Processus')->findAll();
                $articles = $em->getRepository('SSFMBBundle:StocksArticles')->findByIdStock($parcs->getIdStock());
            }

            if ($request->isMethod('POST')) {
                $implementation = new DefaultImpl($em);
                $stock = $em->getRepository('SSFMBBundle:Stocks')->find($request->request->get('stockchoix'));
                foreach ($request->request->get('placelanterne') as $emplacementcorde) {
                    $place = $em->getRepository('SSFMBBundle:Emplacement')->find($emplacementcorde);
                    $slanterne = $place->getStockslanterne();
                    $article = $em->getRepository('SSFMBBundle:Articles')->findOneByLibArticle($slanterne->getProcessus()->getArticleSortie());
                    if (!$article) {
                        $article = new Articles();
                        $article->setLibArticle($slanterne->getProcessus()->getArticleSortie());
                        $article->setLibTicket('');
                        $article->setDescCourte('');
                        $article->setDescLongue('');
                        $article->setRefArtCateg('');
                        $article->setModele('');
                        $article->setPaaLastMaj(new \DateTime());
                        $article->setPromo(0);
                        $article->setValoIndice(0);
                        $article->setLot(true);
                        $article->setComposant(true);
                        $article->setVariante(true);
                        $article->setGestionSn(true);
                        $article->setDateDebutDispo(new \DateTime());
                        $article->setDateFinDispo(new \DateTime());
                        $article->setDispo(true);
                        $article->setDateCreation(new \DateTime());
                        $article->setDateModification(new \DateTime());
                        $article->setIsAchetable(false);
                        $article->setIsVendable(false);
                        $em->persist($article);
                        $em->flush();
                    }
                    $sarticle = $em->getRepository('SSFMBBundle:StocksArticles')->findOneBy(array('refArticle' => $article, 'idStock' => $stock));
                    if (!$sarticle) {
                        $sarticle = new StocksArticles();
                        $sarticle->setRefArticle($article);
                        $sarticle->setQte($implementation->calculerQuantiterLanterne($slanterne));
                        $sarticle->setIdStock($stock);
                        $em->persist($sarticle);
                        $sarticlesn = $em->getRepository('SSFMBBundle:StocksArticlesSN')->getSAS($sarticle->getRefStockArticle(), $slanterne->getArticle()->getNumeroSerie());
                        if (!$sarticlesn) {
                            $sarticlesn = new StocksArticlesSn();
                            $sarticlesn->setNumeroSerie($slanterne->getArticle()->getNumeroSerie());
                            $sarticlesn->setSnQte($implementation->calculerQuantiterLanterne($slanterne));
                            $sarticlesn->setRefStockArticle($sarticle);
                            $em->persist($sarticlesn);
                            $em->flush();
                        }
                    } else {
                        $sarticle->setQte($sarticle->getQte() + $implementation->calculerQuantiterLanterne($slanterne));
                        $sarticlesn = $em->getRepository('SSFMBBundle:StocksArticlesSN')->getSAS($sarticle->getRefStockArticle(), $slanterne->getArticle()->getNumeroSerie());
                        if (!$sarticlesn) {
                            $sarticlesn = new StocksArticlesSn();
                            $sarticlesn->setNumeroSerie($slanterne->getArticle()->getNumeroSerie());
                            $sarticlesn->setSnQte($implementation->calculerQuantiterLanterne($slanterne));
                            $sarticlesn->setRefStockArticle($sarticle);
                            $em->persist($sarticlesn);
                            $em->flush();
                        } else {
                            $sarticlesn->setSnQte($sarticlesn->getSnQte() + $implementation->calculerQuantiterLanterne($slanterne));
                        }
                    }

                    $slanterne->setPret(true);
                    $slanterne->setDateDeRetirement(new \DateTime($request->request->get('dateRetraitLanterne')));
                    $slanterne->getLanterne()->setNbrTotaleEnStock($slanterne->getLanterne()->getNbrTotaleEnStock() + 1);
                    $slanterne->setEmplacement(null);
                    $place->setStockslanterne(null);
                    $place->setDateDeRemplissage(null);
                }
                $em->flush();
                return $this->redirectToRoute('ssfmb_retraitLanterne');

            }

            return $this->render('@SSFMB/Retrait/retraitLanterne.html.twig',
                array(
                    'entity' => $parcs,
                    'articles' => $articles,
                    'processus' => $processus
                )
            );
        } else {
            return $this->redirectToRoute('ssfmb_statistique');
        }
    }


    public function retraitCordeAction(Request $request)
    {
        if ($this->container->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')) {
            $em = $this->getDoctrine()->getManager();
            if ($request->get('idparc') == null) {
                $parcs = null;
                $processus = null;
                $stock = null;
                $articles = null;
            } else {
                $parcs = $em->getRepository('SSFMBBundle:Magasins')->findOneByIdMagasin($request->get('idparc'));
                $processus = $em->getRepository('SSFMBBundle:Processus')->findAll();
                $articles = $em->getRepository('SSFMBBundle:StocksArticles')->findByIdStock($parcs->getIdStock());
            }

            if ($request->isMethod('POST')) {
                $date1 = new DateTime("now");
                $implementationProcessus = new ProcessusImplementation();
                $stock = $em->getRepository('SSFMBBundle:Stocks')->find($request->request->get('stockchoix'));

                ///////////////////////////////////////////////::

                foreach ($request->request->get('placecorde') as $emplacementcorde) {
                    $place = $em->getRepository('SSFMBBundle:Emplacement')->find($emplacementcorde);
                    $interval = date_diff($place->getDateDeRemplissage(), $date1);
                    $scorde = $place->getStockscorde();
                    if ($scorde->getDateAssemblage()) {
                        foreach ($scorde->getPocheAssemblage() as $poche) {

                            $actualProcess = $implementationProcessus->processusArticle($scorde->getProcessus(), $date1, $place->getDateDeRemplissage());
                            $cycleProcess = $implementationProcessus->cycleArticle($scorde->getProcessus(), $date1, $place->getDateDeRemplissage());
                            $article = $em->getRepository('SSFMBBundle:Articles')->findOneByLibArticle($actualProcess->getArticleSortie() . $cycleProcess . " COM");
                            if (!$article) {
                                $article = new Articles();
                                $article->setLibArticle($actualProcess->getArticleSortie() . $cycleProcess . " COM");
                                $article->setLibTicket('l');
                                $article->setDescCourte('e');
                                $article->setDescLongue('e');
                                $article->setRefArtCateg('r');
                                $article->setModele('m');
                                $article->setPaaLastMaj(new \DateTime());
                                $article->setPromo(1);
                                $article->setValoIndice(10);
                                $article->setLot(true);
                                $article->setComposant(true);
                                $article->setVariante(true);
                                $article->setGestionSn(true);
                                $article->setDateDebutDispo(new \DateTime());
                                $article->setDateFinDispo(new \DateTime());
                                $article->setDispo(true);
                                $article->setDateCreation(new \DateTime());
                                $article->setDateModification(new \DateTime());
                                $article->setIsAchetable(true);
                                $article->setIsVendable(true);
                                $em->persist($article);
                                $em->flush();
                            }
                            $sarticle = $em->getRepository('SSFMBBundle:StocksArticles')->findOneBy(array('refArticle' => $article, 'idStock' => $stock));
                            if (!$sarticle) {
                                $sarticle = new StocksArticles();
                                $sarticle->setRefArticle($article);
                                $sarticle->setQte($poche->getQuantiter());
                                $sarticle->setIdStock($stock);
                                $em->persist($sarticle);
                                $sarticlesn1 = $em->getRepository('SSFMBBundle:StocksArticlesSn')->getSAS($sarticle->getRefStockArticle(), $scorde->getArticle()->getNumeroSerie());
                                $sarticlesn = $em->getRepository('SSFMBBundle:StocksArticlesSnVirtuel')->getSAS($sarticle->getRefStockArticle(), $scorde->getArticle()->getNumeroSerie());
                                if (!$sarticlesn && !$sarticlesn1) {
                                    $sarticlesn1 = new StocksArticlesSn();
                                    $sarticlesn1->setNumeroSerie($poche->getArticle()->getNumeroSerie());
                                    $sarticlesn1->setSnQte(0);
                                    $sarticlesn1->setRefStockArticle($sarticle);
                                    $sarticlesn = new StocksArticlesSnVirtuel($poche->getArticle()->getNumeroSerie(), $poche->getQuantiter(), $sarticle);
                                    $em->persist($sarticlesn1);
                                    $em->persist($sarticlesn);
                                    $poche->setArticle($sarticlesn1);
                                    $em->flush();
                                }
                            } else {
                                $sarticle->setQte($sarticle->getQte() + $poche->getQuantiter());
                                $sarticlesn1 = $em->getRepository('SSFMBBundle:StocksArticlesSn')->getSAS($sarticle->getRefStockArticle(), $poche->getArticle()->getNumeroSerie());
                                $sarticlesn = $em->getRepository('SSFMBBundle:StocksArticlesSnVirtuel')->getSAS($sarticle->getRefStockArticle(), $poche->getArticle()->getNumeroSerie());
                                if (!$sarticlesn && !$sarticlesn1) {
                                    $sarticlesn1 = new StocksArticlesSn();
                                    $sarticlesn1->setNumeroSerie($poche->getArticle()->getNumeroSerie());
                                    $sarticlesn1->setSnQte(0);
                                    $sarticlesn1->setRefStockArticle($sarticle);
                                    $sarticlesn = new StocksArticlesSnVirtuel($poche->getArticle()->getNumeroSerie(), $poche->getQuantiter(), $sarticle);
                                    $poche->setArticle($sarticlesn1);
                                    $em->persist($sarticlesn1);
                                    $em->persist($sarticlesn);
                                    $em->flush();
                                } else {
                                    $sarticlesn1->setSnQte($sarticlesn1->getSnQte() + 0);
                                    $sarticlesn->setSnQte($sarticlesn->getSnQte() + $poche->getQuantiter());
                                    $poche->setArticle($sarticlesn1);
                                }
                            }
                        }
                     
                    } else {
                        $actualProcess = $implementationProcessus->processusArticle($scorde->getProcessus(), $date1, $place->getDateDeRemplissage());
                        $cycleProcess = $implementationProcessus->cycleArticle($scorde->getProcessus(), $date1, $place->getDateDeRemplissage());


                        $article = $em->getRepository('SSFMBBundle:Articles')->findOneByLibArticle($actualProcess->getArticleSortie() . $cycleProcess . " COM");
                        if (!$article) {
                            $article = new Articles();
                            $article->setLibArticle($actualProcess->getArticleSortie() . $cycleProcess . " COM");
                            $article->setLibTicket('l');
                            $article->setDescCourte('e');
                            $article->setDescLongue('e');
                            $article->setRefArtCateg('r');
                            $article->setModele('m');
                            $article->setPaaLastMaj(new \DateTime());
                            $article->setPromo(1);
                            $article->setValoIndice(10);
                            $article->setLot(true);
                            $article->setComposant(true);
                            $article->setVariante(true);
                            $article->setGestionSn(true);
                            $article->setDateDebutDispo(new \DateTime());
                            $article->setDateFinDispo(new \DateTime());
                            $article->setDispo(true);
                            $article->setDateCreation(new \DateTime());
                            $article->setDateModification(new \DateTime());
                            $article->setIsAchetable(true);
                            $article->setIsVendable(true);
                            $em->persist($article);
                            $em->flush();
                        }
                        $sarticle = $em->getRepository('SSFMBBundle:StocksArticles')->findOneBy(array('refArticle' => $article, 'idStock' => $stock));
                        if (!$sarticle) {
                            $sarticle = new StocksArticles();
                            $sarticle->setRefArticle($article);
                            $sarticle->setQte($scorde->getQuantiter());
                            $sarticle->setIdStock($stock);
                            $em->persist($sarticle);
                            $sarticlesn1 = $em->getRepository('SSFMBBundle:StocksArticlesSn')->getSAS($sarticle->getRefStockArticle(), $scorde->getArticle()->getNumeroSerie());
                            $sarticlesn = $em->getRepository('SSFMBBundle:StocksArticlesSnVirtuel')->getSAS($sarticle->getRefStockArticle(), $scorde->getArticle()->getNumeroSerie());
                            if (!$sarticlesn && !$sarticlesn1) {
                                $sarticlesn1 = new StocksArticlesSn();
                                $sarticlesn1->setNumeroSerie($scorde->getArticle()->getNumeroSerie());
                                $sarticlesn1->setSnQte(0);
                                $sarticlesn1->setRefStockArticle($sarticle);
                                $sarticlesn = new StocksArticlesSnVirtuel($scorde->getArticle()->getNumeroSerie(), $scorde->getQuantiter(), $sarticle);
                                $em->persist($sarticlesn1);
                                $em->persist($sarticlesn);
                                $scorde->setArticle($sarticlesn1);
                                $em->flush();
                            }
                        } else {
                            $sarticle->setQte($sarticle->getQte() + $scorde->getQuantiter());
                            $sarticlesn1 = $em->getRepository('SSFMBBundle:StocksArticlesSn')->getSAS($sarticle->getRefStockArticle(), $scorde->getArticle()->getNumeroSerie());
                            $sarticlesn = $em->getRepository('SSFMBBundle:StocksArticlesSnVirtuel')->getSAS($sarticle->getRefStockArticle(), $scorde->getArticle()->getNumeroSerie());
                            if (!$sarticlesn && !$sarticlesn1) {
                                $sarticlesn1 = new StocksArticlesSn();
                                $sarticlesn1->setNumeroSerie($scorde->getArticle()->getNumeroSerie());
                                $sarticlesn1->setSnQte(0);
                                $sarticlesn1->setRefStockArticle($sarticle);
                                $sarticlesn = new StocksArticlesSnVirtuel($scorde->getArticle()->getNumeroSerie(), $scorde->getQuantiter(), $sarticle);
                                $scorde->setArticle($sarticlesn1);
                                $em->persist($sarticlesn1);
                                $em->persist($sarticlesn);
                                $em->flush();
                            } else {
                                $sarticlesn1->setSnQte($sarticlesn1->getSnQte() + 0);
                                $sarticlesn->setSnQte($sarticlesn->getSnQte() + $scorde->getQuantiter());
                                $scorde->setArticle($sarticlesn1);
                            }
                        }
                    }
                    $scorde->setPret(true);
                    $scorde->setDateDeRetirement(new \DateTime($request->request->get('dateRetraitCorde')));
                    $scorde->getCorde()->setNbrTotaleEnStock($scorde->getCorde()->getNbrTotaleEnStock() + 1);
                    $scorde->setEmplacement(null);
                    $place->setStockscorde(null);
                    $place->setDateDeRemplissage(null);
                }
                $em->flush();

                return $this->redirectToRoute('ssfmb_retraitcorde');

            }
            return $this->render('@SSFMB/Retrait/retraitCorde.html.twig',
                array(
                    'entity' => $parcs,
                    'articles' => $articles,
                    'processus' => $processus
                )
            );
        } else {
            return $this->redirectToRoute('ssfmb_statistique');
        }
    }
}