<?php

namespace CursoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CursoBundle\Entity\Curso;
use CursoBundle\Form\CursoType;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


/**
 * Curso controller.
 *
 * @Route("admin/curso")
 * 
 */
class CursoController extends Controller
{

    /**
     * Lists all Curso entities.
     *
     * @Route("/", name="curso")
     * @Method("GET")
     * @Template("CursoBundle:Curso:indexCurso.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CursoBundle:Curso')->findAll();

        return [
            'entities' => $entities,
        ];
    }
    /**
     * Creates a new Curso entity.
     *
     * @Route("/", name="curso_create")
     * @Method("POST")
     * @Template("CursoBundle:Curso:newCurso.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Curso();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

       
       
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect(
                $this->generateUrl(
                    'curso_show', ['id' => $entity->getId()]
                )
            );
        }
        
        return [
            'entity' => $entity,
            'form'   => $form->createView(),
        ];
    }

    /**
     * Creates a form to create a Curso entity.
     *
     * @param Curso $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Curso $entity)
    {
        $form = $this->createForm(new CursoType(), $entity, [
            'action' => $this->generateUrl('curso_create'),
            'method' => 'POST',
        ]);

        $form->add('submit', 'submit', ['label' => 'Create']);

        return $form;
    }

    /**
     * Displays a form to create a new Curso entity.
     *
     * @Route("/new", name="curso_new")
     * @Method("GET")
     * @Template("CursoBundle:Curso:newCurso.html.twig")
     */
    public function newAction()
    {
        $entity = new Curso();
        $form   = $this->createCreateForm($entity);

        return [
            'entity' => $entity,
            'form'   => $form->createView(),
        ];
    }

    /**
     * Finds and displays a Curso entity.
     *
     * @Route("/{id}", name="curso_show")
     * @Method("GET")
     * @Template("CursoBundle:Curso:showCurso.html.twig")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CursoBundle:Curso')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Curso entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return [
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ];
    }

    /**
     * Displays a form to edit an existing Curso entity.
     *
     * @Route("/{id}/edit", name="curso_edit")
     * @Method("GET")
     * @Template("CursoBundle:Curso:editCurso.html.twig")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CursoBundle:Curso')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Curso entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return [
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ];
    }

    /**
    * Creates a form to edit a Curso entity.
    *
    * @param Curso $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Curso $entity)
    {
        $form = $this->createForm(new CursoType(), $entity, [
            'action' => $this->generateUrl('curso_update', ['id' => $entity->getId()]),
            'method' => 'PUT',
        ]);

        $form->add('submit', 'submit', ['label' => 'Update']);

        return $form;
    }
    /**
     * Edits an existing Curso entity.
     *
     * @Route("/{id}", name="curso_update")
     * @Method("PUT")
     * @Template("CursoBundle:Curso:editCurso.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CursoBundle:Curso')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Curso entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect(
                $this->generateUrl(
                    'curso_edit', ['id' => $id]
                )
            );
        }

        return [
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ];
    }
    /**
     * Deletes a Curso entity.
     *
     * @Route("/{id}", name="curso_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CursoBundle:Curso')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Curso entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect(
            $this->generateUrl('curso')
        );
    }

    /**
     * Creates a form to delete a Curso entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('curso_delete', ['id' => $id]))
            ->setMethod('DELETE')
            ->add('submit', 'submit', ['label' => 'Delete'])
            ->getForm()
        ;
    }
    /**
     * adds a Curso entity to Usuario.
     *
     * @Route("/{idCurso}/{idUsuario}", name="add_curso")
     * @Method("GET")
     */
    public function assingCursoAction($idCurso,$idUsuario)
    {
        $em = $this->getDoctrine()->getManager();

        $entityCurso = $em->getRepository('CursoBundle:Curso')->find($idCurso);
        $entityUsuario = $em->getRepository('UserBundle:Usuario')->find($idUsuario);


        if (!$entityCurso or !$entityUsuario) {
            throw $this->createNotFoundException('Unable to find Curso or Usuario entity.');
        }

            $entityUsuario->addCurso($entityCurso);
            $em->persist($entityUsuario);
            $em->flush();

            return $this->redirect(
                $this->generateUrl('curso_show', 
                    [ 'id' => $entityUsuario1->getId() ]
                )
            );
        

    }
}
