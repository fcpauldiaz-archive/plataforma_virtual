<?php

namespace TutoriaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TutoriaType extends AbstractType
{
    private $usuario;

    public function __construct(\UserBundle\Entity\Usuario  $user)
    {
        $this->usuario = $user;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $cursos = $this->getUsuario()->getCursos();//todos los cursos del usuario
        $tutorias = $this->getUsuario()->getTutorias();//todas las tutorias

        foreach ($cursos as $cursoKey => $curso) {
            foreach ($tutorias as $tutoriaKey => $tutoria) {
                if ($tutoria->getCurso()->getId() == $curso->getId()) {
                    unset($cursos[$cursoKey]);
                }
            }
        }

        $builder
            ->add('info', null, ['label' => 'Informacion Adicional'])

            ->add('curso', 'entity', array(
                'class' => 'CursoBundle:Curso',
                'choices' => $cursos,
            ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TutoriaBundle\Entity\Tutoria',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'tutoriabundle_tutoria';
    }

    public function getUsuario()
    {
        return $this->usuario;
    }
}
