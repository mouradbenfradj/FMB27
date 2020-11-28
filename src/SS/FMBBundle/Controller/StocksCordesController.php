<?php

namespace SS\FMBBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SS\FMBBundle\Entity\StocksCordes;
use SS\FMBBundle\Form\StocksCordesType;

/**
 * StocksCordes controller.
 *
 */
class StocksCordesController extends Controller
{
    public function dateCordePreparerAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $cordes = $em->getRepository('SSFMBBundle:StocksCordes')->findBy(array('corde' => $request->query->get('corde'), 'pret' => false, 'dateDeMiseAEau' => null, 'emplacement' => null, 'dateAssemblage' => null));
        $date = array();

        foreach ($cordes as $corde) {
            if (!isset($date[$corde->getDateDeCreation()->format('Y-m-d')][$corde->getArticle()->getRefStockArticle()->getRefArticle()->getLibArticle()][$corde->getArticle()->getNumeroSerie()][$corde->getQuantiter()])) {
                $date[$corde->getDateDeCreation()->format('Y-m-d')][$corde->getArticle()->getRefStockArticle()->getRefArticle()->getLibArticle()][$corde->getArticle()->getNumeroSerie()][$corde->getQuantiter()] = 0;
            }
            $date[$corde->getDateDeCreation()->format('Y-m-d')][$corde->getArticle()->getRefStockArticle()->getRefArticle()->getLibArticle()][$corde->getArticle()->getNumeroSerie()][$corde->getQuantiter()] = $date[$corde->getDateDeCreation()->format('Y-m-d')][$corde->getArticle()->getRefStockArticle()->getRefArticle()->getLibArticle()][$corde->getArticle()->getNumeroSerie()][$corde->getQuantiter()] + 1;
        }
        return new JsonResponse($date);
    }


    public function articleCordePreparerAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $cordes = $em->getRepository('SSFMBBundle:StocksCordes')->findBy(array('corde' => $request->query->get('corde'), 'pret' => false, 'dateDeMiseAEau' => null, 'emplacement' => null, 'dateAssemblage' => null));
        $date = array();

        foreach ($cordes as $corde) {
            if (!isset($date[$corde->getArticle()->getRefStockArticle()->getRefArticle()->getLibArticle()][$corde->getArticle()->getNumeroSerie()][$corde->getQuantiter()])) {
                $date[$corde->getArticle()->getRefStockArticle()->getRefArticle()->getLibArticle()][$corde->getArticle()->getNumeroSerie()][$corde->getQuantiter()] = 0;
            }
            $date[$corde->getArticle()->getRefStockArticle()->getRefArticle()->getLibArticle()][$corde->getArticle()->getNumeroSerie()][$corde->getQuantiter()] = $date[$corde->getArticle()->getRefStockArticle()->getRefArticle()->getLibArticle()][$corde->getArticle()->getNumeroSerie()][$corde->getQuantiter()] + 1;
        }
        return new JsonResponse($date);
    }
    /**
     * Lists all StocksCordes entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SSFMBBundle:StocksCordes')->findAll();

        return $this->render('SSFMBBundle:StocksCordes:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new StocksCordes entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new StocksCordes();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('stockscordes_show', array('id' => $entity->getId())));
        }

        return $this->render('SSFMBBundle:StocksCordes:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a StocksCordes entity.
     *
     * @param StocksCordes $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(StocksCordes $entity)
    {
        $form = $this->createForm(new StocksCordesType(), $entity, array(
            'action' => $this->generateUrl('stockscordes_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new StocksCordes entity.
     *
     */
    public function newAction()
    {
        $entity = new StocksCordes();
        $form = $this->createCreateForm($entity);

        return $this->render('SSFMBBundle:StocksCordes:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a StocksCordes entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SSFMBBundle:StocksCordes')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find StocksCordes entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SSFMBBundle:StocksCordes:show.html.twig', array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing StocksCordes entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SSFMBBundle:StocksCordes')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find StocksCordes entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SSFMBBundle:StocksCordes:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a StocksCordes entity.
     *
     * @param StocksCordes $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(StocksCordes $entity)
    {
        $form = $this->createForm(new StocksCordesType(), $entity, array(
            'action' => $this->generateUrl('stockscordes_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing StocksCordes entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SSFMBBundle:StocksCordes')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find StocksCordes entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('stockscordes_edit', array('id' => $id)));
        }

        return $this->render('SSFMBBundle:StocksCordes:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a StocksCordes entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SSFMBBundle:StocksCordes')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find StocksCordes entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('stockscordes'));
    }

    /**
     * Creates a form to delete a StocksCordes entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('stockscordes_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }
}
