<?php

namespace SS\FMBBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SS\FMBBundle\Entity\Poche;
use SS\FMBBundle\Form\PocheType;

/**
 * Poche controller.
 *
 */
class PocheController extends Controller
{

    /**
     * Lists all Poche entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SSFMBBundle:Poche')->findAll();

        return $this->render(
            'SSFMBBundle:Poche:index.html.twig',
            array(
                'entities' => $entities,
            )
        );
    }
    /**
     * Creates a new Poche entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Poche();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('poche_show', array('id' => $entity->getId())));
        }

        return $this->render(
            'SSFMBBundle:Poche:new.html.twig',
            array(
                'entity' => $entity,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Creates a form to create a Poche entity.
     *
     * @param Poche $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Poche $entity)
    {
        $form = $this->createForm(
            new PocheType(),
            $entity,
            array(
                'action' => $this->generateUrl('poche_create'),
                'method' => 'POST',
            )
        );

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Poche entity.
     *
     */
    public function newAction()
    {
        $entity = new Poche();
        $form = $this->createCreateForm($entity);

        return $this->render(
            'SSFMBBundle:Poche:new.html.twig',
            array(
                'entity' => $entity,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Finds and displays a Poche entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SSFMBBundle:Poche')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Poche entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render(
            'SSFMBBundle:Poche:show.html.twig',
            array(
                'entity' => $entity,
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Creates a form to delete a Poche entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('poche_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }

    /**
     * Displays a form to edit an existing Poche entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SSFMBBundle:Poche')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Poche entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render(
            'SSFMBBundle:Poche:edit.html.twig',
            array(
                'entity' => $entity,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Creates a form to edit a Poche entity.
     *
     * @param Poche $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Poche $entity)
    {
        $form = $this->createForm(
            new PocheType(),
            $entity,
            array(
                'action' => $this->generateUrl('poche_update', array('id' => $entity->getId())),
                'method' => 'PUT',
            )
        );

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Poche entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SSFMBBundle:Poche')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Poche entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('poche_edit', array('id' => $id)));
        }

        return $this->render(
            'SSFMBBundle:Poche:edit.html.twig',
            array(
                'entity' => $entity,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Deletes a Poche entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SSFMBBundle:Poche')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Poche entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('poche'));
    }
}
