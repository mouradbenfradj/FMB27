<?php

namespace SS\FMBBundle\Controller\Menu\MAE;

use SS\FMBBundle\Entity\Historique;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CordeController extends Controller
{

    public function miseAEauCordeAction(Request $request)
    {
        if ($this->container->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')) {
            $em = $this->getDoctrine()->getManager();
            if ($request->get('idparc') == null) {
                $parcs = null;
                $stock = null;
                $processus = null;
                $cordes = null;
                $articles = null;
            } else {
                $parcs = $em->getRepository('SSFMBBundle:Magasins')->findOneByIdMagasin($request->get('idparc'));
                $cordes = $em->getRepository('SSFMBBundle:Corde')->findByParc($parcs);
                $processus = $em->getRepository('SSFMBBundle:Processus')->findAll();
                $articles = $em->getRepository('SSFMBBundle:StocksArticles')->findByIdStock($parcs->getIdStock());
            }
            if ($request->isMethod('POST')) {
                $historique = new Historique();
                $historique->setOperation("MAE Corde");
                $historique->setUtilisateur($this->container->get('security.context')->getToken()->getUser());
                $tacheEffectuer = array();

                $dateMiseAEau = new \DateTime($request->request->get('dateMAECorde'));
                $corde = $em->getRepository('SSFMBBundle:Corde')->find($request->request->get('cordechoix'));
                $article = $em->getRepository('SSFMBBundle:Articles')->findOneByLibArticle($request->request->get('articlechoix'));
                $stockArticle = $em->getRepository('SSFMBBundle:StocksArticles')->findOneBy(array('idStock' => $request->request->get('idstockparc'), 'refArticle' => $article));
                $cordearticle = $em->getRepository('SSFMBBundle:StocksCordes')->getCordePreparer($em->getRepository('SSFMBBundle:StocksArticlesSn')->getSAS($stockArticle, $request->request->get('articlelotchoix')), $corde);
                $position = 0;
                $idStockPlaceMAEO = array();
                $idStockCordeMAE = array();
                $processusC = $em->getRepository('SSFMBBundle:Processus')->find($request->request->get('articlecyclechoix'));
                foreach ($request->request->get('placecorde') as $emplacementcorde) {
                    $place = $em->getRepository('SSFMBBundle:Emplacement')->find($emplacementcorde);
                    array_push($idStockPlaceMAEO, $place);
                    array_push($idStockCordeMAE, $cordearticle[$position]);
                    $cordearticle[$position]->setEmplacement($place);
                    $cordearticle[$position]->setDateDeMiseAEau($dateMiseAEau);
                    $cordearticle[$position]->setProcessus($processusC);
                    $place->setStocksCorde($cordearticle[$position]);
                    $place->setDateDeRemplissage($dateMiseAEau);
                    $em->flush();
                    $position++;
                }
                $tacheEffectuer =
                    array(
                        'parc' => $parcs->getLibMagasin(),
                        'nbrCordeMAE' => $position,
                        'typeCorde' => $corde->getNomCorde(),
                        'positionDeMAE' => $idStockPlaceMAEO,
                        'CordeLier' => $idStockCordeMAE,
                        'dateMAE' => $dateMiseAEau,
                        'article' => $request->request->get('articlechoix'),
                        'lot' => $request->request->get('articlelotchoix'),
                        'cycle' => $processusC
                    );
                $historique->setTacheEffectuer($tacheEffectuer);
                $em->persist($historique);
                $em->flush();
                return $this->redirectToRoute('ssfmb_misaaeaucorde');
            }
            return $this->render(
                '@SSFMB/MAE/Corde/miseAEauCorde.html.twig',
                array(
                    'entity' => $parcs,
                    'articles' => $articles,
                    'cordes' => $cordes,
                    'processus' => $processus
                )
            );
        } else {
            return $this->redirectToRoute('ssfmb_statistique');
        }
    }

}