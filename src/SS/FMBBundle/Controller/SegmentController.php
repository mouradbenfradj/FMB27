<?php

namespace SS\FMBBundle\Controller;

use SS\FMBBundle\Entity\Filiere;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SS\FMBBundle\Entity\Segment;
use SS\FMBBundle\Form\SegmentType;

/**
 * Segment controller.
 *
 */
class SegmentController extends Controller
{

    /**
     * Lists all Segment entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SSFMBBundle:Segment')->findAll();

        return $this->render('SSFMBBundle:Segment:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new Segment entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Segment();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('segment_show', array('id' => $entity->getId())));
        }

        return $this->render('SSFMBBundle:Segment:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Segment entity.
     *
     * @param Segment $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Segment $entity)
    {
        $form = $this->createForm(new SegmentType(), $entity, array(
            'action' => $this->generateUrl('segment_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Segment entity.
     *
     */
    public function newAction()
    {
        $entity = new Segment();
        $form = $this->createCreateForm($entity);

        return $this->render('SSFMBBundle:Segment:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Segment entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SSFMBBundle:Segment')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Segment entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SSFMBBundle:Segment:show.html.twig', array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to delete a Segment entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('segment_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }

    /**
     * Displays a form to edit an existing Segment entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SSFMBBundle:Segment')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Segment entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SSFMBBundle:Segment:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Segment entity.
     *
     * @param Segment $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Segment $entity)
    {
        $form = $this->createForm(new SegmentType(), $entity, array(
            'action' => $this->generateUrl('segment_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Segment entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SSFMBBundle:Segment')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Segment entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('segment_edit', array('id' => $id)));
        }

        return $this->render('SSFMBBundle:Segment:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Segment entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SSFMBBundle:Segment')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Segment entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('segment'));
    }

    public function findByFiliereAction(Filiere $filiere)
    {
        $em = $this->getDoctrine()->getManager();
        $segments = $em->getRepository('SSFMBBundle:Segment')->findByFiliere($filiere);
        return $this->render('@SSFMB/Segment/Render/listSegmentIndexRender.html.twig', array(
            'segments' => $segments));
    }
}
