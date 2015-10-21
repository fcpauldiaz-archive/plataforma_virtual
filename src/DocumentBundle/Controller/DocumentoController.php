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

        return [
            'entities' => $entities,
        ];
    }
    /**
     * Creates a new Documento entity.
     *
     * @Route("/{username}",name="documento_create")
     * @Method("POST")
     * @Template("DocumentBundle:Documento:newDocumento.html.twig")
     * @ParamConverter("usuario", class="UserBundle:Usuario", options={"username"="username"})
     */
    public function createAction(Request $request, \UserBundle\Entity\Usuario $usuario)
    {
        $entity = new Documento();
        $form = $this->createCreateForm($entity, $usuario);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $helper = $this->container->get('vich_uploader.templating.helper.uploader_helper');
            $path = $helper->asset($entity, 'documentFile');
            $em->persist($entity);
            $em->flush();

            return $this->redirect(
                $this->generateUrl(
                    'documento_show', ['id' => $entity->getId()]
                    ));
        }

        return [
            'entity' => $entity,
            'username' => $usuario->getUserName(),
            'form' => $form->createView(),
        ];
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
            'action' => $this->generateUrl('documento_create', ['username' => $usuario->getUserName()]),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', ['label' => 'Guardar']);

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
        $form = $this->createCreateForm($entity, $usuario);

        return [
            'entity' => $entity,
            'form' => $form->createView(),
        ];
    }

    /**
     * Finds and displays a Documento entity.
     *
     * @Route("/{slug}", name="documento_show")
     * @Method("GET")
     * @ParamConverter("documento", class="DocumentBundle:Documento", options={"slug"="slug"})
     * @Template()
     */
    public function showDocumentoAction($documento)
    {
        if (!$documento) {
            throw $this->createNotFoundException('Unable to find Documento entity.');
        }

        $deleteForm = $this->createDeleteForm($documento->getId());

        return [
            'entity' => $documento,
            'delete_form' => $deleteForm->createView(),
        ];
    }

    /**
     * Displays a form to edit an existing Documento entity.
     *
     * @Route("/{username}/{slug}/edit", name="documento_edit")
     * @Method("GET")
     * @Template()
     * @ParamConverter("usuario", class="UserBundle:Usuario", options={"username"="username"})
     * @ParamConverter("documento", class="DocumentBundle:Documento", options={"slug"="slug"})
     */
    public function editDocumentoAction($documento, \UserBundle\Entity\Usuario $usuario)
    {
        if (!$documento) {
            throw $this->createNotFoundException('Unable to find Documento entity.');
        }

        $editForm = $this->createEditForm($documento, $usuario);
        $deleteForm = $this->createDeleteForm($documento->getId());

        return [
            'entity' => $documento,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ];
    }

    /**
     * Creates a form to edit a Documento entity.
     *
     * @param Documento $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Documento $entity, \UserBundle\Entity\Usuario $usuario)
    {
        $var = new DocumentoType($usuario);
        $var->setEditBoolean(false);
        $form = $this->createForm($var, $entity, [
            'action' => $this->generateUrl('documento_update', ['id' => $entity->getId()]),
            'method' => 'PUT',
        ]);

        $form->add('submit', 'submit', ['label' => 'Actualizar']);

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

            return $this->redirect(
                $this->generateUrl(
                    'documento_edit', ['id' => $id]
                )
            );
        }

        return [
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ];
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

        return $this->redirect(
            $this->generateUrl(
                'documento'
            )
        );
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
            ->setAction($this->generateUrl('documento_delete', ['id' => $id]))
            ->setMethod('DELETE')
            ->add('submit', 'submit', ['label' => 'Eliminar'])
            ->getForm()
        ;
    }
}
