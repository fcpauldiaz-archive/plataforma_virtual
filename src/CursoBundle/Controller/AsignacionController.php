<?php

namespace CursoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CursoBundle\Entity\Curso;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use CursoBundle\Form\BuscarType;
use FOS\UserBundle\Model\UserInterface;

/**
 * AsignacionController.
 *
 * @author  Pablo Díaz fcpauldiaz@me.com
 */
class AsignacionController extends Controller
{
    /**
     * Método para mostrar los cursos no asignados  de un usuario.
     * 
     * @Route("/asignar/cursos/", name="asignacion")
     * @Template("CursoBundle:Asignacion:crearAsignacion.html.twig")
     */
    public function asignarAction(Request $request)
    {
        $usuario = $this->get('security.token_storage')->getToken()->getUser();
        if (!is_object($usuario) || !$usuario instanceof UserInterface) {
            throw new AccessDeniedException('El usuario no tiene acceso.');
        }

        $form = $this->createForm(new BuscarType());

        
        $cursosAsignados = $usuario->getCursos();

        $repositoryCurso = $this->getDoctrine()->getRepository('CursoBundle:Curso');
        $cursosOrdenados = $repositoryCurso->createQueryBuilder('curso')
            ->select('curso')
            ->orderBy('curso.nombreCurso', 'ASC')
            ->getQuery()
            ->getResult();

        $returnData = $this->mostrarCursosAsignadosAction($cursosOrdenados, $cursosAsignados);
        $error = 0;

        return
        [
            'cursos' => $returnData,
            'query' => [],
            'error' => $error,
            'buscarCurso' => $form->createView(),
        ];
    }
    /**
     * Método que verifica que solo los cursos no asignados de un usuario.
     *
     * @param [Array] $cursos          [Recibe todos los cursos disponibles]
     * @param [Array] $cursosAsignados [Recibe los cursos asignados]
     *
     * @return [Array] [Devuelve los cursos no asignados]
     */
    public function mostrarCursosAsignadosAction($cursos, $cursosAsignados)
    {
        $returnData = [];
        foreach ($cursos as $curso) {
            if (!$cursosAsignados->contains($curso)) {
                $returnData[] = $curso;
            }
        }

        return $returnData;
    }

    /**
     * Método para buscar un curso específico.
     *
     * @Route("/search/cursos/", name="asignacion_search")
     */
    public function searchQueryAction(Request $request)
    {
        $usuario = $this->get('security.token_storage')->getToken()->getUser();
        if (!is_object($usuario) || !$usuario instanceof UserInterface) {
            throw new AccessDeniedException('El usuario no tiene acceso.');
        }
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
        if ($searchTerm === '' || $query === null) {
            $err = 1;
        }

        return $this->render('CursoBundle:Asignacion:asignarAsignacion.html.twig',
            [
                'username' => $usuario->getUsername(),
                'query' => $query,
                'cursos' => $this->mostrarCursosAsignados($cursos, $cursosAsignados),
                'error' => $err,

            ]);
    }

    /**
     * Método para agregar un curso a un usuario de forma lógica (base de datos).
     *
     * @Route("/agregar/curso/{curso_id}/", name="add_asignacion")
     * @ParamConverter("curso", class="CursoBundle:Curso", options={"id"="curso_id"})
     */
    public function agregarCursoAction(Curso $curso)
    {
        $usuario = $this->get('security.token_storage')->getToken()->getUser();
        if (!is_object($usuario) || !$usuario instanceof UserInterface) {
            throw new AccessDeniedException('El usuario no tiene acceso.');
        }
        $em = $this->getDoctrine()->getManager();
       
        $usuario->addCurso($curso);
        $em->persist($usuario);
        $em->flush();

        

        $this->get('braincrafted_bootstrap.flash')->success(sprintf('Curso %s asignado correctamente', $curso->getNombreCurso()));

        return $this->redirect(
            $this->generateUrl(
                'listar_cursos',
                ['username' => $usuario->getUsername()]
            )
        );
    }

    /**
     * @Route("/agregar/curso_nuevo", name="asignar_curso_nuevo")
     */
    public function asignarCursoAction(Request $request)
    {
        $usuario = $this->get('security.token_storage')->getToken()->getUser();
        if (!is_object($usuario) || !$usuario instanceof UserInterface) {
            throw new AccessDeniedException('El usuario no tiene acceso.');
        }
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(
            new BuscarType());

        $form->handleRequest($request);

        $cursos = $usuario->getCursos();

        $data = $form->getData();
        $curso = $data['curso'];

        if (!$cursos->contains($curso)) {
            $usuario->addCurso($curso);
            $em->persist($usuario);
            $em->flush();

            $this->get('braincrafted_bootstrap.flash')->success(sprintf('Curso %s asignado correctamente', $curso->getNombreCurso()));

            return $this->redirect($this->generateUrl('listar_cursos', ['username' => $usuario->getUsername()]));
        }

        $this->get('braincrafted_bootstrap.flash')->alert(sprintf('Curso %s ya estaba asignado', $curso->getNombreCurso()));

        return $this->redirect(
            $this->generateUrl(
                'listar_cursos', ['username' => $usuario->getUsername()]
            )
        );
    }

    /**
     * Listar cursos asignados.
     *
     * @Route("/listar/cursos", name="listar_cursos")
     */
    public function listarAction()
    {
        $usuario = $this->get('security.token_storage')->getToken()->getUser();
        if (!is_object($usuario) || !$usuario instanceof UserInterface) {
            throw new AccessDeniedException('El usuario no tiene acceso.');
        }
        

        return $this->render(
            'CursoBundle:Asignacion:listarAsignacion.html.twig',
            ['cursosAsignados' => $usuario->getCursos()]
        );
    }

    /**
     * [Método para desasignar cursos ]
     * Método para remover curso asignado al usuario.
     *
     * @Route("/quitar/curso/{curso_id}/",name="remove_curso")
     * @ParamConverter()
     * @ParamConverter("curso", class="CursoBundle:Curso", options={"id"="curso_id"})
     *      */
    public function removeCursoAction(Curso $curso)
    {
        $usuario = $this->get('security.token_storage')->getToken()->getUser();
        if (!is_object($usuario) || !$usuario instanceof UserInterface) {
            throw new AccessDeniedException('El usuario no tiene acceso.');
        }
        $em = $this->getDoctrine()->getManager();
        $usuario->removeCurso($curso);
        $em->persist($usuario);
        $em->flush();

        return $this->redirect(
            $this->generateUrl(
                'listar_cursos',
                ['username' => $usuario->getUsername()]
            )
        );
    }
}
