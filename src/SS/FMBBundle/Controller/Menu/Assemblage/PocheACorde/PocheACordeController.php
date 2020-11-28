<?php

namespace SS\FMBBundle\Controller\Menu\Assemblage\PocheACorde;

use SS\FMBBundle\Entity\PochesBS;
use SS\FMBBundle\Entity\StocksCordes;
use SS\FMBBundle\Entity\StocksPochesBS;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PocheACordeController extends Controller
{
    public function indexAction(Request $request)
    {
        if ($this->container->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')) {
            $em = $this->getDoctrine()->getManager();
            $parcs = $em->getRepository('SSFMBBundle:Magasins')->findAll();
            if ($request->isMethod('POST')) {
                $tabPocheId = array();
                $tabPocheEntity = array();
                $corde = $em->getRepository('SSFMBBundle:Corde')->find($request->get('corde'));
                $corde->setNbrTotaleEnStock($corde->getNbrTotaleEnStock() - $request->get('nbrCordeAssemblage'));
                $em->merge($corde);
                for ($i = 0; $i < $request->get('nbrCordeAssemblage'); $i++) {
                    $stockCorde = new StocksCordes();
                    $stockCorde->setCorde($corde);
                    $stockCorde->setPret(false);
                    $stockCorde->setDateDeCreation(new \DateTime($request->get('dateAssemblage')));
                    $stockCorde->setDateAssemblage(new \DateTime($request->get('dateAssemblage')));
                    $stockCorde->setQuantiter(0);
                    $em->persist($stockCorde);
                    $contenuCompteur = 0;
                    foreach ($request->get('contenu') as $contenu) {
                        $contenuCompteur++;
                        switch ($contenuCompteur) {
                            case 1 :
                                // $nbrTotale = $contenu;
                                break;
                            case 2 :
                                $nbrAFabriquer = $contenu;
                                break;
                            case 3 :
                                $pocheId = $contenu;
                                break;
                            case 4 :
                                $date = $contenu;
                                break;
                            case 5 :
                                $qteU = $contenu;
                                if (!in_array($pocheId, $tabPocheId)) {
                                    array_push($tabPocheId, $pocheId);
                                    $tabPocheEntity[$pocheId] = $em->getRepository('SSFMBBundle:PochesBS')->find($pocheId);
                                }
                                for ($cmp = 0; $cmp < $nbrAFabriquer; $cmp++) {
                                    $poche = $tabPocheEntity[$pocheId];
                                    $stocksPocheBs = $em->getRepository('SSFMBBundle:StocksPochesBs')->findOneBy(array('pochesbs' => $pocheId, 'quantiter' => $qteU, 'pret' => false, 'dateDeCreation' => new \DateTime($date), 'cordeAssemblage' => null));
                                    $stocksPocheBs->setCordeAssemblage($stockCorde);
                                    $stocksPocheBs->setDateAssemblage(new \DateTime($request->get('dateAssemblage')));
                                    $stockCorde->setArticle($stocksPocheBs->getArticle());
                                    $stockCorde->setQuantiter($stockCorde->getQuantiter() + $qteU);
                                    $em->merge($stocksPocheBs);
                                    $em->flush();
                                }
                                $em->merge($stockCorde);
                                $contenuCompteur = 0;
                                break;
                        }
                    }
                    $em->flush();
                }
                return $this->render('@SSFMB/Assemblage/PocheACorde.html.twig',
                    array('parcs' => null)
                );
            }

            return $this->render('@SSFMB/Assemblage/PocheACorde.html.twig',
                array('parcs' => $parcs)
            );
        } else {
            return $this->redirectToRoute('ssfmb_statistique');
        }
    }
}
