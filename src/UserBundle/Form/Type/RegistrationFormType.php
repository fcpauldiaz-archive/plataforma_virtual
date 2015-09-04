<?php

namespace UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // agregar campos personalizados
        $builder->add('nombreCompleto',null,array('label' => false,
            'attr'=>[
            'placeholder'=> 'Nombre/s y Apellidos',
            ]

            ))
            ->add('username', null, array('label' => false, 'translation_domain' => 'FOSUserBundle'))
            ->add('email', 'email', array('label' => false, 'translation_domain' => 'FOSUserBundle'))
            ->add('plainPassword', 'repeated', array(
                'label'=>false,
                'type' => 'password',
                'options' => array('translation_domain' => 'FOSUserBundle'),
                'first_options' => array('label' => false),
                'second_options' => array('label' => false),
                'invalid_message' => 'fos_user.password.mismatch',
            ));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'validation' => array('registration')
        ));
    }
    public function getParent()
    {
        return 'fos_user_registration';
    }

    public function getName()
    {
        return 'user_registration';
    }
}