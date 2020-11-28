<?php

namespace SS\FMBBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SS\FMBBundle\Entity\DocsLines;
use SS\FMBBundle\Form\DocsLinesType;

/**
 * DocsLines controller.
 *
 */
class DocsLinesController extends Controller
{

    /**
     * Lists all DocsLines entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SSFMBBundle:DocsLines')->findAll();

        return $this->render(
            'SSFMBBundle:DocsLines:index.html.twig',
            array(
                'entities' => $entities,
            )
        );
    }

    /**
     * Creates a new DocsLines entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new DocsLines();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('docslines_show', array('id' => $entity->getId())));
        }

        return $this->render(
            'SSFMBBundle:DocsLines:new.html.twig',
            array(
                'entity' => $entity,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Creates a form to create a DocsLines entity.
     *
     * @param DocsLines $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(DocsLines $entity)
    {
        $form = $this->createForm(
            new DocsLinesType(),
            $entity,
            array(
                'action' => $this->generateUrl('docslines_create'),
                'method' => 'POST',
            )
        );

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new DocsLines entity.
     *
     */
    public function newAction()
    {
        $entity = new DocsLines();
        $form = $this->createCreateForm($entity);

        return $this->render(
            'SSFMBBundle:DocsLines:new.html.twig',
            array(
                'entity' => $entity,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Finds and displays a DocsLines entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SSFMBBundle:DocsLines')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DocsLines entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render(
            'SSFMBBundle:DocsLines:show.html.twig',
            array(
                'entity' => $entity,
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Creates a form to delete a DocsLines entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('docslines_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }

    /**
     * Displays a form to edit an existing DocsLines entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SSFMBBundle:DocsLines')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DocsLines entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render(
            'SSFMBBundle:DocsLines:edit.html.twig',
            array(
                'entity' => $entity,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Creates a form to edit a DocsLines entity.
     *
     * @param DocsLines $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(DocsLines $entity)
    {
        $form = $this->createForm(
            new DocsLinesType(),
            $entity,
            array(
                'action' => $this->generateUrl('docslines_update', array('id' => $entity->getId())),
                'method' => 'PUT',
            )
        );

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing DocsLines entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SSFMBBundle:DocsLines')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DocsLines entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('docslines_edit', array('id' => $id)));
        }

        return $this->render(
            'SSFMBBundle:DocsLines:edit.html.twig',
            array(
                'entity' => $entity,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Deletes a DocsLines entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SSFMBBundle:DocsLines')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find DocsLines entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('docslines'));
    }
}
