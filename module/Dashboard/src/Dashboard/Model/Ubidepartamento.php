<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Dashboard\Model;
/**
 * Description of Ubidepartamento
 *
 * @author Administrador
 */
class Ubidepartamento {
    //put your code here
    public $id_pais;
    public $id_departamento;
    public $descripcion;
    
    function getId_pais() {
        return $this->id_pais;
    }

    function getId_departamento() {
        return $this->id_departamento;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function setId_pais($id_pais) {
        $this->id_pais = $id_pais;
    }

    function setId_departamento($id_departamento) {
        $this->id_departamento = $id_departamento;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function exchangeArray($data)
    {
        $this->id_pais = (isset($data['id_pais'])) ? $data['id_pais'] : null;
        $this->id_departamento = (isset($data['id_departamento'])) ? $data['id_departamento'] : null;
        $this->descripcion = (isset($data['descripcion'])) ? $data['descripcion'] : null;
        
    }
 
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
    
}
