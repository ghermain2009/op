<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Dashboard\Model;
/**
 * Description of Concontratoanexo
 *
 * @author gtapia
 */
class Concontratoanexo {
    //put your code here
    public $id_contrato;
    public $id_campana;
    public $nombre_documento;
    public $fecha_registro;
    public $firma;
    public $fecha_firma;
    public $id_estado;
   
    public function getId_contrato() {
        return $this->id_contrato;
    }

    public function getId_campana() {
        return $this->id_campana;
    }

    public function getNombre_documento() {
        return $this->nombre_documento;
    }

    public function getFecha_registro() {
        return $this->fecha_registro;
    }

    public function getFirma() {
        return $this->firma;
    }

    public function getFecha_firma() {
        return $this->fecha_firma;
    }

    public function getId_estado() {
        return $this->id_estado;
    }

    public function setId_contrato($id_contrato) {
        $this->id_contrato = $id_contrato;
    }

    public function setId_campana($id_campana) {
        $this->id_campana = $id_campana;
    }

    public function setNombre_documento($nombre_documento) {
        $this->nombre_documento = $nombre_documento;
    }

    public function setFecha_registro($fecha_registro) {
        $this->fecha_registro = $fecha_registro;
    }

    public function setFirma($firma) {
        $this->firma = $firma;
    }

    public function setFecha_firma($fecha_firma) {
        $this->fecha_firma = $fecha_firma;
    }

    public function setId_estado($id_estado) {
        $this->id_estado = $id_estado;
    }

    public function exchangeArray($data)
    {
        $this->id_contrato = (isset($data['id_contrato'])) ? $data['id_contrato'] : null;
        $this->id_campana = (isset($data['id_campana'])) ? $data['id_campana'] : null;
        $this->nombre_documento = (isset($data['nombre_documento'])) ? $data['nombre_documento'] : null;
        $this->fecha_registro = (isset($data['fecha_registro'])) ? $data['fecha_registro'] : null;
        $this->firma = (isset($data['firma'])) ? $data['firma'] : null;
        $this->fecha_firma = (isset($data['fecha_firma'])) ? $data['fecha_firma'] : null;
        $this->id_estado = (isset($data['id_estado'])) ? $data['id_estado'] : null;
    }
 
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}
