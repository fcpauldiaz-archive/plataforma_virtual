<?php

namespace CursoBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * Default Index page.
     * 
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        return $this->render('default/index.html.twig');
    }
    /**
     * [adminAction description].
     *
     * @return [type] [description]
     * @ROUTE("/admin", name = "administration")
     */
    public function adminAction()
    {
        return $this->render('admin/indexAdmin.html.twig');
    }
}
