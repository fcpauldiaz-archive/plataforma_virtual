<?php

namespace UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints;


class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // agregar campos personalizados
        $builder->add('nombreCompleto', null, ['label' => false,
            'attr' => [
            'placeholder' => 'Nombre/s y Apellidos',
            ],

            ])
            ->add('username', null, [
                'label' => false, 
                'translation_domain' => 'FOSUserBundle',
                'constraints' => [
                    new Callback([$this,'validarNombreUsuario'])
                ],
            ])
            ->add('email', 'email', ['label' => false, 'translation_domain' => 'FOSUserBundle'])
            ->add('plainPassword', 'repeated', [
                'label' => false,
                'type' => 'password',
                'options' => ['translation_domain' => 'FOSUserBundle'],
                'first_options' => ['label' => false],
                'second_options' => ['label' => false],
                'invalid_message' => 'fos_user.password.mismatch',
            ])
            ->add('terminos', 'checkbox', ['label' => false,
                'required' => true,
                'mapped' => false,
                ])

            ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'validation' => ['registration'],
        ]);
    }
    public function getParent()
    {
        return 'fos_user_registration';
    }

    public function getName()
    {
        return 'user_registration';
    }

     /**
     * Validar que el nombre de usuario no tenga espacios en blanco
     *
     * @param Array                     $data    contiene los datos del formulario
     * @param ExecutionContextInterface $context
     */
    public function validarNombreUsuario($username, ExecutionContextInterface $context)
    {
        if (preg_match('/\s/', $username)) {
            $context->buildViolation('El nombre de usuario no puede tener espacios en blanco')
                ->atPath('fos_user_registration_register')
                ->addViolation();
        }
    }
}
