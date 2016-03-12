<?php

namespace DocumentBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use DocumentBundle\Entity\Documento;
use DocumentBundle\Form\Type\DocumentoType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\UserBundle\Model\UserInterface;
use UserBundle\Entity\Usuario;

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
     * @Route("/",name="documento_create")
     * @Method("POST")
     * @Template("DocumentBundle:Documento:newDocumento.html.twig")
     */
    public function createAction(Request $request)
    {
        $usuario = $this->get('security.token_storage')->getToken()->getUser();
        if (!is_object($usuario) || !$usuario instanceof UserInterface) {
            throw new AccessDeniedException('El usuario no tiene acceso.');
        }
        $entity = new Documento();
        $entity->setUsuario($usuario);
        $form = $this->createCreateForm($entity, $usuario);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        $namer = $entity->getDocumentFixedName();

        $pre_duplicados = $em->getRepository('DocumentBundle:Documento')->findBy([
                    'curso' => $entity->getCurso(),
        ]);

        foreach ($pre_duplicados as $duplicado) {
            if ($duplicado->getDocumentFixedName() == $form['documentFile']->getData()->getClientOriginalName()) {
                $this->get('braincrafted_bootstrap.flash')->error(sprintf('El nombre del documento ya existe en el curso'));

                return [
                'duplicado' => $duplicado,
                'form' => $form->createView(),

            ];
            }
        }

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $helper = $this->get('vich_uploader.templating.helper.uploader_helper');
            $path = $helper->asset($entity, 'documentFile');

            $em->persist($entity);
            $em->flush();

            //Usuarios asignados al curso actualmente
            $usuarios = $form['curso']->getData()->getUsuarios();

            $cantidadUsuarios = count($usuarios);

            foreach ($usuarios as $user) {
                //los args son el correo de la persona que subió el archivo
                //los correos de los usuarios asignados al curso, incluyendo al creador del curso.
                $this->sendEmail(
                    $user,
                    $this->getUser(),
                    'Se han subido el siguiente documento al curso '.$form['curso']->getData()->getNombreCurso(),
                    [$form['documentFile']->getData()->getClientOriginalName()]
                );
            }
            $this->get('braincrafted_bootstrap.flash')->success(sprintf('Se ha enviado exitosamente el correo a %s estudiantes', $cantidadUsuarios));

            return $this->redirect(
                $this->generateUrl(
                    'documento_show', ['slug' => $entity->getSlug()]
                    ));
        }

        return [
            'entity' => $entity,
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
    private function createCreateForm(Documento $entity, Usuario $usuario)
    {
        $form = $this->createForm(new DocumentoType($usuario), $entity, [
            'action' => $this->generateUrl('documento_create'),
            'method' => 'POST',
        ]);

        $form->add('submit', 'submit', ['label' => 'Aceptar y Guardar']);

        return $form;
    }

    /**
     * Displays a form to create a new Documento entity.
     *
     * @Route("/new/", name="documento_new")
     * @Method("GET")
     * @Template()
     */
    public function newDocumentoAction()
    {
        $usuario = $this->get('security.token_storage')->getToken()->getUser();
        if (!is_object($usuario) || !$usuario instanceof UserInterface) {
            throw new AccessDeniedException('El usuario no tiene acceso.');
        }
        $entity = new Documento();
        $form = $this->createCreateForm($entity, $usuario);

        return [
            'entity' => $entity,
            'form' => $form->createView(),
            'duplicado' => null,
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
     * @Route("/{slug}/edit", name="documento_edit")
     * @Method("GET")
     * @Template()
     * @ParamConverter("documento", class="DocumentBundle:Documento", options={"slug"="slug"})
     */
    public function editDocumentoAction($documento)
    {
        $usuario = $this->get('security.token_storage')->getToken()->getUser();
        if (!is_object($usuario) || !$usuario instanceof UserInterface) {
            throw new AccessDeniedException('El usuario no tiene acceso.');
        }
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

        $usuario = $this->get('security.token_storage')->getToken()->getUser();
        if (!is_object($usuario) || !$usuario instanceof UserInterface) {
            throw new AccessDeniedException('El usuario no tiene acceso.');
        }

        $deleteForm = $this->createDeleteForm($id);

        $editForm = $this->createEditForm($entity, $usuario);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect(
                $this->generateUrl(
                    'documento_edit', [
                        'id' => $id,
                        'slug' => $entity->getSlug(),
                    ]
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

    /**
     * Función para enviar un correo.
     *
     * @param Usuario $enviado_a   Nombre de la persona a la que se le envía el correo
     * @param Usuario $enviado_por Nombre de la persona que es enviado por
     * @param string  $mensaje     Mensaje
     * @param Array   $archivos    Array de string con el nombre de los documentos subidos
     */
    private function sendEmail(Usuario $enviado_a, Usuario $enviado_por, string $mensaje, array $archivos)
    {

        //new instance
         $context = [

        ];
        $fromEmail = 'no-responder@newtonlabs.com.gt';

        $message = \Swift_Message::newInstance();

        //espacio para agregar imágenes
        $img_src = $message->embed(\Swift_Image::fromPath('images/email_header.png'));//attach image 1
        $fb_image = $message->embed(\Swift_Image::fromPath('images/fb.gif'));//attach image 2
        $tw_image = $message->embed(\Swift_Image::fromPath('images/tw.gif'));//attach image 3
        $right_image = $message->embed(\Swift_Image::fromPath('images/right.gif'));//attach image 4
        $left_image = $message->embed(\Swift_Image::fromPath('images/left.gif'));//attach image 5

        $subject = 'Se ha subido un nuevo documento a Learn-IN UVG';

        $message
            ->setSubject($subject)
            ->setFrom([$fromEmail => 'Learn-In'])
            ->setTo($enviado_a->getEmail())
            ->setReplyTo($enviado_por->getEmail())
            ->setBody($this->renderView('DocumentBundle:Documento:emailDocumento.html.twig', [
                'image_src' => $img_src,
                'fb_image' => $fb_image,
                'tw_image' => $tw_image,
                'right_image' => $right_image,
                'left_image' => $left_image,
                'enviado_a' => $enviado_a,
                'enviado_por' => $enviado_por,
                'mensaje' => $mensaje,
                'archivos' => $archivos,
                ]), 'text/html')
            ->setContentType('text/html')

        ;

        $this->get('mailer')->send($message);
    }
}
