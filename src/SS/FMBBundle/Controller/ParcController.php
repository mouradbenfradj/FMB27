<?php

namespace SS\FMBBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
//use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use SS\FMBBundle\Entity\Parc;
use SS\FMBBundle\Form\ParcType;

/**
 * Parc controller.
 *
 */
class ParcController extends Controller
{

    /**
     * Lists all Parc entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SSFMBBundle:Parc')->findAll();

        return $this->render(
            'SSFMBBundle:Administration/Parc:index.html.twig',
            array(
                'entities' => $entities,
            )
        );
    }

    /**
     * Creates a new Parc entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Parc();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('parc_show', array('id' => $entity->getId())));
        }

        return $this->render(
            'SSFMBBundle:Administration/Parc:new.html.twig',
            array(
                'entity' => $entity,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Creates a form to create a Parc entity.
     *
     * @param Parc $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Parc $entity)
    {
        $form = $this->createForm(
            new ParcType(),
            $entity,
            array(
                'action' => $this->generateUrl('parc_create'),
                'method' => 'POST',
            )
        );

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Parc entity.
     *
     */
    public function newAction()
    {
        $entity = new Parc();
        $form = $this->createCreateForm($entity);

        return $this->render(
            'SSFMBBundle:Administration/Parc:new.html.twig',
            array(
                'entity' => $entity,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Finds and displays a Parc entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SSFMBBundle:Parc')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Parc entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render(
            'SSFMBBundle:Administration/Parc:show.html.twig',
            array(
                'entity' => $entity,
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Creates a form to delete a Parc entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('parc_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }

    /**
     * Displays a form to edit an existing Parc entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SSFMBBundle:Parc')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Parc entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render(
            'SSFMBBundle:Administration/Parc:edit.html.twig',
            array(
                'entity' => $entity,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Creates a form to edit a Parc entity.
     *
     * @param Parc $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Parc $entity)
    {
        $form = $this->createForm(
            new ParcType(),
            $entity,
            array(
                'action' => $this->generateUrl('parc_update', array('id' => $entity->getId())),
                'method' => 'PUT',
            )
        );

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Parc entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SSFMBBundle:Parc')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Parc entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('parc_edit', array('id' => $id)));
        }

        return $this->render(
            'SSFMBBundle:Administration/Parc:edit.html.twig',
            array(
                'entity' => $entity,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Deletes a Parc entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SSFMBBundle:Parc')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Parc entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('parc'));
    }
}
