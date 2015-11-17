<?php

namespace TutoriaBundle\Type\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use UserBundle\Entity\Usuario as Usuario;

class TutoriaType extends AbstractType
{
    private $usuario;

    public function __construct(Usuario $user)
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

            ->add('curso', 'entity', [
                'class' => 'CursoBundle:Curso',
                'choices' => $cursos,
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'TutoriaBundle\Entity\Tutoria',
        ]);
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
