<?php

namespace SS\FMBBundle\Controller\Menu\Chaussement;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ChaussementController extends Controller
{
    public function chasseeAction(Request $request)
    {
        if ($this->container->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')) {
            $em = $this->getDoctrine()->getManager();

            if ($request->get('idparc') == null) {
                $parcs = null;
                $processus = null;
                $stock = null;
                $lanternes = null;
                $articles = null;
            } else {
                $parcs = $em->getRepository('SSFMBBundle:Magasins')->findOneByIdMagasin($request->get('idparc'));
                $processus = $em->getRepository('SSFMBBundle:Processus')->findAll();
                $lanternes = $em->getRepository('SSFMBBundle:Lanterne')->findByParc($parcs);
                $articles = $em->getRepository('SSFMBBundle:StocksArticles')->findByIdStock($parcs->getIdStock());
            }
            if ($request->isMethod('POST')) {
                foreach ($request->request->get('place') as $emplacement) {
                    $place = $em->getRepository('SSFMBBundle:Emplacement')->find($emplacement);
                    if ($place->getStockscorde()) {
                        $contenu = $place->getStockscorde();
                    } elseif ($place->getStockslanterne()) {
                        $contenu = $place->getStockslanterne();
                    } elseif ($place->getStockspoches()) {
                        $contenu = $place->getStockspoches();
                    }
                    $contenu->setDateChaussement(new \DateTime($request->request->get('dateChaussement')));
                    $contenu->setChaussement(true);
                    $em->merge($contenu);
                }
                $em->flush();
                return $this->redirectToRoute('ssfmb_chaussement');
            }
            return $this->render(
                '@SSFMB/Chaussement/Chaussement.html.twig',
                array(
                    'entity' => $parcs,
                    'articles' => $articles,
                    'lanternes' => $lanternes,
                    'processus' => $processus
                )
            );
        } else {
            return $this->redirectToRoute('ssfmb_statistique');
        }
    }
}