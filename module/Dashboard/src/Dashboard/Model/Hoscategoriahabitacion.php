<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Dashboard\Model;
/**
 * Description of Hoscategoriahabitacion
 *
 * @author Administrador
 */
class Hoscategoriahabitacion {
    //put your code here
    public $id_categoria;
    public $descripcion_categoria;
    public $personas_categoria;
    
    function getId_categoria() {
        return $this->id_categoria;
    }

    function getDescripcion_categoria() {
        return $this->descripcion_categoria;
    }

    function getPersonas_categoria() {
        return $this->personas_categoria;
    }

    function setId_categoria($id_categoria) {
        $this->id_categoria = $id_categoria;
    }

    function setDescripcion_categoria($descripcion_categoria) {
        $this->descripcion_categoria = $descripcion_categoria;
    }

    function setPersonas_categoria($personas_categoria) {
        $this->personas_categoria = $personas_categoria;
    }

    public function exchangeArray($data)
    {
        $this->id_categoria = (isset($data['id_categoria'])) ? $data['id_categoria'] : null;
        $this->descripcion_categoria = (isset($data['descripcion_categoria'])) ? $data['descripcion_categoria'] : null;
        $this->personas_categoria = (isset($data['personas_categoria'])) ? $data['personas_categoria'] : null;
    }
 
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}
