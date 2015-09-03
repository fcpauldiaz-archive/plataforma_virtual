<?php

namespace DocumentBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use DocumentBundle\Entity\Documento;
use DocumentBundle\Form\DocumentoType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Documento controller.
 *
 * @Route("/documento")
 */
class DocumentoController extends Controller
{

    /**
     * Lists all Documento entities.
     *
     * @Route("/", name="documento")
     * @Method("GET")
     * @Template()
     */
    public function indexDocumentoAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('DocumentBundle:Documento')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Documento entity.
     *
     * @Route("/{username}",name="documento_create")
     * @Method("POST")
     * @Template("DocumentBundle:Documento:new_documento.html.twig")
     * @ParamConverter("usuario", class="UserBundle:Usuario", options={"username"="username"})
     * 
     */
    public function createAction(Request $request,\UserBundle\Entity\Usuario $usuario)
    {
        $entity = new Documento();
        $form = $this->createCreateForm($entity,$usuario);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $helper = $this->container->get('vich_uploader.templating.helper.uploader_helper');
            $path = $helper->asset($entity, 'documentFile');
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('documento_show', array('id' => $entity->getId())));
        }


        return array(
            'entity' => $entity,
            'username'=>$usuario->getUserName(),
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Documento entity.
     *
     * @param Documento $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Documento $entity, \UserBundle\Entity\Usuario $usuario)
    {
        $form = $this->createForm(new DocumentoType($usuario), $entity, array(
            'action' => $this->generateUrl('documento_create',array('username'=>$usuario->getUserName())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Guardar'));

        return $form;
    }

    /**
     * Displays a form to create a new Documento entity.
     *
     * @Route("/new/{username}", name="documento_new")
     * @Method("GET")
     * @Template()
     * @ParamConverter("usuario", class="UserBundle:Usuario", options={"username"="username"})
     */
    public function newDocumentoAction(\UserBundle\Entity\Usuario $usuario)
    {
        $entity = new Documento();
        $form   = $this->createCreateForm($entity,$usuario);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Documento entity.
     *
     * @Route("/{id}", name="documento_show")
     * @Method("GET")
     * @Template()
     */
    public function showDocumentoAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DocumentBundle:Documento')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Documento entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Documento entity.
     *
     * @Route("/{username}/{id}/edit", name="documento_edit")
     * @Method("GET")
     * @Template()
     * @ParamConverter("usuario", class="UserBundle:Usuario", options={"username"="username"})
     */
    public function editDocumentoAction($id, \UserBundle\Entity\Usuario $usuario)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DocumentBundle:Documento')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Documento entity.');
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
    * Creates a form to edit a Documento entity.
    *
    * @param Documento $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Documento $entity,\UserBundle\Entity\Usuario $usuario)
    {
        $form = $this->createForm(new DocumentoType($usuario), $entity, array(
            'action' => $this->generateUrl('documento_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Actualizar'));

        return $form;
    }
    /**
     * Edits an existing Documento entity.
     *
     * @Route("/{id}", name="documento_update")
     * @Method("PUT")
     * @Template("DocumentBundle:Documento:editDocumento.html.twig")
     */
    public function updateDocumentoAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DocumentBundle:Documento')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Documento entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('documento_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Documento entity.
     *
     * @Route("/{id}", name="documento_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('DocumentBundle:Documento')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Documento entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('documento'));
    }

    /**
     * Creates a form to delete a Documento entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('documento_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Eliminar'))
            ->getForm()
        ;
    }
}
