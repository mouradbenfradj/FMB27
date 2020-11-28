<?php

namespace SS\FMBBundle\Controller\Menu\Transfert;

use SS\FMBBundle\Entity\Historique;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class TransfertMAEController extends Controller
{

    public function transfertMAEAction(Request $request)
    {
        if ($this->container->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')) {
            $session = new Session();
            //  var_dump($session->get('lanterne'));
            // var_dump($session->get('corde'));
            $em = $this->getDoctrine()->getManager();
            if ($request->get('idparc') == null) {
                $parcs = null;
                $processus = null;
                $stock = null;
                $cordes = null;
                $articles = null;
            } else {
                $processus = $em->getRepository('SSFMBBundle:Processus')->findAll();
                $parcs = $em->getRepository('SSFMBBundle:Magasins')->findOneByIdMagasin($request->get('idparc'));
                $cordes = $em->getRepository('SSFMBBundle:Corde')->findByParc($parcs);
                $articles = $em->getRepository('SSFMBBundle:StocksArticles')->findByIdStock($parcs->getIdStock());
            }
            if ($request->isMethod('POST')) {
                $cmpt = 0;
                $historique = new Historique();
                $historique->setOperation("transfert MAE");
                $historique->setUtilisateur($this->container->get('security.context')->getToken()->getUser());
                $tacheEffectuer = array();
                $placeMouvement['origine'] = array();
                $placeMouvement['article'] = array();
                $placeMouvement['destination'] = array();
                foreach ($request->request->get('place') as $emplacement) {
                    $place = $em->getRepository('SSFMBBundle:Emplacement')->find($emplacement);

                    if ($cmpt < count($session->get('emplacement'))) {
                        if ($session->get('emplacement')[$cmpt]->getStockscorde() != null) {
                            $anarticle = $em->getRepository('SSFMBBundle:StocksCordes')->find($session->get('emplacement')[$cmpt]->getStockscorde());
                            $anplace = $em->getRepository('SSFMBBundle:Emplacement')->find($session->get('emplacement')[$cmpt]);
                            $anarticle->setEmplacement(null);
                            $anplace->setStockscorde(null);
                            $place->setDateDeRemplissage($anplace->getDateDeRemplissage());
                            $anplace->setDateDeRemplissage(null);
                            $em->flush();
                            $place->setStockscorde($anarticle);
                            $anarticle->setEmplacement($place);
                            $anarticle->setDateDeRetraitTransfert($session->get('dateTransfertRetrait'));
                            $anarticle->setDateDeMAETransfert(new \DateTime($request->request->get('dateRemise')));
                            array_push($placeMouvement['article'], $anarticle);
                            array_push($placeMouvement['origine'], $anplace->getId());
                            array_push($placeMouvement['destination'], $place->getId());
                            $cmpt++;

                        } else if (($session->get('emplacement')[$cmpt]->getStockslanterne() != null) && ($cmpt < count($session->get('emplacement')))) {
                            $anarticle = $em->getRepository('SSFMBBundle:StocksLanternes')->find($session->get('emplacement')[$cmpt]->getStockslanterne());
                            $anplace = $em->getRepository('SSFMBBundle:Emplacement')->find($session->get('emplacement')[$cmpt]);
                            $anplace->setStockslanterne(null);
                            $anarticle->setEmplacement(null);
                            $place->setDateDeRemplissage($anplace->getDateDeRemplissage());
                            $anplace->setDateDeRemplissage(null);
                            $em->flush();
                            $place->setStockslanterne($anarticle);
                            $anarticle->setEmplacement($place);
                            $anarticle->setDateDeRetraitTransfert($session->get('dateTransfertRetrait'));
                            $anarticle->setDateDeMAETransfert(new \DateTime($request->request->get('dateRemise')));
                            array_push($placeMouvement['article'], $anarticle);
                            array_push($placeMouvement['origine'], $anplace->getId());
                            array_push($placeMouvement['destination'], $place->getId());
                            $cmpt++;

                        }
                    }
                }
                $tacheEffectuer =
                    array(
                        'parc' => $parcs->getLibMagasin(),
                        'transfert' => $placeMouvement,
                        'dateTransfert' => $session->get('dateTransfertRetrait'),
                        'dateRMAE' => $request->request->get('dateRemise'),
                        'nombre' => $cmpt
                    );
                $historique->setTacheEffectuer($tacheEffectuer);
                $em->persist($historique);
                $em->flush();
                return $this->redirectToRoute('ssfmb_transfert');
            }
            return $this->render(
                '@SSFMB/MAE/transfertMAE.html.twig',
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