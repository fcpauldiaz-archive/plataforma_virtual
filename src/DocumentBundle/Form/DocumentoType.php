<?php

namespace DocumentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceList;

class DocumentoType extends AbstractType
{
    private $usuario;
    private $editBoolean = true;

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
          //  ->add('documentName',null,['label'=>'Nombre del Documento'])
            ->add('tipoDocumento', 'choice', array(
            'choices' => array(1 => 'Parcial', 0 => 'Hoja de Trabajo'),

            ))
            ->add('curso', 'entity', array(
                'class' => 'CursoBundle:Curso',
                'choices' => $this->getUsuario()->getCursos(),

            ))
            ->add('numeroDocumento', 'choice', array(
                'choice_list' => new ChoiceList(
                    array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10),
                    array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10')
                ),
                'label' => 'Número del documento',
            ))

           ;
        if ($this->editBoolean == true) {
            $builder->add('documentFile', 'vich_file', array('label' => false));
        }
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DocumentBundle\Entity\Documento',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'documentbundle_documento';
    }

    public function getUsuario()
    {
        return $this->usuario;
    }
    public function setEditBoolean($param)
    {
        $this->editBoolean = $param;
    }
}
