<?php

namespace SS\FMBBundle\Controller\Menu\Preparation;

use SS\FMBBundle\Entity\DocsLines;
use SS\FMBBundle\Entity\DocsLinesSn;
use SS\FMBBundle\Entity\Documents;
use SS\FMBBundle\Entity\Historique;
use SS\FMBBundle\Entity\StocksCordes;
use SS\FMBBundle\Form\PreparationCordeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CordeController extends Controller
{
    public function cordeHAction(Request $request)
    {
        if ($this->container->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')) {
            $historique = new Historique();
            $historique->setOperation("preparation Corde");
            $historique->setUtilisateur($this->container->get('security.context')->getToken()->getUser());
            $tacheEffectuer = array();
            $em = $this->getDoctrine()->getManager();
            $form = $this->createForm(new PreparationCordeType($em), null, array('action' => $this->generateUrl('ssfmb_preparationcorde'), 'method' => 'POST', 'attr' => array('class' => "form-horizontal")));
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
                    $docLineSn->setNumeroSerie($request->request->get("ss_fmbbundle_preparationcorde")['numeroSerie']);
                    $cordes = $request->request->get("ss_fmbbundle_preparationcorde")["nomCorde"];
                    $corde = $em->getRepository("SSFMBBundle:Corde")->findOneBy(array('nomCorde' => $cordes, 'parc' => $form['Parc']->getData()));
                    $doclin2 = new DocsLines();
                    $doclin2->setRefDoc($document);
                    $doclin2->setLibArticle($corde->getNomCorde());
                    $doclin2->setQte($form['nombre']->getData());
                    $doclin2->setRefDocLineParent($doclin);
                    $doclin2->setRefArticle($corde->getId());
                    $em->persist($document);
                    $em->persist($doclin);
                    $em->persist($docLineSn);
                    $em->persist($doclin2);
                    for ($j = 0; $j < $form['nombre']->getData(); $j++) {
                        $stocksarticlessn = $em->getRepository('SSFMBBundle:StocksArticlesSn')->findOneBy(array('refStockArticle' => $stockarticles, 'numeroSerie' => $request->request->get("ss_fmbbundle_preparationcorde")['numeroSerie']));
                        $stockscordes = new StocksCordes();
                        $stockscordes->setDateDeCreation(new \DateTime($time[2] . '-' . $time[1] . '-' . $time[0]));
                        $stockscordes->setArticle($stocksarticlessn);
                        $stockscordes->setCorde($corde);
                        $stockscordes->setDocLine($doclin);
                        $stockscordes->setQuantiter($doclin->getQte());
                        $stockscordes->setPret(false);
                        $stockarticles->setQte($stockarticles->getQte() - $form['qte']->getData());
                        $stocksarticlessn->setSnQte($stocksarticlessn->getSnQte() - $form['qte']->getData());
                        $em->persist($stockscordes);
                    }
                } else {
                    return $this->render('@SSFMB/Default/preparationCorde.html.twig', array('form' => $form->createView(),));
                }
                $tacheEffectuer =
                    array(
                        'parc' => $form['Parc']->getData()->getLibMagasin(),
                        'stock' => $form['libStock']->getData()->getLibStock(),
                        'conteneur' => 'corde',
                        'corde' => $request->request->get("ss_fmbbundle_preparationcorde")["nomCorde"],
                        'datePreparation' => $form['date']->getData(),
                        'article' => $form['refArticle']->getData()->getLibArticle(),
                        'lot' => $request->request->get("ss_fmbbundle_preparationcorde")['numeroSerie'],
                        'dentiter' => $form['qte']->getData(),
                        'nombre' => $form['nombre']->getData(),
                        'ligneDocument' => $doclin2->getRefDocLine()

                    );
                $corde->setNbrTotaleEnStock($corde->getNbrTotaleEnStock() - $form['nombre']->getData());
                $historique->setTacheEffectuer($tacheEffectuer);
                $em->persist($historique);
                $em->flush();
                return $this->redirectToRoute('ssfmb_homepage');
            }
            return $this->render('@SSFMB/Preparation/preparationCorde.html.twig', array('form' => $form->createView(),));
        } else {
            return $this->redirectToRoute('ssfmb_statistique');
        }
    }

}