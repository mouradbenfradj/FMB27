<?php

namespace SS\FMBBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SS\FMBBundle\Entity\Articles;
use SS\FMBBundle\Form\ArticlesType;
use Symfony\Component\HttpFoundation\Response;

/**
 * Articles controller.
 *
 */
class ArticlesController extends Controller
{
    public function articleCycleAction(Request $request)
    {// Get the province ID
        $sarticle = $request->query->get('sarticle');
        $article = $this->getDoctrine()->getManager()->getRepository('SSFMBBundle:Articles');
        $result = array();
        $repo = $this->getDoctrine()->getManager()->getRepository('SSFMBBundle:Processus')->findByArticleDebut($article->findOneByLibArticle($sarticle));
        foreach ($repo as $stock) {
            $result[$stock->getId()] = $stock->getNomProcessus();
        }
        return new JsonResponse($result);
    }

    public function articleStocksAction(Request $request)
    {// Get the province ID
        $id = $request->query->get('stock_id');
        $article = $request->query->get('article');
        $result = array();
        $repo = $this->getDoctrine()->getManager()->getRepository('SSFMBBundle:StocksArticles');
        if ($article != '')
            $stocks = $repo->findBy(array('idStock' => $id, 'refArticle' => $article));

        foreach ($stocks as $stock) {
            $sn = $this->getDoctrine()->getManager()->getRepository('SSFMBBundle:StocksArticlesSn')->findByRefStockArticle($stock);
            foreach ($sn as $lot) {
                $result[$lot->getNumeroSerie()] = $lot->getSnQte();
            }
        }
        return new JsonResponse($result);
    }

    public function pocheArticleAction(Request $request)
    {
        $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $pochearticle = $em->getRepository('SSFMBBundle:StocksPochesBS')->getPochePreparer(
            $em->getRepository('SSFMBBundle:StocksArticlesSn')->findOneBy(array('refStockArticle' => $request->get('ida'), 'numeroSerie' => $request->get('lot'))), $request->get('idl')
        );
        count($pochearticle);
        $tabEnsembles = array();
        $tabtest = array();
        $i = 0;
        foreach ($pochearticle as $e) { // transformer la réponse de la requete en tableau qui remplira le select pour ensembles
            if (!in_array($e->getQuantiter(), $tabtest)) {
                $tabEnsembles[$i]['id'] = $e->getId();
                $tabEnsembles[$i]['nombre'] = count($pochearticle);
                $tabEnsembles[$i]['qte'] = $e->getQuantiter();
                $tabtest[] = $e->getQuantiter();
            }
            $i++;
        }
        $response = new Response();
        $data = json_encode($tabEnsembles); // formater le résultat de la requête en json
        $response->headers->set('Content-Type', 'miseaeaupoche/json');
        $response->setContent($data);

        return $response;
    }


    public function articleStockslotAction(Request $request)
    {// Get the province ID
        $id = $request->query->get('stock_id');
        $article = $request->query->get('article');
        $lot = $request->query->get('lot');
        $result = array();
        $repo = $this->getDoctrine()->getManager()->getRepository('SSFMBBundle:StocksArticles');
        $stocks = $repo->findBy(array('idStock' => $id, 'refArticle' => $article));

        foreach ($stocks as $stock) {
            $sn = $this->getDoctrine()->getManager()->getRepository('SSFMBBundle:StocksArticlesSn')->findBy(array('refStockArticle' => $stock, 'numeroSerie' => $lot));
            foreach ($sn as $lot) {
                $result[$lot->getNumeroSerie() . $lot->getSnQte()] = $lot->getSnQte();
            }
        }
        return new JsonResponse($result);
    }

    public function nombrePocheArticleAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $pochearticle = $em->getRepository('SSFMBBundle:StocksPochesBS')->getPochePreparer(
            $em->getRepository('SSFMBBundle:StocksArticlesSn')->findOneBy(array('refStockArticle' => $request->get('ida'), 'numeroSerie' => $request->get('lot')))
            , $request->get('idl')
        );
        count($pochearticle);
        $tabEnsembles = array();
        $tabtest = array();
        $i = 0;
        $tt = 1;
        foreach ($pochearticle as $e) { // transformer la réponse de la requete en tableau qui remplira le select pour ensembles
            if ($e->getQuantiter() == $request->get('qtech')) {
                $tabEnsembles[$i]['id'] = $e->getId();
                $tabEnsembles[$i]['nombre'] = $tt;
                $tabEnsembles[$i]['qte'] = $e->getQuantiter();
                $tabtest[] = $e->getQuantiter();
                $tt++;
            }
            $i++;
        }
        $response = new Response();
        $data = json_encode($tabEnsembles); // formater le résultat de la requête en json
        $response->headers->set('Content-Type', 'miseaeaupoche/json');
        $response->setContent($data);

        return $response;
    }

    /**
     * Lists all Articles entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SSFMBBundle:Articles')->findAll();

        return $this->render(
            'SSFMBBundle:Articles:index.html.twig',
            array(
                'entities' => $entities,
            )
        );
    }

    /**
     * Creates a new Articles entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Articles();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('articles_show', array('id' => $entity->getRefArticle())));
        }

        return $this->render(
            'SSFMBBundle:Articles:new.html.twig',
            array(
                'entity' => $entity,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Creates a form to create a Articles entity.
     *
     * @param Articles $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Articles $entity)
    {
        $form = $this->createForm(
            new ArticlesType(),
            $entity,
            array(
                'action' => $this->generateUrl('articles_create'),
                'method' => 'POST',
            )
        );

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Articles entity.
     *
     */
    public function newAction()
    {
        $entity = new Articles();
        $form = $this->createCreateForm($entity);

        return $this->render(
            'SSFMBBundle:Articles:new.html.twig',
            array(
                'entity' => $entity,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Finds and displays a Articles entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SSFMBBundle:Articles')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Articles entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render(
            'SSFMBBundle:Articles:show.html.twig',
            array(
                'entity' => $entity,
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Creates a form to delete a Articles entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('articles_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }

    /**
     * Displays a form to edit an existing Articles entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SSFMBBundle:Articles')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Articles entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render(
            'SSFMBBundle:Articles:edit.html.twig',
            array(
                'entity' => $entity,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Creates a form to edit a Articles entity.
     *
     * @param Articles $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Articles $entity)
    {
        $form = $this->createForm(
            new ArticlesType(),
            $entity,
            array(
                'action' => $this->generateUrl('articles_update', array('id' => $entity->getRefArticle())),
                'method' => 'PUT',
            )
        );

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Articles entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SSFMBBundle:Articles')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Articles entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('articles_edit', array('id' => $id)));
        }

        return $this->render(
            'SSFMBBundle:Articles:edit.html.twig',
            array(
                'entity' => $entity,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Deletes a Articles entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SSFMBBundle:Articles')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Articles entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('articles'));
    }
}
