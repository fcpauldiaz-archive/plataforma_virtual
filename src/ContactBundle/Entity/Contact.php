<?php

namespace ContactBundle\Entity;

class Contact
{
    private $nombreCompleto;
    private $correo;
    private $asunto;
    private $mensaje;

    public function getNombreCompleto()
    {
        return $this->nombreCompleto;
    }
    public function setNombreCompleto($nombreCompleto)
    {
        $this->nombreCompleto = $nombreCompleto;
    }

    public function getCorreo()
    {
        return $this->correo;
    }

    public function setCorreo($correo)
    {
        $this->correo = $correo;
    }

    public function getAsunto()
    {
        return $this->asunto;
    }

    public function setAsunto($asunto)
    {
        $this->asunto = $asunto;
    }

    public function getMensaje()
    {
        return $this->mensaje;
    }

    public function setMensaje($mensaje)
    {
        $this->mensaje = $mensaje;
    }
}
