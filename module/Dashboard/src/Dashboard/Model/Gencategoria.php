<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Dashboard\Model;
/**
 * Description of Gencategoria
 *
 * @author Administrador
 */
class Gencategoria {
    //put your code here
    public $id_categoria;
    public $descripcion;
    
    function getId_categoria() {
        return $this->id_categoria;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function setId_categoria($id_categoria) {
        $this->id_categoria = $id_categoria;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function exchangeArray($data)
    {
        $this->id_categoria = (isset($data['id_categoria'])) ? $data['id_categoria'] : null;
        $this->descripcion = (isset($data['descripcion'])) ? $data['descripcion'] : null;
    }
 
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
    
}
