<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Curso
 *
 * @ORM\Table(name="Cursos")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\CursoRepository")
 */
class Curso
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
     * @var string
     *
     * @ORM\Column(name="nombreCurso", type="string", length=50)
     */
    private $nombreCurso;

    /**
     * @var string
     *
     * @ORM\Column(name="codigoCurso", type="string", length=50)
     */
    private $codigoCurso;

    /**
     * @ORM\ManyToMany(targetEntity="UserBundle\Entity\Usuario", mappedBy="cursos")
     **/
    private $usuarios;

     /**
     * Constructor
     */
    public function __construct()
    {
        $this->usuarios = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set nombreCurso
     *
     * @param string $nombreCurso
     * @return Curso
     */
    public function setNombreCurso($nombreCurso)
    {
        $this->nombreCurso = $nombreCurso;

        return $this;
    }

    /**
     * Get nombreCurso
     *
     * @return string 
     */
    public function getNombreCurso()
    {
        return $this->nombreCurso;
    }

    /**
     * Set codigoCurso
     *
     * @param string $codigoCurso
     * @return Curso
     */
    public function setCodigoCurso($codigoCurso)
    {
        $this->codigoCurso = $codigoCurso;

        return $this;
    }

    /**
     * Get codigoCurso
     *
     * @return string 
     */
    public function getCodigoCurso()
    {
        return $this->codigoCurso;
    }
   

    /**
     * Add usuarios
     *
     * @param \AppBundle\Entity\Usuario $usuarios
     * @return Curso
     */
    public function addUsuario(\UserBundle\Entity\Usuario $usuarios)
    {
        $this->usuarios[] = $usuarios;

        return $this;
    }

    /**
     * Remove usuarios
     *
     * @param \AppBundle\Entity\Usuario $usuarios
     */
    public function removeUsuario(\UserBundle\Entity\Usuario $usuarios)
    {
        $this->usuarios->removeElement($usuarios);
    }

    /**
     * Get usuarios
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsuarios()
    {
        return $this->usuarios;
    }

    public function __toString(){

        return $this->nombreCurso;
    }
}
