<?php

namespace ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * @Route("/foro/")
 */
class ComentarioController extends Controller
{
     /**
     * displays all comentarios entity of a curso .
     *
     * @Route("/{curso_id}/foro",name="listar_comentarios_foro")
     * @ParamConverter("curso", class="CursoBundle:Entity:Curso", options={"id"="curso_id"})
     */
    public function listarAction($curso){
        $repository = $this->getDoctrine()->getRepository('ForumBundle:Comentario');
        $comentarios = $repository->createQueryBuilder('c')
            ->where('c.curso = :curso') 
            ->setParameter('curso',$curso)
            ->getQuery()
            ->getResult();
        return $this->render('ForumBundle:listar',['curso'=>$curso, 'comentario'=>$comentarios]);   
    }
}