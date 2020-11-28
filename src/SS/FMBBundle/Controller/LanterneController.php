<?php

namespace SS\FMBBundle\Controller;

use SS\FMBBundle\Implementation\DefaultImpl;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use SS\FMBBundle\Entity\Lanterne;
use SS\FMBBundle\Form\LanterneType;

/**
 * Lanterne controller.
 *
 */
class LanterneController extends Controller
{
    public function lanterneArticleAction(Request $request)
    {
        $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $implementation = new DefaultImpl($em);

        $lanternearticle = $em->getRepository('SSFMBBundle:StocksLanternes')->getLanternePreparer(
            $em->getRepository('SSFMBBundle:StocksArticlesSn')
                ->findOneBy(array('refStockArticle' => $request->get('ida'), 'numeroSerie' => $request->get('lot')))
            , $request->get('idl')
        );
        count($lanternearticle);
        $tabEnsembles = array();
        $tabtest = array();
        $i = 0;
        foreach ($lanternearticle as $e) { // transformer la réponse de la requete en tableau qui remplira le select pour ensembles
            if (!in_array($implementation->calculerQuantiterLanterne($e), $tabtest)) {
                $tabEnsembles[$i]['id'] = $e->getId();
                $tabEnsembles[$i]['nombre'] = count($lanternearticle);
                $tabEnsembles[$i]['qte'] = $implementation->calculerQuantiterLanterne($e);
                $tabtest[] = $implementation->calculerQuantiterLanterne($e);
            }
            $i++;
        }
        $response = new Response();
        $data = json_encode($tabEnsembles); // formater le résultat de la requête en json
        $response->headers->set('Content-Type', 'miseaeaulanterne/json');
        $response->setContent($data);

        return $response;
    }

    public function nombreLanterneArticleAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $implementation = new DefaultImpl($em);
        $lanternearticle = $em->getRepository('SSFMBBundle:StocksLanternes')->getLanternePreparer(
            $em->getRepository('SSFMBBundle:StocksArticlesSn')
                ->findOneBy(array('refStockArticle' => $request->get('ida'), 'numeroSerie' => $request->get('lot')))
            , $request->get('idl')
        );
        count($lanternearticle);
        $tabEnsembles = array();
        $tabtest = array();
        $i = 0;
        $tt = 1;
        foreach ($lanternearticle as $e) { // transformer la réponse de la requete en tableau qui remplira le select pour ensembles
            if ($implementation->calculerQuantiterLanterne($e) == $request->get('qtech')) {
                $tabEnsembles[$i]['id'] = $e->getId();
                $tabEnsembles[$i]['nombre'] = $tt;
                $tabEnsembles[$i]['qte'] = $implementation->calculerQuantiterLanterne($e);
                $tabtest[] = $implementation->calculerQuantiterLanterne($e);
                $tt++;
            }
            $i++;
        }
        $response = new Response();
        $data = json_encode($tabEnsembles); // formater le résultat de la requête en json
        $response->headers->set('Content-Type', 'miseaeaulanterne/json');
        $response->setContent($data);

        return $response;

    }
}
