<?php

namespace SS\FMBBundle\Controller\Menu\Traitement;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TraitementController extends Controller
{
    public function traitementAction(Request $request)
    {
        if ($this->container->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')) {
            $em = $this->getDoctrine()->getManager();
            if ($request->get('idparc') == null) {
                $parcs = null;
                $stocksnvirtuel = null;
                $articles = null;
            } else {
                $parcs = $em->getRepository('SSFMBBundle:Magasins')->findOneByIdMagasin($request->get('idparc'));
                $stocksnvirtuel = $em->getRepository('SSFMBBundle:StocksArticlesSnVirtuel')->findByRefStockArticle($em->getRepository('SSFMBBundle:StocksArticles')->findByIdStock($parcs->getIdStock()));
                $articles = $em->getRepository('SSFMBBundle:StocksArticles')->findByIdStock($parcs->getIdStock());
            }
            if ($request->isMethod('POST')) {
                $i = 0;
                $stocksnvirtuelt = "";
                $stocksArticlesSnt = "";
                foreach ($request->get('tab') as $item) {
                    switch ($i) {
                        case 0:
                            $stocks = $item;
                            $i++;
                            break;
                        case 1:
                            $stocksnvirtuelt = $em->getRepository('SSFMBBundle:StocksArticlesSnVirtuel')->getSAS($stocks, $item);
                            $stocksArticlesSnt = $em->getRepository('SSFMBBundle:StocksArticlesSn')->getSAS($stocks, $item);
                            $i++;
                            break;
                        case 2:
                            $stocksnvirtuelt->setSnQteTraiterValide($stocksnvirtuelt->getSnQteTraiterValide() + $item);
                            $i++;
                            break;
                        case 3:
                            $stocksnvirtuelt->setSnQteMiseEnVente($stocksnvirtuelt->getSnQteMiseEnVente() + $item);
                            $stocksArticlesSnt->setSnQte($stocksArticlesSnt->getSnQte() + $item);
                            $i++;
                            break;
                        case 4:
                            $stocksnvirtuelt->setSnQteARemettreEnPoche($stocksnvirtuelt->getSnQteARemettreEnPoche() + $item);
                            $stocksArticlesSnt->setSnQte($stocksArticlesSnt->getSnQte() + $item);
                            $i++;
                            break;
                        case 5:
                            $stocksnvirtuelt->setSnQteMorte($stocksnvirtuelt->getSnQteMorte() + $item);
                            $i++;
                            break;
                        case 6:
                            $stocksnvirtuelt->setSnQtePerdu($stocksnvirtuelt->getSnQtePerdu() + $item);
                            $i = 0;
                            $em->flush();
                            break;
                    }
                    //  $stocksnvirtuel->setsnQteMorte($item);
                }
                return $this->redirectToRoute('traitementcomerciale');


            }
            return $this->render('@SSFMB/Default/traitementcomerciale.html.twig',
                array(
                    'entity' => $parcs,
                    'articles' => $articles,
                    'stocksnvirtuel' => $stocksnvirtuel
                )
            );
        } else {
            return $this->redirectToRoute('ssfmb_statistique');
        }
    }
}