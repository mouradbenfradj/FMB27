<?php
namespace SS\FMBBundle\Controller\Menu\Suivi;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SuiviController extends Controller
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if ($request->get('idparc') == null) {
            $processus = null;
            $parc = null;
        }
        else
        {
            $processus = $em->getRepository('SSFMBBundle:Processus')->findAll();
            $parc = $em->getRepository('SSFMBBundle:Magasins')->findOneByIdMagasin($request->get('idparc'));
        }
        return $this->render('SSFMBBundle:Default:suivit.html.twig', array('entity' => $parc, 'processus'=>$processus));
    }

}