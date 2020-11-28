<?php

namespace SS\FMBBundle\Controller\Menu\MAE;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PocheController extends Controller
{

    public function miseAEauPocheAction(Request $request)
    {
        if ($this->container->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')) {

            $em = $this->getDoctrine()->getManager();
            if ($request->get('idparc') == null) {
                $parcs = null;
                $stock = null;
                $processus = null;
                $poches = null;
                $articles = null;
            } else {
                $parcs = $em->getRepository('SSFMBBundle:Magasins')->findOneByIdMagasin($request->get('idparc'));
                $processus = $em->getRepository('SSFMBBundle:Processus')->findAll();
                $poches = $em->getRepository('SSFMBBundle:PochesBS')->findByParc($parcs);
                $articles = $em->getRepository('SSFMBBundle:StocksArticles')->findByIdStock($parcs->getIdStock());
            }
            if ($request->isMethod('POST')) {
                $dateMiseAEau = new \DateTime($request->request->get('dateMAEPoche'));
                $poche = $em->getRepository('SSFMBBundle:PochesBS')->find($request->request->get('pochechoix'));
                foreach ($request->request->get('placepoche') as $emplacementpoche) {
                    $place = $em->getRepository('SSFMBBundle:Emplacement')->find($emplacementpoche);
                    $pochearticle = $em->getRepository('SSFMBBundle:StocksPochesBS')->getPochePreparer($em->getRepository('SSFMBBundle:StocksArticlesSn')->getSAS($request->request->get('articlechoix'), $request->request->get('articlelotchoix')), $poche);
                    $pochearticle[0]->setEmplacement($place);
                    $pochearticle[0]->setDateDeMiseAEau($dateMiseAEau);
                    $place->setStockspoches($pochearticle[0]);
                    $place->setDateDeRemplissage($dateMiseAEau);
                    $em->flush();
                }
                return $this->redirectToRoute('ssfmb_misaaeaupoche');
            }
            return $this->render(
                '@SSFMB/MAE/Poche/miseAEauPoche.html.twig',
                array(
                    'entity' => $parcs,
                    'articles' => $articles,
                    'poches' => $poches,
                    'processus' => $processus
                )
            );

        } else {
            return $this->redirectToRoute('ssfmb_statistique');
        }
    }
}