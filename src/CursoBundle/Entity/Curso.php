<?php

namespace CursoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Curso.
 *
 * @ORM\Table(name="Cursos")
 * @ORM\Entity()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 */
class Curso
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
     * @var string
     *
     * @ORM\Column(name="nombreCurso", type="string", length=50)
     * @ORM\OrderBy({"nombreCurso" = "ASC"})
     */
    private $nombreCurso;
    /**
     * @var string
     * 
     * @ORM\Column(name="codigoCurso", type="string", length=50,unique = true)
     */
    private $codigoCurso;
    /**
     *  Usuarios que asociados al curso.
     *
     * @ORM\ManyToMany(targetEntity="UserBundle\Entity\Usuario", mappedBy="cursos")
     **/
    private $usuarios;
    /**
     * [$documento cada curso tiene los documentos asociados].
     * 
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="DocumentBundle\Entity\Documento", mappedBy="curso")
     * @ORM\OrderBy({"numeroDocumento" = "ASC"})
     */
    private $documentos;

    /**
     * Sirve para hacer soft delete de la entidad
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * Sirve para generar URL's a base de nombre curos y codigo curso
     * De esta forma no se muestra el id en el URL
     * @Gedmo\Slug(fields={"nombreCurso", "codigoCurso"},updatable=true)
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->usuarios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->documentos = new \Doctrine\Common\Collections\ArrayCollection();
    }
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
     * Set nombreCurso.
     *
     * @param string $nombreCurso
     *
     * @return Curso
     */
    public function setNombreCurso($nombreCurso)
    {
        $this->nombreCurso = $nombreCurso;

        return $this;
    }
    /**
     * Get nombreCurso.
     *
     * @return string
     */
    public function getNombreCurso()
    {
        return $this->nombreCurso;
    }
    /**
     * Set codigoCurso.
     *
     * @param string $codigoCurso
     *
     * @return Curso
     */
    public function setCodigoCurso($codigoCurso)
    {
        $this->codigoCurso = $codigoCurso;

        return $this;
    }
    /**
     * Get codigoCurso.
     *
     * @return string
     */
    public function getCodigoCurso()
    {
        return $this->codigoCurso;
    }

    /**
     * Add usuarios.
     *
     * @param \CursoBundle\Entity\Usuario $usuarios
     *
     * @return Curso
     */
    public function addUsuario(\UserBundle\Entity\Usuario $usuarios)
    {
        $this->usuarios[] = $usuarios;

        return $this;
    }
    /**
     * Remove usuarios.
     *
     * @param \CursoBundle\Entity\Usuario $usuarios
     */
    public function removeUsuario(\UserBundle\Entity\Usuario $usuarios)
    {
        $this->usuarios->removeElement($usuarios);
    }
    /**
     * Get usuarios.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsuarios()
    {
        return $this->usuarios;
    }
    public function __toString()
    {
        return $this->nombreCurso;
    }
    /**
     * Add documentos.
     *
     * @param \DocumentBundle\Entity\Documento $documentos
     *
     * @return Curso
     */
    public function addDocumento(\DocumentBundle\Entity\Documento $documentos)
    {
        $this->documentos[] = $documentos;

        return $this;
    }
    /**
     * Remove documentos.
     *
     * @param \DocumentBundle\Entity\Documento $documentos
     */
    public function removeDocumento(\DocumentBundle\Entity\Documento $documentos)
    {
        $this->documentos->removeElement($documentos);
    }
    /**
     * Get documentos.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDocumentos()
    {
        return $this->documentos;
    }

    public function getCurso()
    {
        return $this;
    }

    /**
     * Set deletedAt.
     *
     * @param \DateTime $deletedAt
     *
     * @return Curso
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * Get deletedAt.
     * 
     * @return \DateTime
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * Set slug.
     *
     * @param string $slug
     *
     * @return Curso
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug.
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }
    /**
     * El método es llamado para mostrar los dos atributos en el select2.
     * @return string obtener el nombre y el codigo en un solo método .
     */
    public function getCodigoNombre()
    {
        return sprintf(
            '%s - %s',
            $this->getCodigoCurso(),
            $this
        );
    }
}
