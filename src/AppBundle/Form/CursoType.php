<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class CursoType extends AbstractType
{

public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('nombreCurso','text',['label'=>'Nombre Curso'])
			->add('codigoCurso','text',['label'=>'Codigo Curso'])
            ->add('save', 'submit', array('label' => 'Create Curso'));
	}

	public function getName()
	{
		return 'curso';
	}

	public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Cliente',
        ));
    }


}