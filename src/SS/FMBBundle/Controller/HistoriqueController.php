<?php

namespace SS\FMBBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SS\FMBBundle\Entity\Historique;
use SS\FMBBundle\Form\HistoriqueType;

/**
 * Historique controller.
 *
 */
class HistoriqueController extends Controller
{

    /**
     * Lists all Historique entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SSFMBBundle:Historique')->findAll();
        krsort($entities);
        return $this->render('SSFMBBundle:Historique:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new Historique entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Historique();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('historique_show', array('id' => $entity->getId())));
        }

        return $this->render('SSFMBBundle:Historique:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Historique entity.
     *
     * @param Historique $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Historique $entity)
    {
        $form = $this->createForm(new HistoriqueType(), $entity, array(
            'action' => $this->generateUrl('historique_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Historique entity.
     *
     */
    public function newAction()
    {
        $entity = new Historique();
        $form = $this->createCreateForm($entity);

        return $this->render('SSFMBBundle:Historique:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Historique entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SSFMBBundle:Historique')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Historique entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SSFMBBundle:Historique:show.html.twig', array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Historique entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SSFMBBundle:Historique')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Historique entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SSFMBBundle:Historique:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Historique entity.
     *
     * @param Historique $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Historique $entity)
    {
        $form = $this->createForm(new HistoriqueType(), $entity, array(
            'action' => $this->generateUrl('historique_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Historique entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SSFMBBundle:Historique')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Historique entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('historique_edit', array('id' => $id)));
        }

        return $this->render('SSFMBBundle:Historique:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Historique entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SSFMBBundle:Historique')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Historique entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('historique'));
    }

    /**
     * Creates a form to delete a Historique entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('historique_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }
}
