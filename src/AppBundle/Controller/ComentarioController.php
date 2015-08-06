<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Comentario;
use AppBundle\Form\ComentarioType;

/**
 * Comentario controller.
 *
 * @Route("/comentario")
 */
class ComentarioController extends Controller
{

    /**
     * Lists all Comentario entities.
     *
     * @Route("/", name="comentario")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Comentario')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Comentario entity.
     *
     * @Route("/", name="comentario_create")
     * @Method("POST")
     * @Template("AppBundle:Comentario:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Comentario();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('comentario_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Comentario entity.
     *
     * @param Comentario $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Comentario $entity)
    {
        $form = $this->createForm(new ComentarioType(), $entity, array(
            'action' => $this->generateUrl('comentario_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Comentario entity.
     *
     * @Route("/new", name="comentario_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Comentario();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Comentario entity.
     *
     * @Route("/{id}", name="comentario_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Comentario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Comentario entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Comentario entity.
     *
     * @Route("/{id}/edit", name="comentario_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Comentario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Comentario entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Comentario entity.
    *
    * @param Comentario $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Comentario $entity)
    {
        $form = $this->createForm(new ComentarioType(), $entity, array(
            'action' => $this->generateUrl('comentario_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Comentario entity.
     *
     * @Route("/{id}", name="comentario_update")
     * @Method("PUT")
     * @Template("AppBundle:Comentario:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Comentario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Comentario entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('comentario_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Comentario entity.
     *
     * @Route("/{id}", name="comentario_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Comentario')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Comentario entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('comentario'));
    }

    /**
     * Creates a form to delete a Comentario entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('comentario_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
