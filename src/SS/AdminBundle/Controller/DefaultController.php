<?php

namespace SS\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('SSAdminBundle:Default:index.html.twig', array('name' => $name));
    }
}
