<?php

namespace SS\FMBBundle\Controller\Menu\MAE;

use SS\FMBBundle\Entity\Historique;
use SS\FMBBundle\Implementation\AssemblageImpl;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;


class AssemblageController extends Controller
{
    public function miseAEauAssemblageFormulaireAction(Request $request)
    {
        if ($this->container->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')) {
            $em = $this->getDoctrine()->getManager();
            $implementationAssemblage = new AssemblageImpl();
            if ($request->get('idparc') == null) {
                $parcs = null;
                $stock = null;
                $processus = null;
                $assemblages = null;
                $articles = null;
            } else {
                $parcs = $em->getRepository('SSFMBBundle:Magasins')->findOneByIdMagasin($request->get('idparc'));
                $assemblages = $em->getRepository('SSFMBBundle:StocksCordes')->getCordeAssembler($parcs);
                $processus = $em->getRepository('SSFMBBundle:Processus')->findAll();
                $articles = $em->getRepository('SSFMBBundle:StocksArticles')->findByIdStock($parcs->getIdStock());
            }

            $cordeCompare = array();
            $key = 0;
            foreach ($assemblages as $objet1) {
                foreach ($assemblages as $objet2) {
                    if ($implementationAssemblage->compareCordePocheAssemble($objet1, $objet2)) {
                        if (!isset($cordeCompare[$key]['nbrCorde'])) {
                            $cordeCompare[$key]['nbrCorde'] = 0;
                            $cordeCompare[$key]['listCorde'] = array();
                            $cordeCompare[$key]['listPoche'] = array();
                        }
                        $trv = false;
                        for ($verif = $key; $verif >= 0; $verif--) {
                            if (in_array($objet2, $cordeCompare[$verif]['listCorde'])) {
                                $trv = true;
                            }
                        }
                        if (!$trv) {
                            $cordeCompare[$key]['nbrCorde'] = $cordeCompare[$key]['nbrCorde'] + 1;
                            array_push($cordeCompare[$key]['listCorde'], $objet2);
                            $cordeCompare[$key]['listPoche'] = $implementationAssemblage->tableauPoche($cordeCompare[$key]['listPoche'], $objet2->getPocheAssemblage());
                        }
                    }
                }
                $key++;
            }
            if (!empty($cordeCompare)) {
                for ($i = 0; $i <= max(array_keys($cordeCompare)); $i++) {
                    if ($cordeCompare[$i]['nbrCorde'] == 0) {
                        unset($cordeCompare[$i]);
                    }
                }
            }
            $formulaire = $cordeCompare;
            $session = new Session();
            $session->set('assemblage', $cordeCompare);

            return $this->render(
                '@SSFMB/MAE/Assemblage/formulaireAssemble.html.twig',
                array(
                    'entity' => $parcs,
                    'articles' => $articles,
                    'assemblages' => $formulaire,
                    'processus' => $processus
                )
            );
        } else {
            return $this->redirectToRoute('ssfmb_statistique');
        }
    }

    public function miseAEauAssemblageAction(Request $request)
    {
        if ($this->container->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')) {
            $em = $this->getDoctrine()->getManager();
            $session = new Session();
            if ($request->get('idparc') == null) {
                $parcs = null;
                $stock = null;
                $processus = null;
                $assemblages = null;
            } else {
                $parcs = $em->getRepository('SSFMBBundle:Magasins')->findOneByIdMagasin($request->get('idparc'));
                $assemblages = $em->getRepository('SSFMBBundle:StocksPochesBS')->pocheAssemble($parcs);
                $processus = $em->getRepository('SSFMBBundle:Processus')->findAll();
                $tableauChoix = $session->get('assemblage')[$request->get('choixAssemblage')];
            }
            $formulaire = array();

            if ($request->isMethod('POST')) {
                $historique = new Historique();
                $historique->setOperation("MAE Assemblage");
                $historique->setUtilisateur($this->container->get('security.context')->getToken()->getUser());
                $tacheEffectuer = array();

                $dateMiseAEau = new \DateTime($request->request->get('dateMAEAssemblage'));

                $position = 0;
                $idStockPlaceMAEO = array();
                $idStockAssemblageMAE = array();
                $processusC = $em->getRepository('SSFMBBundle:Processus')->find($request->request->get('articlecyclechoix'));
                $assemblagearticle = $tableauChoix['listCorde'];
                $assemblage = $em->getRepository('SSFMBBundle:Corde')->find($assemblagearticle[0]->getCorde()->getId());

                foreach ($request->request->get('placeassemblage') as $emplacementassemblage) {
                    $place = $em->getRepository('SSFMBBundle:Emplacement')->find($emplacementassemblage);

                    array_push($idStockPlaceMAEO, $place);
                    $scordes = $em->getRepository('SSFMBBundle:StocksCordes')->find($assemblagearticle[$position]->getId());

                    array_push($idStockAssemblageMAE, $scordes);
                    $scordes->setEmplacement($place);
                    $scordes->setDateDeMiseAEau($dateMiseAEau);
                    $scordes->setProcessus($processusC);
                    foreach ($scordes->getPocheAssemblage() as $poche) {
                        $poche->setDateDeMiseAEau($dateMiseAEau);
                        $poche->setProcessus($processusC);
                        $em->merge($poche);
                    }
                    $place->setStocksCorde($scordes);
                    $place->setDateDeRemplissage($dateMiseAEau);
                    $em->merge($place);
                    $em->merge($scordes);
                    $em->flush();
                    $position++;
                }
                $tacheEffectuer =
                    array(
                        'parc' => $parcs->getLibMagasin(),
                        'nbrAssemblageMAE' => $position,
                        'typeAssemblage' => $assemblage->getNomCorde(),
                        'positionDeMAE' => $idStockPlaceMAEO,
                        'AssemblageLier' => $idStockAssemblageMAE,
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
            foreach ($assemblages as $valeur) {
                $formulaire[$valeur->getCordeAssemblage()->getCorde()->getId()] = $valeur->getCordeAssemblage();
            }
            return $this->render(
                '@SSFMB/MAE/Assemblage/miseAEauAssemble.html.twig',
                array(
                    'entity' => $parcs,
                    'assemblages' => $formulaire,
                    'processus' => $processus,
                    'nombreCordeChoisie' => sizeof($tableauChoix['listCorde'])
                )
            );
        } else {
            return $this->redirectToRoute('ssfmb_statistique');
        }
    }
}