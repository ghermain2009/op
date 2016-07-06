<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Dashboard\Model;
/**
 * Description of Conestadocontrato
 *
 * @author gtapia
 */
class Conestadocontrato {
    //put your code here
    public $id_estado;
    public $descripcion;
    
    public function getId_estado() {
        return $this->id_estado;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setId_estado($id_estado) {
        $this->id_estado = $id_estado;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function exchangeArray($data)
    {
        $this->id_estado = (isset($data['id_estado'])) ? $data['id_estado'] : null;
        $this->descripcion = (isset($data['descripcion'])) ? $data['descripcion'] : null;
    }
 
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

}
