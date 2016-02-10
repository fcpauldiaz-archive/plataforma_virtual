<?php

namespace TutoriaBundle\Form\Type;

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
                if ($tutoria->getCurso()!== null){
                    if ($tutoria->getCurso()->getId() == $curso->getId()) {
                    unset($cursos[$cursoKey]);
                    }
                }
            }
        }

        $builder
         //es más intuitivo que esté el curso de primero en el formulario
          ->add('curso', 'entity', [
                'label' => 'curso_label' ,
                'class' => 'CursoBundle:Curso',
                'choices' => $cursos,
                'attr' => [
                        'class'=>'select2'
                    ]
            ])
            ->add('lugar',null, [
                'label' => 'Lugar',
                 'attr' =>[
                    'placeholder' => 'Lugar'
                ]
            ])
            ->add('horario',null, [
                'label' => 'Horario',
                'attr' => [
                    'placeholder' => 'Aquí puede ingresar el horario disponible'
                ]
            ])
            ->add('info', null, [
                'label' => 'Informacion Adicional',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Aquí se puede ingresar cualquier información adicional'
                ]
            ])
            ->add('tipoServicio','choice',[
                'choices' => [
                        'Cobrado'=> true,
                        'Gratuito'=> false
                    ],
                'choices_as_values'=>true    

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
            'translation_domain' => 'TutoriaBundle',
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
