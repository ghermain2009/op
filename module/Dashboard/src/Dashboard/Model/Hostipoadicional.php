<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Dashboard\Model;
/**
 * Description of Hostipoadicional
 *
 * @author Administrador
 */
class Hostipoadicional {
    //put your code here
    public $id_tipo_adicional;
    public $descripcion_tipo_adicional;
    
    function getId_tipo_adicional() {
        return $this->id_tipo_adicional;
    }

    function getDescripcion_tipo_adicional() {
        return $this->descripcion_tipo_adicional;
    }

    function setId_tipo_adicional($id_tipo_adicional) {
        $this->id_tipo_adicional = $id_tipo_adicional;
    }

    function setDescripcion_tipo_adicional($descripcion_tipo_adicional) {
        $this->descripcion_tipo_adicional = $descripcion_tipo_adicional;
    }

    public function exchangeArray($data)
    {
        $this->id_tipo_adicional = (isset($data['id_tipo_adicional'])) ? $data['id_tipo_adicional'] : null;
        $this->descripcion_tipo_adicional = (isset($data['descripcion_tipo_adicional'])) ? $data['descripcion_tipo_adicional'] : null;
    }
 
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}
