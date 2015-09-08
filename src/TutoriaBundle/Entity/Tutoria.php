<?php

namespace CursoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Curso
 *
 * @ORM\Table(name="Cursos")
 * @ORM\Entity()
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
     * [$documento cada curso tiene los documentos asociados]
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="DocumentBundle\Entity\Documento", mappedBy="curso")
     */
    private $documentos;
     /**
     * Constructor
     */
    public function __construct()
    {
        $this->usuarios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->documentos = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @param \CursoBundle\Entity\Usuario $usuarios
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
     * @param \CursoBundle\Entity\Usuario $usuarios
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

    /**
     * Add documentos
     *
     * @param \DocumentBundle\Entity\Documento $documentos
     * @return Curso
     */
    public function addDocumento(\DocumentBundle\Entity\Documento $documentos)
    {
        $this->documentos[] = $documentos;

        return $this;
    }

    /**
     * Remove documentos
     *
     * @param \DocumentBundle\Entity\Documento $documentos
     */
    public function removeDocumento(\DocumentBundle\Entity\Documento $documentos)
    {
        $this->documentos->removeElement($documentos);
    }

    /**
     * Get documentos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDocumentos()
    {
        return $this->documentos;
    }
}
