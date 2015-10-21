<?php

namespace TutoriaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**

 * Tutoria
 *
 * @ORM\Table(name="Tutorias")
 * @ORM\Entity()

 */
class Tutoria
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
     * @ORM\Column(name="info", type="string", length = 225, nullable=true)
     */
     private $info;


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
     * @param \UserBundle\Entity\Usuario $usuario
     * @return Tutoria
     */
    public function setUsuario(\UserBundle\Entity\Usuario $usuario)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \UserBundle\Entity\Usuario 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }
    
    /**
     * Set curso
     *
     * @param \CursoBundle\Entity\Curso $curso
     * @return Tutoria
     */
    public function setCurso(\CursoBundle\Entity\Curso $curso)
    {
        $this->curso = $curso;

        return $this;
    }

    /**
     * Get curso
     *
     * @return \CursoBundle\Entity\Curso 
     */
    public function getCurso()
    {
        return $this->curso;
    }
    
    /**
     * @param string $imageName
     */
    public function setInfo($newInfo)
    {
        $this->info = $newInfo;
    }
    
    /**
     * @return string
     */
    public function getInfo()
    {
        return $this->info;
    }
    
}
