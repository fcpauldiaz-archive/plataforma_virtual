<?php

namespace TutoriaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tutoria.
 *
 * @ORM\Table(name="tutorias")
 * @ORM\Entity()
 */
class Tutoria
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Usuario", inversedBy="tutorias")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName = "id")
     */
    private $usuario;

    /**
     * @ORM\ManyToOne(targetEntity="CursoBundle\Entity\Curso", inversedBy="tutorias")
     * @ORM\JoinColumn(name="curso_id", referencedColumnName = "id")
     */
    private $curso;

     /**
      * @var string
      *
      * @ORM\Column(name="lugar", type="string", length = 225, nullable=true)
      */
     private $lugar;

     /**
      * @ORM\Column(name="horario",type="string", length=255, nullable=true)
      */
     private $horario;

     /**
      * @var string
      * @ORM\Column(name="info", type="string", length=255, nullable=true)
      */
     private $info;

     /**
      * @var bool
      * @ORM\Column(name="tipoServicio",type="boolean",nullable=true)
      * True = cobrado
      * False = gratuito
      */
     private $tipoServicio;

     /**
      * @var float
      *
      * @ORM\Column(name="rating", type="float")
      */
     private $rating = 0.0;

     /**
      * @var int
      *
      * @ORM\Column(name="votes", type="integer")
      */
     private $votes = 0;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set usuario.
     *
     * @param \UserBundle\Entity\Usuario $usuario
     *
     * @return Tutoria
     */
    public function setUsuario(\UserBundle\Entity\Usuario $usuario)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario.
     *
     * @return \UserBundle\Entity\Usuario
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set curso.
     *
     * @param \CursoBundle\Entity\Curso $curso
     *
     * @return Tutoria
     */
    public function setCurso(\CursoBundle\Entity\Curso $curso)
    {
        if ($curso !== null) {
            $this->curso = $curso;
        }

        return $this;
    }

    /**
     * Get curso.
     *
     * @return \CursoBundle\Entity\Curso
     */
    public function getCurso()
    {
        return $this->curso;
    }

    /**
     * @param string $imageName
     
     * Set usuario.
     * @param \UserBundle\Entity\Usuario $usuario
     *
     * @return Tutoria
     */
    public function setInfo($newInfo)
    {
        $this->info = $newInfo;
    }

    /**
     * @return string
     
     * Get usuario.
     * @return String
     */
    public function getInfo()
    {
        return $this->info;
    }

    public function setRating($newRating)
    {
        $var = $this->rating * $this->votes;
        $var = $var + $newRating;
        $this->votes = $this->votes + 1;
        $this->rating = $var / $this->votes;
    }

    public function getRating()
    {
        return $this->rating;
    }

    public function setVotes($newVotes)
    {
        $this->votes = $newVotes;
    }

    public function getVotes()
    {
        return $this->votes;
    }

    /**
     * Set lugar.
     *
     * @param string $lugar
     *
     * @return Tutoria
     */
    public function setLugar($lugar)
    {
        $this->lugar = $lugar;

        return $this;
    }

    /**
     * Get lugar.
     *
     * @return string
     */
    public function getLugar()
    {
        return $this->lugar;
    }

    /**
     * Set horario.
     *
     * @param string $horario
     *
     * @return Tutoria
     */
    public function setHorario($horario)
    {
        $this->horario = $horario;

        return $this;
    }

    /**
     * Get horario.
     *
     * @return string
     */
    public function getHorario()
    {
        return $this->horario;
    }

    /**
     * Set tipoServicio.
     *
     * @param bool $tipoServicio
     *
     * @return Tutoria
     */
    public function setTipoServicio($tipoServicio)
    {
        $this->tipoServicio = $tipoServicio;

        return $this;
    }

    /**
     * Get tipoServicio.
     *
     * @return bool
     */
    public function getTipoServicio()
    {
        return $this->tipoServicio;
    }

    public function __toString()
    {
        return sprintf('%s %s %s',
            $this->curso,
            $this->lugar,
            $this->horario
            );
    }
}
