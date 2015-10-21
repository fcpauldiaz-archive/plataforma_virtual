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
        $builder
            ->add('info',null,['label'=>'Informacion Adicional'])
            
            ->add('curso', 'entity', array(
                'class' => 'CursoBundle:Curso',
                'choices' => $this->getUsuario()->getCursos(),      
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
