<?php

namespace DocumentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Documento controller.
 *
 * @Route("/download")
 */
class DownloadController extends Controller
{
    /**
     * [showCursosParcialesAction Mostrar los cursos para descargar parciales].
     *
     * @return [Array] [cursos asignados]
     * @Route("/cursos/parciales",name="cursos_parciales")
     * @Method("GET")
     * @Template("DocumentBundle:Documento:downloadDocumento.html.twig")
     */
    public function showCursosParcialesAction()
    {
        $em = $this->getDoctrine()->getManager();
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        $usuario = $this->getUser();

        $cursos = $usuario->getCursos();

        return [

        'cursos' => $cursos,'documento' => 1,

        ];
    }

    /**
     * [showCursosHDTAction Mostrar los cursos para descargar hojas de trabajo].
     *
     * @return [Array] [cursos asignados]
     * @Route("/cursos/hojasdetrabajo",name="cursos_hdt")
     * @Method("GET")
     * @Template("DocumentBundle:Documento:downloadDocumento.html.twig")
     */
    public function showCursosHDTAction()
    {
        $em = $this->getDoctrine()->getManager();

        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $usuario = $this->getUser();

        $cursos = $usuario->getCursos();

        return ['cursos' => $cursos,'documento' => 0];
    }

    /**
     * Listar todos los cursos asignados.
     *
     * @Route("/hojadetrabajo/", name="hdt_download")
     * @Method("GET")
     * @Template("DocumentBundle:Documento:downloadDocumento.html.twig")
     */
    public function showCursosAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('DocumentBundle:Documento')->findAll();

        return [
            'entities' => $entities,
        ];
    }

    /**
     * Finds and displays a Curso entity.
     *
     * @Route("/{slug}/{tipo}/", name="show_curso")
     * @Method("GET")
     * @Template("DocumentBundle:Documento:cursoShow.html.twig")
     * @ParamConverter("curso", class="CursoBundle:Curso",options={"slug" = "slug"})
     */
    public function showAction($curso, $tipo)
    {
        if (!$curso) {
            throw $this->createNotFoundException('Unable to find Curso entity.');
        }

        return [
            'curso' => $curso,
            'tipo' => $tipo,

        ];
    }
}
