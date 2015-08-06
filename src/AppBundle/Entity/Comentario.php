<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comentario
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ComentarioRepository")
 */
class Comentario
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
     * @ORM\Column(name="usuario", type="object")
     */
    private $usuario;

    /**
     * @var \stdClass
     *
     * @ORM\Column(name="foro", type="object")
     */
    private $foro;

    /**
     * @var string
     *
     * @ORM\Column(name="comentario", type="string", length=255)
     */
    private $comentario;


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
     * Set usuario
     *
     * @param \stdClass $usuario
     * @return Comentario
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \stdClass 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set foro
     *
     * @param \stdClass $foro
     * @return Comentario
     */
    public function setForo($foro)
    {
        $this->foro = $foro;

        return $this;
    }

    /**
     * Get foro
     *
     * @return \stdClass 
     */
    public function getForo()
    {
        return $this->foro;
    }

    /**
     * Set comentario
     *
     * @param string $comentario
     * @return Comentario
     */
    public function setComentario($comentario)
    {
        $this->comentario = $comentario;

        return $this;
    }

    /**
     * Get comentario
     *
     * @return string 
     */
    public function getComentario()
    {
        return $this->comentario;
    }
}
