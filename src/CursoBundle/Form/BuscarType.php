<?php

namespace CursoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BuscarType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('curso', 'entity', [
                'empty_value' => 'Seleccionar curso',
                'class' => 'CursoBundle:Curso',
                'property' => 'nombreCurso',
                'label'   => 'Buscador de Cursos',
                'attr' => [
                    'class' => 'select2',
                    'onchange' => 'this.form.submit()'
                ],
            ])
        ;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_curso';
    }
}
