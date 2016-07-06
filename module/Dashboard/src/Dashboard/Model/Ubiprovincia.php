<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Dashboard\Model;
/**
 * Description of Ubiprovincia
 *
 * @author gtapia
 */
class Ubiprovincia {
    //put your code here
    public $id_pais;
    public $id_departamento;
    public $id_provincia;
    public $descripcion;
    
    public function getId_pais() {
        return $this->id_pais;
    }

    public function getId_departamento() {
        return $this->id_departamento;
    }

    public function getId_provincia() {
        return $this->id_provincia;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setId_pais($id_pais) {
        $this->id_pais = $id_pais;
    }

    public function setId_departamento($id_departamento) {
        $this->id_departamento = $id_departamento;
    }

    public function setId_provincia($id_provincia) {
        $this->id_provincia = $id_provincia;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function exchangeArray($data)
    {
        $this->id_pais = (isset($data['id_pais'])) ? $data['id_pais'] : null;
        $this->id_departamento = (isset($data['id_departamento'])) ? $data['id_departamento'] : null;
        $this->id_provincia = (isset($data['id_provincia'])) ? $data['id_provincia'] : null;
        $this->descripcion = (isset($data['descripcion'])) ? $data['descripcion'] : null;
        
    }
 
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}
