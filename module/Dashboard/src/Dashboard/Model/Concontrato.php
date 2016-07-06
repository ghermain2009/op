<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Dashboard\Model;
/**
 * Description of Concontrato
 *
 * @author gtapia
 */
class Concontrato {
    //put your code here
    public $id_contrato;
    public $id_empresa;
    public $nombre_contacto;
    public $email_contacto;
    public $fecha_registro;
    public $nombre_documento;
    public $firma_documento;
    public $fecha_firma;
    public $id_estado;
    
    public function getId_contrato() {
        return $this->id_contrato;
    }

    public function getId_empresa() {
        return $this->id_empresa;
    }

    public function getNombre_contacto() {
        return $this->nombre_contacto;
    }

    public function getEmail_contacto() {
        return $this->email_contacto;
    }

    public function getFecha_registro() {
        return $this->fecha_registro;
    }

    public function getNombre_documento() {
        return $this->nombre_documento;
    }

    public function getFirma_documento() {
        return $this->firma_documento;
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

    public function setId_empresa($id_empresa) {
        $this->id_empresa = $id_empresa;
    }

    public function setNombre_contacto($nombre_contacto) {
        $this->nombre_contacto = $nombre_contacto;
    }

    public function setEmail_contacto($email_contacto) {
        $this->email_contacto = $email_contacto;
    }

    public function setFecha_registro($fecha_registro) {
        $this->fecha_registro = $fecha_registro;
    }

    public function setNombre_documento($nombre_documento) {
        $this->nombre_documento = $nombre_documento;
    }

    public function setFirma_documento($firma_documento) {
        $this->firma_documento = $firma_documento;
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
        $this->id_empresa = (isset($data['id_empresa'])) ? $data['id_empresa'] : null;
        $this->nombre_contacto = (isset($data['nombre_contacto'])) ? $data['nombre_contacto'] : null;
        $this->email_contacto = (isset($data['email_contacto'])) ? $data['email_contacto'] : null;
        $this->fecha_registro = (isset($data['fecha_registro'])) ? $data['fecha_registro'] : null;
        $this->nombre_documento = (isset($data['nombre_documento'])) ? $data['nombre_documento'] : null;
        $this->firma_documento = (isset($data['firma_documento'])) ? $data['firma_documento'] : null;
        $this->fecha_firma = (isset($data['fecha_firma'])) ? $data['fecha_firma'] : null;
        $this->id_estado = (isset($data['id_estado'])) ? $data['id_estado'] : null;
    }
 
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }


    
}
