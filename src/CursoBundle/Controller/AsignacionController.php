<?php
namespace CursoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use CursoBundle\Entity\Curso;
use UserBundle\Entity\Usuario;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections;
use CursoBundle\Form\BuscarType;


class AsignacionController extends Controller
{
    /**
     * Don't forget to add this route annotation!
     *
     * @Route("/{username}/asignar/cursos/", name="asignacion")
     * @ParamConverter("usuario", class="UserBundle:Usuario", options={"username"="username"})
     * 
     */
    public function asignarAction(Request $request, Usuario $usuario)
    {
        $form = $this->createForm(new BuscarType());

        $em = $this->getDoctrine()->getManager();
        $cursos = $em->getRepository('CursoBundle:Curso')->findAll();

        $cursosAsignados = $usuario->getCursos();

       
        $returnData = $this->mostrarCursosAsignados($cursos,$cursosAsignados);
        $error = 0;

		return $this->render('CursoBundle:Asignacion:asignar.html.twig', 
        array(
            'cursos' => $returnData,
            'query' => [],
            'error' => $error,
            'buscarCurso' => $form->createView()
            ));
    }

    public function mostrarCursosAsignados($cursos,$cursosAsignados)
    {
        $returnData = [];
        foreach($cursos as $curso){       
            if (!$cursosAsignados->contains($curso)) {
                $returnData[] = $curso;
            }
        } 
        return $returnData;
    }

    /**
     * @Route("/{username}/search/cursos/", name="asignacion_search")
     * @ParamConverter("usuario", class="UserBundle:Usuario", options={"username"="username"})
     * 
     */
    public function searchQueryAction(Request $request, Usuario $usuario)
    {
         $em = $this->getDoctrine()->getManager();
        $cursos = $em->getRepository('CursoBundle:Curso')->findAll();
        $cursosAsignados = $usuario->getCursos();
        $finder = $this->get('fos_elastica.finder.bookmarks.site');
        $searchTerm = $request->query->get('search');
        $query = $finder->find($searchTerm);
        $err = 0;
        if ($searchTerm == ''|| $query == null){
            $err = 1;
        }
       return $this->render('CursoBundle:Asignacion:asignar.html.twig',
            array(
                'username' => $usuario->getUsername(),
                'query' => $query,
                'cursos'=>$this->mostrarCursosAsignados($cursos,$cursosAsignados), 
                'error' =>$err,
                
                ));
      
    }

    /**
     * Método para asingar un curso a un usuario
     *
     * @Route("/agregar/curso/{usuario_id}/{curso_id}/", name="add_asignacion")
     * @ParamConverter("usuario", class="UserBundle:Usuario", options={"id"="usuario_id"})
     * @ParamConverter("curso", class="CursoBundle:Curso", options={"id"="curso_id"})
     */
    public function agregarCursoAction(Curso $curso, Usuario $usuario) {
    	$em = $this->getDoctrine()->getManager();
    	$cursos = $em->getRepository('CursoBundle:Curso')->findAll();
    	$usuario->addCurso($curso);
        $em->persist($usuario);
        $em->flush();

        $cursosAsignados = $usuario->getCursos();

        return $this->redirect($this->generateUrl('listar_cursos', array('username' => $usuario->getUsername())));
        
		
    }
     /**
     * Listar cursos asignados
     *
     * @Route("/{username}/listar/cursos", name="listar_cursos")
     * @ParamConverter("usuario", class="UserBundle:Usuario", options={"username"="username"})
     * 
     */
    public function listarAction(Usuario $usuario)
    {
        $em = $this->getDoctrine()->getManager();
        return $this->render('CursoBundle:Asignacion:listar.html.twig', array('cursosAsignados' => $usuario->getCursos()));
    }

    /**
     * [removeCursoAction description]
     * Método para remover curso asignado al usuario
     * @Route("/quitar/curso/{curso_id}/{username}/",name="remove_curso")
     * @ParamConverter()
     * @ParamConverter("usuario", class="UserBundle:Usuario", options={"username"="username"})
     * @ParamConverter("curso", class="CursoBundle:Curso", options={"id"="curso_id"})
     *      */
    public function removeCursoAction(Curso $curso, Usuario $usuario)
    {
        $em = $this->getDoctrine()->getManager();
        $usuario->removeCurso($curso);
        $em->persist($usuario);
        $em->flush();
        return $this->redirect($this->generateUrl('listar_cursos', array('username' => $usuario->getUsername())));
        
    }
}
