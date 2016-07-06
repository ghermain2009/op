<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Dashboard\Model;
/**
 * Description of Ubipais
 *
 * @author Administrador
 */
class Ubipais {
    //put your code here
    public $id_pais;
    public $descripcion;
    
    function getId_pais() {
        return $this->id_pais;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function setId_pais($id_pais) {
        $this->id_pais = $id_pais;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function exchangeArray($data)
    {
        $this->id_pais = (isset($data['id_pais'])) ? $data['id_pais'] : null;
        $this->descripcion = (isset($data['descripcion'])) ? $data['descripcion'] : null;
        
    }
 
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}
