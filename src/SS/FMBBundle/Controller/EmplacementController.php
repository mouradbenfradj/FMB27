<?php

namespace SS\FMBBundle\Controller;

use SS\FMBBundle\Entity\Flotteur;
use SS\FMBBundle\Entity\Magasins;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SS\FMBBundle\Entity\Emplacement;
use SS\FMBBundle\Form\EmplacementType;

/**
 * Emplacement controller.
 *
 */
class EmplacementController extends Controller
{

    public function afficherSourceEmplacementAction($id)
    {
        $place = $this->getDoctrine()->getManager()->getRepository('SSFMBBundle:Emplacement')->find($id);
        $message = $place->getFlotteur()->getSegment()->getFiliere()->getNomFiliere();
        $message = $message . '->' . $place->getFlotteur()->getSegment()->getNomSegment();
        $message = $message . '->' . $place->getFlotteur()->getNomFlotteur();
        $message = $message . '->' . $place->getPlace();

        return $this->render('SSFMBBundle:Emplacement:afficherSourceEmplacement.html.twig', array(
            'message' => $message,
        ));
    }

    /**
     * Lists all Emplacement entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SSFMBBundle:Emplacement')->findAll();

        return $this->render('SSFMBBundle:Emplacement:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new Emplacement entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Emplacement();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('emplacement_show', array('id' => $entity->getId())));
        }

        return $this->render('SSFMBBundle:Emplacement:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Emplacement entity.
     *
     * @param Emplacement $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Emplacement $entity)
    {
        $form = $this->createForm(new EmplacementType(), $entity, array(
            'action' => $this->generateUrl('emplacement_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Emplacement entity.
     *
     */
    public function newAction()
    {
        $entity = new Emplacement();
        $form = $this->createCreateForm($entity);

        return $this->render('SSFMBBundle:Emplacement:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Emplacement entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SSFMBBundle:Emplacement')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Emplacement entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SSFMBBundle:Emplacement:show.html.twig', array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to delete a Emplacement entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('emplacement_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }

    /**
     * Displays a form to edit an existing Emplacement entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SSFMBBundle:Emplacement')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Emplacement entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SSFMBBundle:Emplacement:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Emplacement entity.
     *
     * @param Emplacement $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Emplacement $entity)
    {
        $form = $this->createForm(new EmplacementType(), $entity, array(
            'action' => $this->generateUrl('emplacement_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Emplacement entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SSFMBBundle:Emplacement')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Emplacement entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('emplacement_edit', array('id' => $id)));
        }

        return $this->render('SSFMBBundle:Emplacement:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Emplacement entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SSFMBBundle:Emplacement')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Emplacement entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('emplacement'));
    }

    public function findByFlotteurAction(Flotteur $flotteur)
    {
        $em = $this->getDoctrine()->getManager();
        $emplacements = $em->getRepository('SSFMBBundle:Emplacement')->findByFlotteur($flotteur);
        return $this->render('SSFMBBundle:Emplacement/Render:listEmplacementIndexRender.html.twig', array(
            'emplacements' => $emplacements));

    }

    public function getTotaleEmplacementDuParcAction(Magasins $parc)
    {
        $em = $this->getDoctrine()->getManager();
        $totale = $em->getRepository('SSFMBBundle:Emplacement')->getTotaleEmplacementDuParc($parc);
        return $this->render('SSFMBBundle:Emplacement/Render:listEmplacementTotaleByParcRender.html.twig', array(
            'totales' => $totale));
    }
}
