<?php

namespace CursoBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use CursoBundle\Entity\Curso;

class CreateCursoCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('curso:create')
            ->setDescription('Create a user.')
            ->setDefinition([
                new InputArgument('nombre', InputArgument::REQUIRED, 'Nombre curso'),
                new InputArgument('codigo', InputArgument::REQUIRED, 'Código curso'),
            ])

        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $nombre = $input->getArgument('nombre');
        $codigo = $input->getArgument('codigo');
        $text = '';
        if ($nombre && $codigo) {
            $curso = new Curso();
            $curso->setNombreCurso($nombre);
            $curso->setCodigoCurso($codigo);
            $em = $this->getContainer()->get('doctrine.orm.entity_manager');
            $em->persist($curso);
            $em->flush();
            $text = 'Curso '.$nombre.' creado exitosamente';
        } else {
            $text = 'Error al crear el curso'.$nombre.$codigo;
        }

        $output->writeln($text);
    }

    protected function interact(InputInterface $input, OutputInterface $output)
    {
        if (!$input->getArgument('nombre')) {
            $nombre = $this->getHelper('dialog')->askAndValidate(
                $output,
                'Ingrese nombre del curso:',
                function ($nombre) {
                    if (empty($nombre)) {
                        throw new \Exception('El nombre no puede estar vacío');
                    }

                    return $nombre;
                }
            );
            $input->setArgument('nombre', $nombre);
        }
        if (!$input->getArgument('codigo')) {
            $codigo = $this->getHelper('dialog')->askAndValidate(
                $output,
                'Ingrese el código del curso:',
                function ($codigo) {
                    if (empty($codigo)) {
                        throw new \Exception('El código no puede estar vacío');
                    }

                    return $codigo;
                }
            );
            $input->setArgument('codigo', $codigo);
        }
    }
}
