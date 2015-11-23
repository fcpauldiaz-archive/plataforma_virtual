<?php

namespace TutoriaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use UserBundle\Entity\Usuario as Usuario;

class VoteTutoriaType extends AbstractType
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
        
        $builder->add('rating','rating',array('stars'=>5))
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
