<?php

namespace ReportBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ReportController extends Controller
{
    public function getEstadisticasAction()
    {
        $totalParciales = $this->getTotalParciales();
        $totalHDT = $this->getTotalHojasTrabajo();
        $totalTutorias = $this->getTotalTutorias();
        $cursoTopDocs = $this->getCursoMasDocs();
        $cursoTopTutorias = $this->getCursoMasTutorias();

        return $this->render(
            'getEstadisticas.html.twig',
            [
                't_parciales' => $totalParciales,
                't_hojasTrabajo' => $totalHDT,
                't_tutorias' => $totalTutorias,
                'cursot_docs' => $cursoTopDocs,
                'cursot_tutorias' => $cursoTopTutorias
            ]
        );
    }

    /**
     * @Route("/admin", name = "administration")
     * @Template("admin/indexAdmin.html.twig")
     *
     */
    public function getTotalParciales()
    {
        $repository = $this->getDoctrine()->getRepository('DocumentBundle:Documento');
        $parciales = $repository->createQueryBuilder('doc')
            ->where('doc.tipoDocumento =: tipoDocumento')
            ->setParameter('tipoDocumento', 1)
            ->getQuery()
            ->getResult();

           return ['cantParciales' => (int) count($parciales)];
    
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
