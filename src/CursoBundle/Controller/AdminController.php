<?php

namespace CursoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;

class AdminController extends BaseAdminController
{
    /**
     * Don't forget to add this route annotation!
     *
     * @Route("/easyadmin/", name="admin")
     */
    public function indexAction(Request $request)
    {

        // don't forget to add this line to serve the regular backend pages
        return parent::indexAction($request);
    }

    // ...
}
