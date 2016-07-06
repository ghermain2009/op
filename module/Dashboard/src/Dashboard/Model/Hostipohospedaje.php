<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Dashboard\Model;
/**
 * Description of Hostipohospedaje
 *
 * @author Administrador
 */
class Hostipohospedaje {
    //put your code here
    public $id_tipo;
    public $descripcion_tipo;
    
    function getId_tipo() {
        return $this->id_tipo;
    }

    function getDescripcion_tipo() {
        return $this->descripcion_tipo;
    }

    function setId_tipo($id_tipo) {
        $this->id_tipo = $id_tipo;
    }

    function setDescripcion_tipo($descripcion_tipo) {
        $this->descripcion_tipo = $descripcion_tipo;
    }

    public function exchangeArray($data)
    {
        $this->id_tipo = (isset($data['id_tipo'])) ? $data['id_tipo'] : null;
        $this->descripcion_tipo = (isset($data['descripcion_tipo'])) ? $data['descripcion_tipo'] : null;
    }
 
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

}
