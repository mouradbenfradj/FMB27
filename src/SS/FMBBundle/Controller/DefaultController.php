<?php

namespace SS\FMBBundle\Controller;

use DateTime;
use SS\FMBBundle\Entity\Articles;
use SS\FMBBundle\Entity\Corde;
use SS\FMBBundle\Entity\DocsLines;
use SS\FMBBundle\Entity\Documents;
use SS\FMBBundle\Entity\Historique;
use SS\FMBBundle\Entity\StocksArticles;
use SS\FMBBundle\Entity\StocksArticlesSn;
use SS\FMBBundle\Entity\StocksArticlesSnVirtuel;
use SS\FMBBundle\Entity\StocksCordes;
use SS\FMBBundle\Entity\StocksLanternes;
use SS\FMBBundle\Form\PreparationCordeType;
use SS\FMBBundle\Form\PreparationLanterneType;
use SS\FMBBundle\Implementation\DefaultImpl;
use SS\FMBBundle\Implementation\ProcessusImplementation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $fonctionnel = true;
        if ($fonctionnel) {
            return $this->redirectToRoute('ssfmb_statistique');
        } else
            return $this->render('@SSFMB/Default/maintenance.html.twig');
    }

    public function correctionAction(Request $request)
    {
        var_dump('correction');
        $em = $this->getDoctrine()->getManager();
        $tableauACorriger = $em->getRepository('SSFMBBundle:StocksCordes')->findBy(array('dateDeRetirement' => NULL, 'dateChaussement' => null, 'chaussement' => true));

        $tabRenvoyer = array();
        $cmp = 0;
        foreach ($tableauACorriger as $objet) {
            if ($objet->getEmplacement() != null) {

                $cmp++;
                $tabRenvoyer[$objet->getEmplacement()->getFlotteur()->getSegment()->getFiliere()->getNomFiliere()][$objet->getEmplacement()->getFlotteur()->getSegment()->getNomSegment()][$objet->getEmplacement()->getFlotteur()->getNomFlotteur()][$objet->getEmplacement()->getPlace()] = $objet;
            }

        }
        return $this->render('SSFMBBundle:Default:correction.html.twig', array('tab' => $tabRenvoyer));
    }

    public function quantiterEnStocksSnActuelAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $stocksArticlesSn = $em->getRepository('SSFMBBundle:StocksArticlesSn')->getSAS($request->get('stocks'), $request->get('lot'));
        return $this->render('SSFMBBundle:Render:quantiterEnStocksArticlesSnRender.html.twig', array(
            'stocksArticlesSn' => $stocksArticlesSn->getSnQte()));
    }

    public function dateFinProcessusAction($dateMAE, $dateRecherche, $processus)
    {
        $dateMAE = new DateTime($dateMAE);
        $dateRecherche = new DateTime($dateRecherche);
        $suivant = true;
        $date = new DateTime($dateMAE->format("Y-m-d"));
        $date = $date->modify($processus->getDuree()['jours'] . ' day');
        $date = $date->modify($processus->getDuree()['mois'] . ' month');
        $date = $date->modify($processus->getDuree()['annee'] . ' year');
        $dateProchainProcessus = $date;
        while (!(($dateMAE <= $dateRecherche) && ($dateRecherche < $dateProchainProcessus)) && $suivant) {
            $processus = $processus->getIdProcessusSuivant();
            $dateMAE = new DateTime($dateProchainProcessus->format("Y-m-d"));
            $date = new DateTime($dateMAE->format("Y-m-d"));
            $date = $date->modify($processus->getDuree()['jours'] . ' day');
            $date = $date->modify($processus->getDuree()['mois'] . ' month');
            $date = $date->modify($processus->getDuree()['annee'] . ' year');
            $dateProchainProcessus = $date;
            if (!$processus->getIdProcessusSuivant()) {
                $suivant = false;
            }
        }
        return $this->render('@SSFMB/Default/Render/dateFinProcessus.html.twig', array('datefin' => $dateProchainProcessus, 'suivant' => $suivant));
    }


    public function pochePreparerAction(Request $request)
    {// Get the province ID
        $id = $request->query->get('poche_id');
        $date = new DateTime($request->query->get('date'));

        $result = array();
        // Return a list of cities, based on the selected province
        $repo = $this->getDoctrine()->getManager()->getRepository('SSFMBBundle:StocksPochesBS');
        $poches = $repo->findBy(array('pochesbs' => $id, 'dateDeCreation' => $date));
        foreach ($poches as $poche) {
            $result[$poche->getQuantiter()] = $poche->getQuantiter();
        }
        return new JsonResponse($result);
    }

    public function datePochePreparerAction(Request $request)
    {// Get the province ID
        $id = $request->query->get('poche_id');

        $result = array();
        // Return a list of cities, based on the selected province
        $repo = $this->getDoctrine()->getManager()->getRepository('SSFMBBundle:StocksPochesBS');
        $poches = $repo->findBy(array('pochesbs' => $id, 'cordeAssemblage' => null));
        foreach ($poches as $poche) {
            $result[$poche->getDateDeCreation()->format('Y-m-d')] = $poche->getDateDeCreation()->format('Y-m-d');
        }

        return new JsonResponse($result);
    }

    public function nombrePochePreparerAction(Request $request)
    {// Get the province ID
        $id = $request->query->get('poche_id');
        $qte = $request->query->get('qte');
        $result = array();
        // Return a list of cities, based on the selected province
        $repo = $this->getDoctrine()->getManager()->getRepository('SSFMBBundle:StocksPochesBS');
        $poches = $repo->findBy(array('pochesbs' => $id, 'quantiter' => $qte, 'cordeAssemblage' => null));
        $result = count($poches);
        return new JsonResponse($result);
    }
}

