<?php

namespace TutoriaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use TutoriaBundle\Entity\Tutoria;
use TutoriaBundle\Form\TutoriaType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use FOS\UserBundle\Model\UserInterface;

/**
 * Tutoria controller.
 *
 * @Route("/tutoria")
 */
class TutoriaController extends Controller
{

    /**
     * Lists all Tutoria entities.
     *
     * @Route("/index/", name="tutoria")
     * @Method("GET")
     * @Template()
     */
    public function indexTutoriaAction()
    {
        $usuario = $this->container->get('security.context')->getToken()->getUser();
        if (!is_object($usuario) || !$usuario instanceof UserInterface) {

            throw new AccessDeniedException('El usuario no tiene acceso.');
        }
                
        $entities = $usuario->getTutorias();

        return array(
            'entities' => $entities,
        );
    }
    
    /**
     * Lists all Tutoria entities.
     *
     * @Route("/show/all", name="tutoria_all")
     * @Method("GET")
     * @Template()
     */
    public function allTutoriaAction()
    {
        
        $usuario = $this->container->get('security.context')->getToken()->getUser();
        if (!is_object($usuario) || !$usuario instanceof UserInterface) {

            throw new AccessDeniedException('El usuario no tiene acceso.');
        }
        
        
        $em = $this->getDoctrine()->getManager();
        
        
        $entitiesU = $usuario->getTutorias();


        $entities = $em->getRepository('TutoriaBundle:Tutoria')->findAll();
        
        foreach ($entitiesU as $entityKey => $entity){
            foreach ($entities as $elementKey => $element){
                if ($entity->getId() == $element->getId()){
                    unset($entities[$elementKey]);
                }
            }
        }
        
        
        
        return 
            $this -> render('TutoriaBundle:Tutoria:allTutoria.html.twig', array('entities' => $entities));        
    }
    
    /**
     * Creates new Tutoria entity.
     *
     * @Route("/{username}",name="tutoria_create")
     * @Method("POST")
     * @Template("TutoriaBundle:Tutoria:new_tutoria.html.twig")
     * @ParamConverter("usuario", class="UserBundle:Usuario", options={"username"="username"})
     * 
     */
    public function createAction(Request $request,\UserBundle\Entity\Usuario $usuario)
    {
        $entity = new Tutoria();
        $entity->setUsuario($usuario);
        $form = $this->createCreateForm($entity,$usuario);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('tutoria_show', array('id' => $entity->getId())));
        }


        return array(
            'entity' => $entity,
            'username'=>$usuario->getUserName(),
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a tutoria entity.
     *
     * @param Tutoria $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Tutoria $entity, \UserBundle\Entity\Usuario $usuario)
    {
        $form = $this->createForm(new TutoriaType($usuario), $entity, array(
            'action' => $this->generateUrl('tutoria_create',
            array('username'=>$usuario->getUserName())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Guardar'));

        return $form;
    }

    /**
     * Displays a form to create a new Tutoria entity.
     *
     * @Route("/new/", name="tutoria_new")
     * @Method("GET")
     * @Template()
     * 
     */
    public function newTutoriaAction()
    {
        $usuario = $this->container->get('security.context')->getToken()->getUser();
        if (!is_object($usuario) || !$usuario instanceof UserInterface) {

            throw new AccessDeniedException('El usuario no tiene acceso.');
        }
        $entity = new Tutoria();
        $form   = $this->createCreateForm($entity,$usuario);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Tutoria entity.
     *
     * @Route("/{id}", name="tutoria_show")
     * @Method("GET")
     * @Template()
     */
    public function showTutoriaAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TutoriaBundle:Tutoria')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tutoria entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Tutoria entity.
     *
     * @Route("/user/{id}/edit", name="tutoria_edit")
     * @Method("GET")
     * @Template()
     * 
     */
    public function editTutoriaAction($id)
    {
        $usuario = $this->container->get('security.context')->getToken()->getUser();
        if (!is_object($usuario) || !$usuario instanceof UserInterface) {

            throw new AccessDeniedException('El usuario no tiene acceso.');
        }
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TutoriaBundle:Tutoria')->find($id);
        

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tutoria entity.');
        }

        $editForm = $this->createEditForm($entity,$usuario);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a tutoria entity.
    *
    * @param Tutoria $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Tutoria $entity,\UserBundle\Entity\Usuario $usuario)
    {
        $form = $this->createForm(new TutoriaType($usuario), $entity, array(
            'action' => $this->generateUrl('tutoria_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Actualizar'));

        return $form;
    }
    /**
     * Edits an existing Tutoria entity.
     *
     * @Route("/{id}", name="tutoria_update")
     * @Method("PUT")
     * @Template("TutoriaBundle:Tutoria:editTutoria.html.twig")
     */
    public function updateTutoriaAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TutoriaBundle:Tutoria')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tutoria entity.');
        }
        $usuario = $this->container->get('security.context')->getToken()->getUser();
        if (!is_object($usuario) || !$usuario instanceof UserInterface) {

            throw new AccessDeniedException('El usuario no tiene acceso.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity,$usuario);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            
        }
        
        return $this->redirect($this->generateUrl('tutoria',['id'=> $usuario->getId()]));
        
    }
    /**
     * Deletes a Tutoria entity.
     *
     * @Route("/{id}", name="tutoria_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('TutoriaBundle:Tutoria')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Tutoria entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('tutoria'));
    }
    
    

    /**
     * Creates a form to delete a Tutoria entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tutoria_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Eliminar'))
            ->getForm()
        ;
    }
}
