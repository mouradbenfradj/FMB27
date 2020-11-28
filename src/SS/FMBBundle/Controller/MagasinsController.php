<?php

namespace SS\FMBBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SS\FMBBundle\Entity\Magasins;
use SS\FMBBundle\Form\MagasinsType;

/**
 * Magasins controller.
 *
 */
class MagasinsController extends Controller
{
    public function parcStocksAction(Request $request)
    {
        $result = array();
        $repo = $this->getDoctrine()->getManager()->getRepository('SSFMBBundle:Magasins');
        $parc = $repo->find($request->query->get('parc_id'));
        $stocks = $parc->getIdStock();
        $result[$stocks->getLibStock()] = $stocks->getIdStock();
        return new JsonResponse($result);
    }

    public function parcLanternesAction(Request $request)
    {// Get the province ID
        $id = $request->query->get('parc_id');
        $result = array();
        // Return a list of cities, based on the selected province
        $repo = $this->getDoctrine()->getManager()->getRepository('SSFMBBundle:Lanterne');
        $lanternes = $repo->findByParc($id, array('parc' => 'asc'));
        foreach ($lanternes as $lanterne) {
            $result[$lanterne->getNomLanterne()]['nomLanterne'] = $lanterne->getNomLanterne();
            $result[$lanterne->getNomLanterne()]['nombreEnStocks'] = $lanterne->getNbrTotaleEnStock();
        }
        return new JsonResponse($result);
    }

    public function parcCordesAction(Request $request)
    {// Get the province ID
        $id = $request->query->get('parc_id');
        $result = array();
        // Return a list of cities, based on the selected province
        $repo = $this->getDoctrine()->getManager()->getRepository('SSFMBBundle:Corde');
        $cordes = $repo->findByParc($id, array('parc' => 'asc'));
        foreach ($cordes as $corde) {
            $result[$corde->getNomCorde()]['nomCorde'] = $corde->getNomCorde();
            $result[$corde->getNomCorde()]['nombreEnStocks'] = $corde->getNbrTotaleEnStock();
        }
        return new JsonResponse($result);
    }


    public function parcCordeAction(Request $request)
    {// Get the province ID
        $id = $request->query->get('parc_id');
        $result = array();
        $repo = $this->getDoctrine()->getManager()->getRepository('SSFMBBundle:Corde');
        $cordes = $repo->findByParc($id, array('parc' => 'asc'));
        foreach ($cordes as $corde) {
            $result[$corde->getId()]['nomCorde'] = $corde->getNomCorde();
            $result[$corde->getId()]['nombre'] = $corde->getNbrTotaleEnStock();
        }
        return new JsonResponse($result);
    }

    public function quantiterCordeEnStockAction(Request $request)
    {// Get the province ID
        $id = $request->query->get('cordeId');
        $result = array();
        // Return a list of cities, based on the selected province
        $repo = $this->getDoctrine()->getManager()->getRepository('SSFMBBundle:Corde');
        $corde = $repo->find($id);
        $result[$corde->getId() . $corde->getNomCorde()] = $corde->getNbrTotaleEnStock();

        return new JsonResponse($result);
    }

    public function parcPochesAction(Request $request)
    {// Get the province ID
        $id = $request->query->get('parc_id');
        $result = array();
        // Return a list of cities, based on the selected province
        $repo = $this->getDoctrine()->getManager()->getRepository('SSFMBBundle:PochesBS');
        $poches = $repo->findByParc($id, array('parc' => 'asc'));
        foreach ($poches as $poche) {
            $result[$poche->getId()] = $poche->getNomPoche();
            $result[$poche->getId() . $poche->getNbrTotaleEnStock()] = $poche->getNbrTotaleEnStock();
        }
        return new JsonResponse($result);
    }

    public function parcPocheAction(Request $request)
    {// Get the province ID
        $id = $request->query->get('parc_id');
        $result = array();
        // Return a list of cities, based on the selected province
        $repo = $this->getDoctrine()->getManager()->getRepository('SSFMBBundle:PochesBS');
        $poches = $repo->findByParc($id, array('parc' => 'asc'));
        foreach ($poches as $poche) {
            $result[$poche->getId()]['poche'] = $poche->getNomPoche();
            $result[$poche->getId()]['quantiter'] = $poche->getNbrTotaleEnStock();
        }
        return new JsonResponse($result);
    }

    /**
     * Lists all Magasins entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SSFMBBundle:Magasins')->findAll();

        return $this->render('SSFMBBundle:Magasins:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new Magasins entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Magasins();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('magasins_show', array('id' => $entity->getId())));
        }

        return $this->render('SSFMBBundle:Magasins:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Magasins entity.
     *
     * @param Magasins $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Magasins $entity)
    {
        $form = $this->createForm(new MagasinsType(), $entity, array(
            'action' => $this->generateUrl('magasins_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Magasins entity.
     *
     */
    public function newAction()
    {
        $entity = new Magasins();
        $form = $this->createCreateForm($entity);

        return $this->render('SSFMBBundle:Magasins:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Magasins entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SSFMBBundle:Magasins')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Magasins entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SSFMBBundle:Magasins:show.html.twig', array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Magasins entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SSFMBBundle:Magasins')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Magasins entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SSFMBBundle:Magasins:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Magasins entity.
     *
     * @param Magasins $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Magasins $entity)
    {
        $form = $this->createForm(new MagasinsType(), $entity, array(
            'action' => $this->generateUrl('magasins_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Magasins entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SSFMBBundle:Magasins')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Magasins entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('magasins_edit', array('id' => $id)));
        }

        return $this->render('SSFMBBundle:Magasins:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Magasins entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SSFMBBundle:Magasins')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Magasins entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('magasins'));
    }

    /**
     * Creates a form to delete a Magasins entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('magasins_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }
}
