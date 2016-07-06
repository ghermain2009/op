<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Dashboard\Model;
/**
 * Description of Gentipodocumento
 *
 * @author Administrador
 */
class Gentipodocumento {
    //put your code here
    public $id_tipo_documento;
    public $descripcion;
    
    function getId_tipo_documento() {
        return $this->id_tipo_documento;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function setId_tipo_documento($id_tipo_documento) {
        $this->id_tipo_documento = $id_tipo_documento;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function exchangeArray($data)
    {
        $this->id_tipo_documento = (isset($data['id_tipo_documento'])) ? $data['id_tipo_documento'] : null;
        $this->descripcion = (isset($data['descripcion'])) ? $data['descripcion'] : null;
    }
 
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}
