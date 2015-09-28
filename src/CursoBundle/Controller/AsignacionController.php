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

/**
 * AsignacionController
 */
class AsignacionController extends Controller
{
    /**
     * Método para mostrar los cursos no asignados  de un usuario
     * 
     * @Route("/{username}/asignar/cursos/", name="asignacion")
     * @ParamConverter("usuario", class="UserBundle:Usuario", options={"username"="username"})
     * @Template("CursoBundle:Asignacion:asignarAsignacion.html.twig")
     */
    public function asignarAction(Request $request, Usuario $usuario)
    {
        $form = $this->createForm(new BuscarType());

        $em = $this->getDoctrine()->getManager();
        $cursos = $em->getRepository('CursoBundle:Curso')->findAll();

        $cursosAsignados = $usuario->getCursos();

        $returnData = $this->mostrarCursosAsignados($cursos,$cursosAsignados);
        $error = 0;

		return  
        [
            'cursos' => $returnData,
            'query' => [],
            'error' => $error,
            'buscarCurso' => $form->createView()
        ];

    }
    /**
     * Método que verifica que solo los cursos no asignados de un usuario
     * @param  [Array] $cursos          [Recibe todos los cursos disponibles]
     * @param  [Array] $cursosAsignados [Recibe los cursos asignados]
     * @return [Array]                  [Devuelve los cursos no asignados]
     */
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
     * Método para buscar un curso específico
     * @Route("/{username}/search/cursos/", name="asignacion_search")
     * @ParamConverter("usuario", class="UserBundle:Usuario", options={"username"="username"})
     * 
     */
    public function searchQueryAction(Request $request, Usuario $usuario)
    {
        
        $em = $this->getDoctrine()->getManager();
        //se obtienen todos los cursos
        $cursos = $em->getRepository('CursoBundle:Curso')->findAll();
        //se obtienen los cursos asignados 
        $cursosAsignados = $usuario->getCursos();
        //instancia del buscador
        $finder = $this->get('fos_elastica.finder.bookmarks.site');
        //término de búsqueda
        $searchTerm = $request->query->get('search');
        //query representa los cursos asignados (array)
        $query = $finder->find($searchTerm);
        $err = 0;

        //se verifica que el término de búsqueda no haya dado error
        //y que se haya encontrado algún curso
        //en otro caso se toma como error
        if ($searchTerm == ''|| $query == null){
            $err = 1;
        }

       return $this->render('CursoBundle:Asignacion:asignarAsignacion.html.twig',
            array(
                'username' => $usuario->getUsername(),
                'query' => $query,
                'cursos'=>$this->mostrarCursosAsignados($cursos,$cursosAsignados), 
                'error' =>$err,
                
                ));
      
    }

    /**
     * Método para agregar un curso a un usuario de forma lógica (base de datos)
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
        return $this->render('CursoBundle:Asignacion:listarAsignacion.html.twig', array('cursosAsignados' => $usuario->getCursos()));
    }

    /**
     * [Método para desasignar cursos ]
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
