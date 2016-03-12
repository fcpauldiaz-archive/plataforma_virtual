<?php

namespace ReportBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ReportController extends Controller
{
    /**
     * @Route("/admin", name = "administration")
     *
     * @return [type] [description]
     */
    public function getEstadisticasAction()
    {
        $totalParciales = $this->getTotalParciales();
        $totalHDT = $this->getTotalHojasTrabajo();
        $totalTutorias = $this->getTotalTutorias();
        $cursoTopDocs = $this->getCursoMasDocs();
        $cursoTopTutorias = $this->getCursoMasTutorias();
        $usuario = $this->getUsuarioMasDocs();
        $cantidadCursos = $this->getCursosTotal();
        $cantidadUsuarios = $this->getUsuariosTotal();

        return $this->render(
            'admin/indexAdmin.html.twig',
            [
                't_parciales' => $totalParciales,
                't_hojasTrabajo' => $totalHDT,
                't_tutorias' => $totalTutorias,
                'cursot_docs' => $cursoTopDocs,
                'cursot_tutorias' => $cursoTopTutorias,
                'usuario' => $usuario,
                't_cursos' => $cantidadCursos,
                't_usuarios' => $cantidadUsuarios,
            ]
        );
    }

    private function getTotalParciales()
    {
        $repository = $this->getDoctrine()->getRepository('DocumentBundle:Documento');
        $parciales = $repository->createQueryBuilder('doc')
            ->select('COUNT(doc)')
            ->where('doc.tipoDocumento = :tipoDocumento')
            ->setParameter('tipoDocumento', true)
            ->getQuery()
            ->getSingleScalarResult();

        return  (int) $parciales;
    }

    private function getTotalHojasTrabajo()
    {
        $repository = $this->getDoctrine()->getRepository('DocumentBundle:Documento');
        $hdt = $repository->createQueryBuilder('doc')

            ->select('COUNT(doc)')
            ->where('doc.tipoDocumento = :tipoDocumento')
            ->setParameter('tipoDocumento', false)
            ->getQuery()
            ->getSingleScalarResult();

        return (int) $hdt;
    }

    private function getTotalTutorias()
    {
        $repository = $this->getDoctrine()->getRepository('TutoriaBundle:Tutoria');
        $tutorias = $repository->findAll();

        return (int) count($tutorias);
    }

    private function getCursoMasDocs()
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
            'cantidadDocs' => $cantidadDocs,
        ];
    }

    private function getCursoMasTutorias()
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
            'curso' => $cursoConMasTutorias,
            'cantidadTutorias' => $cantidadDocs,
        ];
    }

    private function getUsuarioMasDocs()
    {
        $repository = $this->getDoctrine()->getRepository('UserBundle:Usuario');

        $usuarios = $repository->findAll();
        $usuarioConMasDocs = null;
        $cantidadDocs = 0;

        foreach ($usuarios as $usuario) {
            $cantidadDocumentos = $this->getCantidadDocsByUsuario($usuario);
            if ($cantidadDocumentos > $cantidadDocs && !$usuario->hasRole('ROLE_ADMIN')) {
                $usuarioConMasDocs = $usuario;
                $cantidadDocs = $cantidadDocumentos;
            }
        }

        return $usuarioConMasDocs;
    }

    private function getCantidadDocsByCurso($curso)
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

    private function getCantidadTutoriasByCurso($curso)
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

    private function getCantidadDocsByUsuario($usuario)
    {
        $repository = $this->getDoctrine()->getRepository('DocumentBundle:Documento');
        $cantDocumentos = $repository
            ->createQueryBuilder('doc')
            ->select('COUNT(doc)')
            ->where('doc.usuario = :usuario')
            ->setParameter('usuario', $usuario)
            ->getQuery()
            ->getSingleScalarResult();

        return (int) $cantDocumentos;
    }

    private function getCursosTotal()
    {
        $cursoRepository = $this->getDoctrine()->getRepository('CursoBundle:Curso');

        $cursos = $cursoRepository->findAll();

        return (int) count($cursos);
    }
    private function getUsuariosTotal()
    {
        $cursoRepository = $this->getDoctrine()->getRepository('UserBundle:Usuario');

        $usuarios = $cursoRepository->findAll();

        return (int) count($usuarios);
    }
}
