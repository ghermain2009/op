<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Dashboard\Model;
/**
 * Description of Hoshospedaje
 *
 * @author Administrador
 */
class Hoshospedaje {
    //put your code here
    public $id_hospedaje;
    public $id_tipo;
    public $id_pais;
    public $id_departamento;
    public $descripcion_hospedaje;
    public $categoria_hospedaje;
    public $direccion_hospedaje;
    public $telefono_hospedaje;     
    public $observacion;
    public $email_confirmacion;
    
    function getId_hospedaje() {
        return $this->id_hospedaje;
    }

    function getId_tipo() {
        return $this->id_tipo;
    }

    function getId_pais() {
        return $this->id_pais;
    }

    function getId_departamento() {
        return $this->id_departamento;
    }

    function getDescripcion_hospedaje() {
        return $this->descripcion_hospedaje;
    }

    function getCategoria_hospedaje() {
        return $this->categoria_hospedaje;
    }

    function getDireccion_hospedaje() {
        return $this->direccion_hospedaje;
    }

    function getTelefono_hospedaje() {
        return $this->telefono_hospedaje;
    }
    
    function getObservacion() {
        return $this->observacion;
    }
    
    function getEmail_confirmacion() {
        return $this->email_confirmacion;
    }

    function setId_hospedaje($id_hospedaje) {
        $this->id_hospedaje = $id_hospedaje;
    }

    function setId_tipo($id_tipo) {
        $this->id_tipo = $id_tipo;
    }

    function setId_pais($id_pais) {
        $this->id_pais = $id_pais;
    }

    function setId_departamento($id_departamento) {
        $this->id_departamento = $id_departamento;
    }

    function setDescripcion_hospedaje($descripcion_hospedaje) {
        $this->descripcion_hospedaje = $descripcion_hospedaje;
    }

    function setCategoria_hospedaje($categoria_hospedaje) {
        $this->categoria_hospedaje = $categoria_hospedaje;
    }

    function setDireccion_hospedaje($direccion_hospedaje) {
        $this->direccion_hospedaje = $direccion_hospedaje;
    }

    function setTelefono_hospedaje($telefono_hospedaje) {
        $this->telefono_hospedaje = $telefono_hospedaje;
    }
    
    function setObservacion($observacion) {
        $this->observacion = $observacion;
    }
    
    function setEmail_confirmacion($email_confirmacion) {
        $this->email_confirmacion = $email_confirmacion;
    }

    public function exchangeArray($data)
    {
        $this->id_hospedaje = (isset($data['id_hospedaje'])) ? $data['id_hospedaje'] : null;
        $this->id_tipo = (isset($data['id_tipo'])) ? $data['id_tipo'] : null;
        $this->id_pais = (isset($data['id_pais'])) ? $data['id_pais'] : null;
        $this->id_departamento = (isset($data['id_departamento'])) ? $data['id_departamento'] : null;
        $this->descripcion_hospedaje = (isset($data['descripcion_hospedaje'])) ? $data['descripcion_hospedaje'] : null;
        $this->categoria_hospedaje = (isset($data['categoria_hospedaje'])) ? $data['categoria_hospedaje'] : null;
        $this->direccion_hospedaje = (isset($data['direccion_hospedaje'])) ? $data['direccion_hospedaje'] : null;
        $this->telefono_hospedaje = (isset($data['telefono_hospedaje'])) ? $data['telefono_hospedaje'] : null;
        $this->observacion = (isset($data['observacion'])) ? $data['observacion'] : null;
        $this->observacion = (isset($data['email_confirmacion'])) ? $data['email_confirmacion'] : null;
    }
 
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}
