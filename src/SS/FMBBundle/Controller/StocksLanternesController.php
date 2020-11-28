<?php

namespace SS\FMBBundle\Controller;

use SS\FMBBundle\Implementation\DefaultImpl;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SS\FMBBundle\Entity\StocksLanternes;
use SS\FMBBundle\Form\StocksLanternesType;

/**
 * StocksLanternes controller.
 *
 */
class StocksLanternesController extends Controller
{
    public function dateLanternePreparerAction(Request $request)
    {// Get the province ID
        $id = $request->query->get('lanterne');
        $em = $this->getDoctrine()->getManager();
        $implementation = new DefaultImpl($em);
        $lanternes = $em->getRepository('SSFMBBundle:StocksLanternes')->findBy(array('lanterne' => $id, 'pret' => false, 'dateDeMiseAEau' => null, 'emplacement' => null));
        $date = array();

        foreach ($lanternes as $lanterne) {
            if (!isset($date[$lanterne->getDateDeCreation()->format('Y-m-d')][$lanterne->getArticle()->getRefStockArticle()->getRefArticle()->getLibArticle()][$lanterne->getArticle()->getNumeroSerie()][$implementation->calculerQuantiterLanterne($lanterne)])) {
                $date[$lanterne->getDateDeCreation()->format('Y-m-d')][$lanterne->getArticle()->getRefStockArticle()->getRefArticle()->getLibArticle()][$lanterne->getArticle()->getNumeroSerie()][$implementation->calculerQuantiterLanterne($lanterne)] = 0;
            }
            $date[$lanterne->getDateDeCreation()->format('Y-m-d')][$lanterne->getArticle()->getRefStockArticle()->getRefArticle()->getLibArticle()][$lanterne->getArticle()->getNumeroSerie()][$implementation->calculerQuantiterLanterne($lanterne)] = $date[$lanterne->getDateDeCreation()->format('Y-m-d')][$lanterne->getArticle()->getRefStockArticle()->getRefArticle()->getLibArticle()][$lanterne->getArticle()->getNumeroSerie()][$implementation->calculerQuantiterLanterne($lanterne)] + 1;
        }
        return new JsonResponse($date);
    }


    public function articleLanternePreparerAction(Request $request)
    {// Get the province ID
        $id = $request->query->get('lanterne');
        $em = $this->getDoctrine()->getManager();
        $implementation = new DefaultImpl($em);
        //$lanternes = $em->getRepository('SSFMBBundle:StocksLanternes')->findBy(array('lanterne' => $id, 'pret' => false, 'dateDeMiseAEau' => null, 'emplacement' => null));
        $lanternes = $em->getRepository('SSFMBBundle:StocksLanternes')->createQueryBuilder('SLanterne')
            ->select('Article.libArticle')
            ->addSelect('SLanterne.numeroSerie')
            ->addSelect('SLanterne')
            ->leftJoin('SLanterne.lanterne', 'Lant')
            ->leftJoin('SLanterne.article', 'stoSN')
            ->leftJoin('stoSN.refStockArticle', 'SA')
            ->leftJoin('SA.refArticle', 'Article')
            ->where("Lant.nomLanterne = '$id'")
            ->andWhere('SLanterne.pret = false')
            ->andWhere('SLanterne.dateDeMiseAEau IS NULL')
            ->andWhere('SLanterne.emplacement IS NULL')
            ->getQuery()->getResult();

        $date = array();
        foreach ($lanternes as $lanterne) {
            if (!isset($date[$lanterne['libArticle']][$lanterne['numeroSerie']][$implementation->calculerQuantiterLanterne($lanterne[0])])) {
                $date[$lanterne['libArticle']][$lanterne['numeroSerie']][$implementation->calculerQuantiterLanterne($lanterne[0])] = 0;
            }
            $date[$lanterne['libArticle']][$lanterne['numeroSerie']][$implementation->calculerQuantiterLanterne($lanterne[0])] = $date[$lanterne['libArticle']][$lanterne['numeroSerie']][$implementation->calculerQuantiterLanterne($lanterne[0])] + 1;
        }
        return new JsonResponse($date);
    }

    /**
     * Lists all StocksLanternes entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SSFMBBundle:StocksLanternes')->findAll();

        return $this->render('SSFMBBundle:StocksLanternes:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new StocksLanternes entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new StocksLanternes();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('stockslanternes_show', array('id' => $entity->getId())));
        }

        return $this->render('SSFMBBundle:StocksLanternes:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a StocksLanternes entity.
     *
     * @param StocksLanternes $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(StocksLanternes $entity)
    {
        $form = $this->createForm(new StocksLanternesType(), $entity, array(
            'action' => $this->generateUrl('stockslanternes_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new StocksLanternes entity.
     *
     */
    public function newAction()
    {
        $entity = new StocksLanternes();
        $form = $this->createCreateForm($entity);

        return $this->render('SSFMBBundle:StocksLanternes:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a StocksLanternes entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SSFMBBundle:StocksLanternes')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find StocksLanternes entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SSFMBBundle:StocksLanternes:show.html.twig', array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing StocksLanternes entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SSFMBBundle:StocksLanternes')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find StocksLanternes entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SSFMBBundle:StocksLanternes:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a StocksLanternes entity.
     *
     * @param StocksLanternes $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(StocksLanternes $entity)
    {
        $form = $this->createForm(new StocksLanternesType(), $entity, array(
            'action' => $this->generateUrl('stockslanternes_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing StocksLanternes entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SSFMBBundle:StocksLanternes')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find StocksLanternes entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('stockslanternes_edit', array('id' => $id)));
        }

        return $this->render('SSFMBBundle:StocksLanternes:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a StocksLanternes entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SSFMBBundle:StocksLanternes')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find StocksLanternes entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('stockslanternes'));
    }

    /**
     * Creates a form to delete a StocksLanternes entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('stockslanternes_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }
}
