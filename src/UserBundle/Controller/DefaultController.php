<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Curso;
use UserBundle\Form\Type\CursoType;
/**
 * @Route("")
 */
class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('UserBundle:Default:index.html.twig');
    }


    /**
     * Mostrar cursos asignados
     *
     * @Route("/{id_usuario}/cursos", name="show_cursos")
     * @Method("GET")
     * @Template()
     */
    public function getCursosAction($id_usuario)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('UserBundle:Usuario')->find($id_usuario);

        return array(
            'entities' => $entities->getCursos(),
        );
    }
    /**
     * adds a Curso entity to Usuario.
     *
     * @Route("/usuario/{idUsuario}/edit", name="add_curso")
     * @Method("GET")
     * @Template()
     */
    public function assingCursoAction($idUsuario)
    {
    	$em = $this->getDoctrine()->getManager();

        $entityUsuario = $em->getRepository('UserBundle:Usuario')->find($idUsuario);
		
		
       
       	if (!$entityUsuario) {
            throw $this->createNotFoundException('Unable to find Curso entity.');
        }

        $form = $this->createAssignForm($entityUsuario);
         return array(
            'entity' => $entityUsuario,
            'form'   => $form->createView(),
        );
        /*$entityCurso = $em->getRepository('AppBundle:Curso')->find($idCurso);
        $entityUsuario = $em->getRepository('UserBundle:Usuario')->find($idUsuario);


        if (!$entityCurso or !$entityUsuario) {
            throw $this->createNotFoundException('Unable to find Curso or Usuario entity.');
        }

            $entityUsuario->addCurso($entityCurso);
            $em->persist($entityUsuario);
            $em->flush();

            return $this->redirect($this->generateUrl('curso_show', array('id' => $entityUsuario1->getId())));
        */

    }

    
     
    public function createAssignForm(Usuario $entity)
    {
       
        $form = $this->createForm(new CursoType(), $entity, array(
            'action' => $this->generateUrl('usuario_add'),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }
}
