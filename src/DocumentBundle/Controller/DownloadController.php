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
     * @Route("/{username}/", name="parcial_download")
     * @Method("GET")
     * @Template("DocumentBundle:Documento:download_parcial.html.twig")
     * @ParamConverter("usuario", class="UserBundle:Usuario", options={"username"="username"})
     */
    public function showCursosParcialAction(Usuario $usuario)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('DocumentBundle:Documento')->findAll();

        $cursos = $usuario->getCursos();
        return array(
            'cursos' => $cursos,
            'entities'=>$entities,
        );
    }
   

   

}
