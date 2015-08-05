<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use UserBundle\Entity\Usuario;
use UserBundle\Form\CursoType;

/**
 * usuario controller.
 *
 * @Route("/usuario")
 */
class UsuarioController extends Controller
{

    /**
     * adds a Curso to a usuario entity.
     *
     * @Route("/{usuario_id}/{curso_id}", name="curso_Add")
     * @Method("ADD")
     */
    public function addAction(Request $request, $id, $id2)
    {
        $form = $this->createAddForm($id,$id2);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Usuario')->find($id2);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Curso entity.');
            }

            $id->addCurso($id2)

            $em = $this->getDoctrine()->getManager();
            $em->persist($id);
            $em->flush();

        }

        return $this->redirect($this->generateUrl('curso'));
    }

    /**
     * Creates a form to ADD a Curso to a usuario entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createAddForm($id,$id2)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('curso_new', array('id' => $id,'id2'=>$id2)))
            ->setMethod("ADD")
            ->add('submit', 'submit', array('label' => 'Add'))
            ->getForm()
        ;
    }
}
