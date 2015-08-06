<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Foro
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ForoRepository")
 */
class Foro
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \stdClass
     *
     * @ORM\Column(name="curso", type="object")
     */
    private $curso;

    /**
     * @var array
     *
     * @ORM\Column(name="comentarios", type="array")
     */
    private $comentarios;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set curso
     *
     * @param \stdClass $curso
     * @return Foro
     */
    public function setCurso($curso)
    {
        $this->curso = $curso;

        return $this;
    }

    /**
     * Get curso
     *
     * @return \stdClass 
     */
    public function getCurso()
    {
        return $this->curso;
    }

    /**
     * Set comentarios
     *
     * @param array $comentarios
     * @return Foro
     */
    public function setComentarios($comentarios)
    {
        $this->comentarios = $comentarios;

        return $this;
    }

    /**
     * Get comentarios
     *
     * @return array 
     */
    public function getComentarios()
    {
        return $this->comentarios;
    }
}
