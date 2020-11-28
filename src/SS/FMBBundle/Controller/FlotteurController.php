<?php

namespace SS\FMBBundle\Controller;

use SS\FMBBundle\Entity\Segment;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SS\FMBBundle\Entity\Flotteur;
use SS\FMBBundle\Form\FlotteurType;

/**
 * Flotteur controller.
 *
 */
class FlotteurController extends Controller
{

    /**
     * Lists all Flotteur entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SSFMBBundle:Flotteur')->findAll();

        return $this->render('SSFMBBundle:Flotteur:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new Flotteur entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Flotteur();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('flotteur_show', array('id' => $entity->getId())));
        }

        return $this->render('SSFMBBundle:Flotteur:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Flotteur entity.
     *
     * @param Flotteur $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Flotteur $entity)
    {
        $form = $this->createForm(new FlotteurType(), $entity, array(
            'action' => $this->generateUrl('flotteur_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Flotteur entity.
     *
     */
    public function newAction()
    {
        $entity = new Flotteur();
        $form = $this->createCreateForm($entity);

        return $this->render('SSFMBBundle:Flotteur:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Flotteur entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SSFMBBundle:Flotteur')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Flotteur entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SSFMBBundle:Flotteur:show.html.twig', array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to delete a Flotteur entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('flotteur_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }

    /**
     * Displays a form to edit an existing Flotteur entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SSFMBBundle:Flotteur')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Flotteur entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SSFMBBundle:Flotteur:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Flotteur entity.
     *
     * @param Flotteur $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Flotteur $entity)
    {
        $form = $this->createForm(new FlotteurType(), $entity, array(
            'action' => $this->generateUrl('flotteur_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Flotteur entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SSFMBBundle:Flotteur')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Flotteur entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('flotteur_edit', array('id' => $id)));
        }

        return $this->render('SSFMBBundle:Flotteur:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Flotteur entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SSFMBBundle:Flotteur')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Flotteur entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('flotteur'));
    }

    public function findBySegmentAction(Segment $segment)
    {
        $em = $this->getDoctrine()->getManager();
        $flotteurs = $em->getRepository('SSFMBBundle:Flotteur')->findBySegment($segment);
        return $this->render('@SSFMB/Flotteur/Render/listFlotteurIndexRender.html.twig', array(
            'flotteurs' => $flotteurs));
    }
}

