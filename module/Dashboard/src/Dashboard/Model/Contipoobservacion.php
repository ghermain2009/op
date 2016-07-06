<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Dashboard\Model;
/**
 * Description of Contipoobservacion
 *
 * @author gtapia
 */
class Contipoobservacion {
    //put your code here
    public $id_tipo_observacion;
    public $descripcion;
    
    public function getId_tipo_observacion() {
        return $this->id_tipo_observacion;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setId_tipo_observacion($id_tipo_observacion) {
        $this->id_tipo_observacion = $id_tipo_observacion;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function exchangeArray($data)
    {
        $this->id_tipo_observacion = (isset($data['id_tipo_observacion'])) ? $data['id_tipo_observacion'] : null;
        $this->descripcion = (isset($data['descripcion'])) ? $data['descripcion'] : null;
    }
 
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
    
}
