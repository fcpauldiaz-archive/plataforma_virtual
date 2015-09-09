<?php

namespace DocumentBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use UserBundle\Entity\Usuario as Usuario;

/**
 * Documento controller.
 *
 * @Route("/download")
 */
class DownloadController extends Controller
{

    /**
     * Listar todos los cursos asignados
     *
     * @Route("/hojadetrabajo/", name="hdt_download")
     * @Method("GET")
     * @Template("DocumentBundle:Documento:indexParciales.html.twig")
     * 
     */
    public function showCursosHDTAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('DocumentBundle:Documento')->findAll();

        return array(
            'entities' => $entities,
        );
    }
   

   

}
