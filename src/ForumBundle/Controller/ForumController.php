<?php

namespace ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use CursoBundle\Entity\Curso as Curso;

/**
 * @Route("/foro")
 */
class ForumController extends Controller
{
    /**
     * @Route("/cursos",name="list_cursos_foro")
     * @Method("GET")
     * @Template("ForumBundle:Foro:listarCursosForo.html.twig")
     */
    public function listarCursosForoAction()
    {
        $em = $this->getDoctrine()->getManager();
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        $usuario = $this->getUser();

        $cursos = $usuario->getCursos();

        return [

        'cursos' => $cursos,

        ];
    }
    /**
     * @Route("/{slug}",name="curso_foro") 
     * @ParamConverter("curso", class="CursoBundle:Curso", options={"slug"="slug"})
     * @Template("ForumBundle:Foro:cursoForo.html.twig")
     *
     * @return [type] [description]
     */
    public function cursoForoAction(Curso $curso)
    {
        return ['curso' => $curso];
    }
}
