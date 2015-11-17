<?php

namespace ContactBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Contact type class.
 *
 * @author Rémi Marseille <marseille.remi@gmail.com>
 */
class ContactType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('nombreCompleto', 'text',  ['label' => 'mremi_contact.form.first_name',
                'attr' => ['placeholder' => 'mremi_contact.form.first_name'],
                ])
            ->add('correo',     'email', ['label' => 'mremi_contact.form.email',
                'attr' => ['placeholder' => 'mremi_contact.form.email'],
                ])
            ->add('asunto', 'text', ['label' => 'mremi_contact.form.subject',
                'attr' => ['placeholder' => 'Asunto'],
                ])
            ->add('mensaje', 'textarea', ['label' => 'mremi_contact.form.message',
                'attr' => ['placeholder' => 'Mensaje'],
                ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
        'data_class' => 'ContactBundle\Entity\Contact',
    ));
    }

    public function getName()
    {
        return 'contact_type';
    }
}
