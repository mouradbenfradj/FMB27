<?php

namespace SS\FMBBundle\Controller\Menu\Preparation;

use SS\FMBBundle\Entity\DocsLines;
use SS\FMBBundle\Entity\DocsLinesSn;
use SS\FMBBundle\Entity\Documents;
use SS\FMBBundle\Entity\Historique;
use SS\FMBBundle\Entity\StocksLanternes;
use SS\FMBBundle\Form\PreparationLanterneType;
use SS\FMBBundle\Implementation\DefaultImpl;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class LanterneController extends Controller
{
    public function lanterneNHAction(Request $request)
    {
        if ($this->container->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')) {
            $historique = new Historique();
            $historique->setOperation("preparation Lanterne");
            $historique->setUtilisateur($this->container->get('security.context')->getToken()->getUser());
            $tacheEffectuer = array();
            $em = $this->getDoctrine()->getManager();
            $form = $this->createForm(new PreparationLanterneType($em), null, array('action' => $this->generateUrl('ssfmb_preparationlanterne'), 'method' => 'POST', 'attr' => array('class' => "form-horizontal", 'id' => "preparationlanterneform")));
            if ($request->isMethod('POST')) {
                $defaultmetier = new DefaultImpl($em);
                $form->handleRequest($request);
                $stockarticles = $em->getRepository('SSFMBBundle:StocksArticles')->findOneBy(array('idStock' => $form['libStock']->getData()->getIdStock(), 'refArticle' => $form['refArticle']->getData()->getRefArticle()));

                if (!empty($stockarticles)) {
                    $document = new Documents();
                    $time = explode("/", $form['date']->getData());
                    $document->setDateCreationDoc(new \DateTime($time[2] . '-' . $time[1] . '-' . $time[0]));
                    $doclin = new DocsLines();
                    $doclin->setRefDoc($document);
                    $docLineSn = new DocsLinesSn();
                    $docLineSn->setRefDocLine($doclin);
                    $docLineSn->setSnQte($form['qte']->getData());
                    $docLineSn->setNumeroSerie($request->request->get("ss_fmbbundle_preparationlanterne")['numeroSerie']);
                    $doclin->setQte($form['qte']->getData());
                    $doclin->setLibArticle($form['refArticle']->getData()->getLibArticle());
                    $doclin->setRefArticle($form['refArticle']->getData()->getRefArticle());
                    $lant = $form['nomLanterne']->getData();
                    $doclin2 = new DocsLines();
                    $doclin2->setRefDoc($document);
                    $doclin2->setLibArticle($lant);
                    $doclin2->setQte($form['nombre']->getData());
                    $doclin2->setRefDocLineParent($doclin);
                    $doclin2->setRefArticle($lant);
                    $em->persist($document);
                    $em->persist($doclin);
                    $em->persist($docLineSn);
                    $em->persist($doclin2);
                    for ($j = 0; $j < $form['nombre']->getData(); $j++) {
                        $stocksarticlessn = $em->getRepository('SSFMBBundle:StocksArticlesSn')->findOneBy(array('refStockArticle' => $stockarticles, 'numeroSerie' => $request->request->get("ss_fmbbundle_preparationlanterne")['numeroSerie']));
                        $stockslanternes = new StocksLanternes();
                        $stockslanternes->setDateDeCreation(new \DateTime($time[2] . '-' . $time[1] . '-' . $time[0]));
                        $stockslanternes->setArticle($stocksarticlessn);
                        $stockslanternes->setLanterne($lant);
                        $stockslanternes->setCycleR(3);
                        $stockslanternes->setDocLine($doclin);
                        $stockarticles->setQte($stockarticles->getQte() - $form['qte']->getData());
                        $stocksarticlessn->setSnQte($stocksarticlessn->getSnQte() - $form['qte']->getData());
                        for ($i = 1; $i < ($stockslanternes->getLanterne()->getNbrpoche() + 1); $i++) {
                            $stockslanternes->addPoch($defaultmetier->remplirPoche($i, $form['qte']->getData(), $stockslanternes->getLanterne()->getNbrpoche()));
                        }
                        $em->persist($stockslanternes);
                    }
                } else {
                    return $this->render('@SSFMB/Default/preparationLanterne.html.twig', array('form' => $form->createView()));
                }
                $tacheEffectuer =
                    array(
                        'parc' => $form['Parc']->getData()->getLibMagasin(),
                        'stock' => $form['libStock']->getData()->getLibStock(),
                        'conteneur' => 'lanterne',
                        'lanterne' => $form['nomLanterne']->getData()->getNomLanterne(),
                        'datePreparation' => $form['date']->getData(),
                        'article' => $form['refArticle']->getData()->getLibArticle(),
                        'lot' => $request->request->get("ss_fmbbundle_preparationlanterne")['numeroSerie'],
                        'dentiter' => $form['qte']->getData(),
                        'nombre' => $form['nombre']->getData(),
                        'ligneDocument' => $doclin2->getRefDocLine()

                    );
                $lant->setNbrTotaleEnStock($lant->getNbrTotaleEnStock() - $form['nombre']->getData());
                $historique->setTacheEffectuer($tacheEffectuer);
                $em->persist($historique);
                $em->flush();
                return $this->redirectToRoute('ssfmb_homepage');
            }
            return $this->render('@SSFMB/Preparation/preparationLanterne.html.twig', array('form' => $form->createView()));
        } else {
            return $this->redirectToRoute('ssfmb_statistique');
        }
    }
}
