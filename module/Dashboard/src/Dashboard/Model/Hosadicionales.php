<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Dashboard\Model;
/**
 * Description of Hosadicionales
 *
 * @author Administrador
 */
class Hosadicionales {
    //put your code here
    public $id_adicionales;
    public $id_tipo_adicional;
    public $descripcion_adicionales;
    public $icono_adicional;
    
    function getId_adicionales() {
        return $this->id_adicionales;
    }

    function getId_tipo_adicional() {
        return $this->id_tipo_adicional;
    }

    function getDescripcion_adicionales() {
        return $this->descripcion_adicionales;
    }

    function getIcono_adicional() {
        return $this->icono_adicional;
    }

    function setId_adicionales($id_adicionales) {
        $this->id_adicionales = $id_adicionales;
    }

    function setId_tipo_adicional($id_tipo_adicional) {
        $this->id_tipo_adicional = $id_tipo_adicional;
    }

    function setDescripcion_adicionales($descripcion_adicionales) {
        $this->descripcion_adicionales = $descripcion_adicionales;
    }

    function setIcono_adicional($icono_adicional) {
        $this->icono_adicional = $icono_adicional;
    }

    public function exchangeArray($data)
    {
        $this->id_adicionales = (isset($data['id_adicionales'])) ? $data['id_adicionales'] : null;
        $this->id_tipo_adicional = (isset($data['id_tipo_adicional'])) ? $data['id_tipo_adicional'] : null;
        $this->descripcion_adicionales = (isset($data['descripcion_adicionales'])) ? $data['descripcion_adicionales'] : null;
        $this->icono_adicional = (isset($data['icono_adicional'])) ? $data['icono_adicional'] : null;
    }
 
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}
