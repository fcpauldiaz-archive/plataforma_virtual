<?php

namespace DocumentBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceList;
use UserBundle\Entity\Usuario;

class DocumentoType extends AbstractType
{
    private $usuario;
    private $editBoolean = true;

    public function __construct(Usuario  $user)
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
          //  ->add('documentName',null,['label'=>'Nombre del Documento'])
            ->add('tipoDocumento', 'choice', [
                'choices' => [1 => 'Parcial', 0 => 'Hoja de Trabajo'],
                'constraints' => [
                    new NotNull(),
                ],

            ])
            ->add('curso', 'entity', [
                'class' => 'CursoBundle:Curso',
                'choices' => $this->getUsuario()->getCursos(),

            ])
            ->add('numeroDocumento', 'choice', [
                'choice_list' => new ChoiceList(
                    [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                    ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10']
                ),
                'label' => 'Número del documento',
            ])

           ;
        if ($this->editBoolean === true) {
            $builder->add('documentFile', 'vich_file', ['label' => false,
                'attr' => ['class' => 'filestyle', 'data-buttonBefore' => true],
                ]);
        }
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'DocumentBundle\Entity\Documento',
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'documentbundle_documento';
    }
    /**
     * @return Usuario
     */
    public function getUsuario()
    {
        return $this->usuario;
    }
    /**
     * @param bool
     */
    public function setEditBoolean($param)
    {
        $this->editBoolean = $param;
    }
}
