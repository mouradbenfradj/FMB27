<?php

namespace SS\FMBBundle\Controller;

use DateTime;
use SS\FMBBundle\Entity\Magasins;
use SS\FMBBundle\Entity\Processus;
use SS\FMBBundle\Implementation\ProcessusImplementation;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SS\FMBBundle\Entity\Filiere;
use SS\FMBBundle\Form\FiliereType;

/**
 * Filiere controller.
 *
 */
class FiliereController extends Controller
{

    /**
     * Lists all Filiere entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SSFMBBundle:Filiere')->findAll();

        return $this->render('SSFMBBundle:Filiere:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new Filiere entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Filiere();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('filiere_show', array('id' => $entity->getId())));
        }

        return $this->render('SSFMBBundle:Filiere:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Filiere entity.
     *
     * @param Filiere $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Filiere $entity)
    {
        $form = $this->createForm(new FiliereType(), $entity, array(
            'action' => $this->generateUrl('filiere_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Filiere entity.
     *
     */
    public function newAction()
    {
        $entity = new Filiere();
        $form = $this->createCreateForm($entity);

        return $this->render('SSFMBBundle:Filiere:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Filiere entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('SSFMBBundle:Filiere')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Filiere entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SSFMBBundle:Filiere:show.html.twig', array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to delete a Filiere entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('filiere_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }

    /**
     * Displays a form to edit an existing Filiere entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SSFMBBundle:Filiere')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Filiere entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SSFMBBundle:Filiere:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Filiere entity.
     *
     * @param Filiere $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Filiere $entity)
    {
        $form = $this->createForm(new FiliereType(), $entity, array(
            'action' => $this->generateUrl('filiere_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Filiere entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SSFMBBundle:Filiere')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Filiere entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('filiere_edit', array('id' => $id)));
        }

        return $this->render('SSFMBBundle:Filiere:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Filiere entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SSFMBBundle:Filiere')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Filiere entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('filiere'));
    }

    public function findByParcAction(Magasins $parc, $page)
    {
        $datenow = new DateTime('now');
        $em = $this->getDoctrine()->getManager();
        $implementation = new ProcessusImplementation();
        $filieress = $em->getRepository('SSFMBBundle:Filiere')->getTotaleContenuFiliere($parc);
        $filieres = array();
        $pp = 0;
        foreach ($filieress as $item) {
            $filieres[$item['fiId']]['nomFiliere'] = $item['nomFiliere'];
            $filieres[$item['fiId']]['observation'] = $item['observation'];
            $filieres[$item['fiId']]['aireDeTravaille'] = $item['aireDeTravaille'];
            $filieres[$item['fiId']][$item['sId']]['longeur'] = $item['longeur'];
            $filieres[$item['fiId']][$item['sId']]['nomSegment'] = $item['nomSegment'];
            $filieres[$item['fiId']][$item['sId']][$item['flId']]['nomFlotteur'] = $item['nomFlotteur'];
            $clp = '';
            $clpf = '';
            $abp = '';
            $debC = 0;
            $cycle = 0;
            if ($item['processusl']) {
                if ($item['processusl'] != $pp) {
                    $process = $em->getRepository('SSFMBBundle:Processus')->find($item['processusl']);
                    $debC = $item['numDebCyclel'];
                    $pp = $item['processusl'];
                }
            } elseif ($item['processusc']) {
                if ($item['processusc'] != $pp) {
                    $process = $em->getRepository('SSFMBBundle:Processus')->find($item['processusc']);
                    $debC = $item['numDebCyclec'];
                    $pp = $item['processusc'];
                }
            } elseif ($item['processusp']) {
                if ($item['processusp'] != $pp) {
                    $process = $em->getRepository('SSFMBBundle:Processus')->find($item['processusp']);
                    $debC = $item['numDebCyclep'];
                    $pp = $item['processusp'];
                }
            }

            if ($item['dateDeRemplissage']) {

                if ($implementation->processusArticle($process, $datenow, $item['dateDeRemplissage'])) {
                    $processus = $implementation->processusArticle($process, $datenow, $item['dateDeRemplissage']);
                    $abp = $processus->getAbrevProcessus();
                    $clp = $processus->getCouleur();
                    $clpf = $processus->getCouleurDuFond();
                    $cycle = $implementation->cycleArticle($process, $datenow, $item['dateDeRemplissage']);
                }
            } else {
                $abp = "error test ";
            }
            if($item['dateAssemblage'])
            {
                $assemblage = $item['dateAssemblage'];
            }else{
                $assemblage = null;
            }
            $filieres[$item['fiId']][$item['sId']][$item['flId']][$item['empId']] =
                array(
                    'place' => $item['place'],
                    'numeroSerieLanrt' => $item['numeroSerieLanrt'],
                    'numeroSeriePoche' => $item['numeroSeriePoche'],
                    'plibArticle' => $item['plibArticle'],
                    'llibArticle' => $item['llibArticle'],
                    'libArticle' => $item['libArticle'],
                    'nomLanterne' => $item['nomLanterne'],
                    'nomCorde' => $item['nomCorde'],
                    'numeroSerie' => $item['numeroSerie'],
                    'dateDTL' => $item['maelt'],
                    'dateDTC' => $item['maect'],
                    'dateDTP' => $item['maept'],
                    'dateAsmblg' => $assemblage,
                    'dateDeRemplissage' => $item['dateDeRemplissage'],
                    'stockscorde' => $item['sc'],
                    'stockslanterne' => $item['sl'],
                    'stockspoche' => $item['sp'],
                    'chausl' => $item['chausl'],
                    'chausc' => $item['chausc'],
                    'chausp' => $item['chausp'],
                    'cycle' => $cycle,
                    'numDebCyclel' => $debC,
                    'abrevProcessus' => $abp,
                    'couleur' => $clp,
                    'couleurDuFond' => $clpf,

                    'processusp' => $item['processusp']
                );
        }
        return $this->render('@SSFMB/Filiere/Render/listFiliereIndexRender.html.twig', array('filieres' => $filieres, 'page' => $page));
    }

    public function observationAction()
    {
        $request = $this->container->get('request');
        $observation = '';
        $observation = $request->request->get('observation');
        $id = $request->request->get('idf');

        $em = $this->container->get('doctrine')->getEntityManager();
        if ($observation != '') {
            $filiere = $em->getRepository('SSFMBBundle:Filiere')->findOneById($id);
            $observations = array_merge(array(new DateTime(), $observation), $filiere->getObservation());
            $filiere->setObservation($observations);
            $em->flush();
            $observations = $filiere->getObservation();
        } else {
            $filiere = $em->getRepository('SSFMBBundle:Filiere')->findOneById($id);
            $observations = array_merge($filiere->getObservation());
        }

        return $this->container->get('templating')->renderResponse('@SSFMB/Filiere/Include/listObservationFiliere.html.twig', array(
            'observations' => $observations
        ));

    }


}
