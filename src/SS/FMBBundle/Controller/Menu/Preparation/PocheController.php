<?php

namespace SS\FMBBundle\Controller\Menu\Preparation;


use SS\FMBBundle\Entity\DocsLines;
use SS\FMBBundle\Entity\DocsLinesSn;
use SS\FMBBundle\Entity\Documents;
use SS\FMBBundle\Entity\Historique;
use SS\FMBBundle\Entity\StocksPochesBS;
use SS\FMBBundle\Form\PreparationPocheType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PocheController extends Controller
{
    public function pocheHAction(Request $request)
    {
        if ($this->container->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')) {
            $historique = new Historique();
            $historique->setOperation("preparation Poche");
            $historique->setUtilisateur($this->container->get('security.context')->getToken()->getUser());
            $tacheEffectuer = array();
            $em = $this->getDoctrine()->getManager();
            $processus = $em->getRepository('SSFMBBundle:Processus')->findAll();
            $form = $this->createForm(new PreparationPocheType($em, $processus), null, array('action' => $this->generateUrl('ssfmb_preparationpoche'), 'method' => 'POST', 'attr' => array('class' => "form-horizontal")));
            if ($request->isMethod('POST')) {
                $form->handleRequest($request);
                $stockarticles = $em->getRepository('SSFMBBundle:StocksArticles')->findOneBy(array('idStock' => $form['libStock']->getData()->getIdStock(), 'refArticle' => $form['refArticle']->getData()->getRefArticle()));
                if (!empty($stockarticles)) {
                    $document = new Documents();
                    $time = explode("/", $form['date']->getData());
                    $document->setDateCreationDoc(new \DateTime($time[2] . '-' . $time[1] . '-' . $time[0]));
                    $doclin = new DocsLines();
                    $doclin->setRefDoc($document);
                    $doclin->setQte($form['qte']->getData());
                    $doclin->setLibArticle($form['refArticle']->getData()->getLibArticle());
                    $doclin->setRefArticle($form['refArticle']->getData()->getRefArticle());
                    $docLineSn = new DocsLinesSn();
                    $docLineSn->setRefDocLine($doclin);
                    $docLineSn->setSnQte($form['qte']->getData());
                    $docLineSn->setNumeroSerie($request->request->get("ss_fmbbundle_preparationpoche")['numeroSerie']);
                    $pochesbs = $request->request->get("ss_fmbbundle_preparationpoche")["nomPoche"];
                    $poche = $em->getRepository("SSFMBBundle:PochesBS")->find($pochesbs);
                    $doclin2 = new DocsLines();
                    $doclin2->setRefDoc($document);
                    $doclin2->setLibArticle($poche->getNomPoche());
                    $doclin2->setQte($form['nombre']->getData());
                    $doclin2->setRefDocLineParent($doclin);
                    $doclin2->setRefArticle($poche->getId());

                    $em->persist($document);
                    $em->persist($doclin);
                    $em->persist($docLineSn);
                    $em->persist($doclin2);
                    for ($j = 0; $j < $form['nombre']->getData(); $j++) {
                        $stocksarticlessn = $em->getRepository('SSFMBBundle:StocksArticlesSn')->findOneBy(array('refStockArticle' => $stockarticles, 'numeroSerie' => $request->request->get("ss_fmbbundle_preparationpoche")['numeroSerie']));
                        $stockspochesbs = new StocksPochesBS();
                        $stockspochesbs->setDateDeCreation(new \DateTime($time[2] . '-' . $time[1] . '-' . $time[0]));
                        $stockspochesbs->setArticle($stocksarticlessn);
                        $stockspochesbs->setPochesbs($poche);
                        $stockspochesbs->setDocLine($doclin);
                        $stockspochesbs->setQuantiter($doclin->getQte());
                        $stockspochesbs->setPret(false);
                        $stockarticles->setQte($stockarticles->getQte() - $form['qte']->getData());
                        $stocksarticlessn->setSnQte($stocksarticlessn->getSnQte() - $form['qte']->getData());
                        $em->persist($stockspochesbs);
                    }
                } else {
                    return $this->render('@SSFMB/Default/preparationPoche.html.twig', array('form' => $form->createView(),));
                }
                $tacheEffectuer =
                    array(
                        'parc' => $form['Parc']->getData()->getLibMagasin(),
                        'stock' => $form['libStock']->getData()->getLibStock(),
                        'conteneur' => 'poche',
                        'lanterne' => $request->request->get("ss_fmbbundle_preparationpoche")["nomPoche"],
                        'datePreparation' => $form['date']->getData(),
                        'article' => $form['refArticle']->getData()->getLibArticle(),
                        'lot' => $request->request->get("ss_fmbbundle_preparationlanterne")['numeroSerie'],
                        'dentiter' => $form['qte']->getData(),
                        'nombre' => $form['nombre']->getData(),
                        'ligneDocument' => $doclin2->getRefDocLine()
                    );
                $poche->setNbrTotaleEnStock($poche->getNbrTotaleEnStock() - $form['nombre']->getData());
                $historique->setTacheEffectuer($tacheEffectuer);
                $em->persist($historique);
                $em->flush();
                return $this->redirectToRoute('ssfmb_homepage');
            }
            return $this->render('@SSFMB/Preparation/preparationPoche.html.twig', array('form' => $form->createView(),));
        } else {
            return $this->redirectToRoute('ssfmb_statistique');
        }
    }
}