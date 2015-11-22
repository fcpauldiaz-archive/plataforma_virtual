<?php

namespace ContactBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use ContactBundle\Entity\Contact;
use FOS\UserBundle\Model\UserInterface;
use ContactBundle\Form\Type\ContactType;

/**
 * @author  fcpauldiaz fcpauldiaz@icloud.com
 * @Route("/contact")
 */
class ContactController extends Controller
{
    /**
     * @Route("/send",name ="send_email")
     * @Template("ContactBundle:Contact:showContact.html.twig")
     */
    public function enviarCorreoAction(Request $request)
    {
        $entity = new Contact();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $varNombre = $form->get('nombreCompleto')->getData();
            $varCorreo = $form->get('correo')->getData();
            $varAsunto = $form->get('asunto')->getData();
            $varMensaje = $form->get('mensaje')->getData();

            $message = \Swift_Message::newInstance()

              ->setFrom([$varCorreo => $varNombre])
              ->setTo('dia13203@uvg.edu.gt')
              ->setSubject($varAsunto)
              ->setBody(
                $this->renderView(
                    // app/Resources/views/Emails/registration.html.twig
                    'ContactBundle:Contact:contactEmail.html.twig',
                    ['contenido' => $varMensaje, 'nombre' => $varNombre, 'correo' => $varCorreo]
                ),
                'text/html'
            )

            ;

            $this->get('mailer')->send($message);

            return $this->redirect(
                $this->generateUrl(
                    'homepage'
                )
            );
        }

        return [
            'form' => $form->createView(),
        ];
    }
    /**
     * @return [type] [description]
     */
    public function createCreateFormAction(Contact $entity)
    {
        $form = $this->createForm(new ContactType(), $entity, [
            'action' => $this->generateUrl('send_email'),

        ]);

        return $form;
    }

    /**
     * Displays a form to create a new Contact entity.
     *
     * @Route("/",name="contact")
     * @Method("GET")
     * @Template("ContactBundle:Contact:showContact.html.twig")
     */
    public function showContactAction()
    {
        $usuario = $this->get('security.token_storage')->getToken()->getUser();
        if (!is_object($usuario) || !$usuario instanceof UserInterface) {
            throw new AccessDeniedException('El usuario no tiene acceso.');
        }

        $form = $this->createCreateFormAction(new Contact());

        return [
            'form' => $form->createView(),
            'nombreUsuario' => $usuario->getNombreCompleto(),
            'correoUsuario' => $usuario->getEmail(),
        ];
    }
}
