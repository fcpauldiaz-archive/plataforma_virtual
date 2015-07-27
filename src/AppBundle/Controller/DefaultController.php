<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        return $this->render('UserBundle:Default:index.html.twig');
    }

    /**
	* @Route("/nuevo/curso", name="curso_nuevo")
    */
    public function cursoAction()
    {


    	$curso = new Curso();
    	$form = $this->createForm(new CursoType(),$curso);
    	
    	$form->handleRequest($request);

    	if ($form->isSubmitted() && $form->isValid()){
    		$em = $this->getDoctrine()->getManager();
    		$em->persist($curso);
    		$em->flush();

    		$session = $this->getRequest()->getSession();
    		$session ->getFlashBag->add('message','Curso Creado');

    		return $this->render('default/nuevo_curso.html.twig', array('form'=>$form->createView()));
    	}

    	return $this->render('default/nuevo_cliente.html.twig', array('form'=>$form->createView()));

    }
}
