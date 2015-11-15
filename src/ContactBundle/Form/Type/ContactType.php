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
            ->add('title', 'hidden', [
                  'data' => 'mr',
            ])
            ->add('firstName', 'text',  ['label' => 'mremi_contact.form.first_name',
                'attr' => ['placeholder' => 'mremi_contact.form.first_name'],
                ])
            ->add('lastName',  'text',  ['label' => 'mremi_contact.form.last_name',
                'attr' => ['placeholder' => 'mremi_contact.form.last_name'],
                ])
            ->add('email',     'email', ['label' => 'mremi_contact.form.email',
                'attr' => ['placeholder' => 'mremi_contact.form.email'],
                ])
            ->add('subject', 'text', ['label' => 'mremi_contact.form.subject',
                'attr' => ['placeholder' => 'mremi_contact.form.subject'],
                ])
            ->add('message', 'textarea', ['label' => 'mremi_contact.form.message',
                'attr' => ['placeholder' => 'mremi_contact.form.message'],
                ]);

       
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([

            'intention' => 'contact',
            'translation_domain' => 'MremiContactBundle',
        ]);
    }

    public function getName()
    {
        return 'contact_type';
    }
}
