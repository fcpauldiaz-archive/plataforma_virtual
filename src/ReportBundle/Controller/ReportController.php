<?php

namespace ReportBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function getTotalParciales()
    {
        $repository = $this->getDoctrine()->getRepository('DocumentBundle:Documento');
        $parciales = $repository->createQueryBuilder('doc')
            ->where('doc.tipoDocumento =: tipoDocumento')
            ->setParameter('tipoDocumento', 1)
            ->getQuery()
            ->getResult();

        return (int) count($parciales);
    }

    public function getTotalHojasTrabajo()
    {
        $repository = $this->getDoctrine()->getRepository('DocumentBundle:Documento');
        $hdt = $repository->createQueryBuilder('doc')
            ->where('doc.tipoDocumento =: tipoDocumento')
            ->setParameter('tipoDocumento', 0)
            ->getQuery()
            ->getResult();

        return (int) count($hdt);
    }

    public function getTotalTutorias()
    {
        $repository = $this->getDoctrine()->getRepository('TutoriaBundle:Tutoria');
        $tutorias = $repository->findAll();

        return (int) count($tutorias);
    }

    public function getCursoMasDocs()
    {
        $cursoRepository = $this->getDoctrine()->getRepository('CursoBundle:Curso');

        $cursos = $cursoRepository->findAll();
        $cursoConMasDocs = null;
        $cantidadDocs = 0;

        foreach ($cursos as $curso) {
            $cantDocumentos = $this->getCantidadDocsByCurso($curso);
            if ($cantDocumentos > $cantidadDocs) {
                $cursoConMasDocs = $curso;
                $cantidadDocs = $cantDocumentos;
            }
        }

        return [
            'curso' => $cursoConMasDocs,
            'cantidadDocs' => $cantidadDocs
        ];
    }

    public function getCursoMasTutorias()
    {
        $cursoRepository = $this->getDoctrine()->getRepository('CursoBundle:Curso');

        $cursos = $cursoRepository->findAll();
        $cursoConMasTutorias = null;
        $cantidadDocs = 0;

        foreach ($cursos as $curso) {
            $cantidadTutorias = $this->getCantidadTutoriasByCurso($curso);
            if ($cantidadTutorias > $cantidadDocs) {
                $cursoConMasTutorias = $curso;
                $cantidadDocs = $cantidadTutorias;
            }
        }

        return [
            'curso' => $cursoConMasDocs,
            'cantidadTutorias' => $cantidadDocs
        ];
    }

    public function getUsuarioMasDocs()
    {

    }

    public function getCantidadDocsByCurso($curso)
    {
        $repository = $this->getDoctrine()->getRepository('DocumentBundle:Documento');
        $cantDocumentos = $repository
            ->createQueryBuilder('doc')
            ->select('COUNT(doc)')
            ->where('doc.curso = :curso')
            ->setParameter('curso', $curso)
            ->getQuery()
            ->getSingleScalarResult();

        return (int) $cantDocumentos;
    }

    public function getCantidadTutoriasByCurso($curso)
    {
        $repository = $this->getDoctrine()->getRepository('TutoriaBundle:Tutoria');
        $cantTutorias = $repository
            ->createQueryBuilder('t')
            ->select('COUNT(t)')
            ->where('t.curso = :curso')
            ->setParameter('curso', $curso)
            ->getQuery()
            ->getSingleScalarResult();

        return (int) $cantTutorias;
    }
}
