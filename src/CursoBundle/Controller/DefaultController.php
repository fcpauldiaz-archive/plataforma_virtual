<?php

namespace CursoBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        return $this->render('default/index.html.twig');
    }

     /**
     * @Route("/perfil", name="perfil")
     */
    public function lolAction()
    {
        return $this->render('base_page.html.twig');
    }

   
}
