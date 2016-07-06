<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Dashboard\Model;
/**
 * Description of Genempresa
 *
 * @author gtapia
 */
class Genempresa {
    //put your code here
    public $id_empresa;
    public $razon_social;
    public $registro_contribuyente;
    public $direccion_facturacion;
    public $direcciion_comercial;
    public $telefono;
    public $horario;
    public $web_site;
    public $ubicacion_gps;
    public $descripcion;
    public $tipo_documento_representante;
    public $documento_representante;
    public $nombre_representante;
    public $rubro;
    public $id_operador;
    
    public $nombre_comercial;
    public $persona_contacto;
    public $email_contacto;
    public $titular_cuenta;
    public $ruc_titular;
    public $numero_cuenta;
    public $tipo_cuenta;
    public $email_facturacion;
    public $banco_cuenta;
    
    function getId_empresa() {
        return $this->id_empresa;
    }

    function getRazon_social() {
        return $this->razon_social;
    }

    function getRegistro_contribuyente() {
        return $this->registro_contribuyente;
    }

    function getDireccion_facturacion() {
        return $this->direccion_facturacion;
    }

    function getDirecciion_comercial() {
        return $this->direcciion_comercial;
    }

    function getTelefono() {
        return $this->telefono;
    }

    function getHorario() {
        return $this->horario;
    }

    function getWeb_site() {
        return $this->web_site;
    }

    function getUbicacion_gps() {
        return $this->ubicacion_gps;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function getTipo_documento_representante() {
        return $this->tipo_documento_representante;
    }

    function getDocumento_representante() {
        return $this->documento_representante;
    }

    function getNombre_representante() {
        return $this->nombre_representante;
    }

    function getRubro() {
        return $this->rubro;
    }

    function getId_operador() {
        return $this->id_operador;
    }

    function getNombre_comercial() {
        return $this->nombre_comercial;
    }

    function getPersona_contacto() {
        return $this->persona_contacto;
    }

    function getEmail_contacto() {
        return $this->email_contacto;
    }

    function getTitular_cuenta() {
        return $this->titular_cuenta;
    }

    function getRuc_titular() {
        return $this->ruc_titular;
    }

    function getNumero_cuenta() {
        return $this->numero_cuenta;
    }

    function getTipo_cuenta() {
        return $this->tipo_cuenta;
    }

    function getEmail_facturacion() {
        return $this->email_facturacion;
    }

    function getBanco_cuenta() {
        return $this->banco_cuenta;
    }

    function setId_empresa($id_empresa) {
        $this->id_empresa = $id_empresa;
    }

    function setRazon_social($razon_social) {
        $this->razon_social = $razon_social;
    }

    function setRegistro_contribuyente($registro_contribuyente) {
        $this->registro_contribuyente = $registro_contribuyente;
    }

    function setDireccion_facturacion($direccion_facturacion) {
        $this->direccion_facturacion = $direccion_facturacion;
    }

    function setDirecciion_comercial($direcciion_comercial) {
        $this->direcciion_comercial = $direcciion_comercial;
    }

    function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    function setHorario($horario) {
        $this->horario = $horario;
    }

    function setWeb_site($web_site) {
        $this->web_site = $web_site;
    }

    function setUbicacion_gps($ubicacion_gps) {
        $this->ubicacion_gps = $ubicacion_gps;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    function setTipo_documento_representante($tipo_documento_representante) {
        $this->tipo_documento_representante = $tipo_documento_representante;
    }

    function setDocumento_representante($documento_representante) {
        $this->documento_representante = $documento_representante;
    }

    function setNombre_representante($nombre_representante) {
        $this->nombre_representante = $nombre_representante;
    }

    function setRubro($rubro) {
        $this->rubro = $rubro;
    }

    function setId_operador($id_operador) {
        $this->id_operador = $id_operador;
    }

    function setNombre_comercial($nombre_comercial) {
        $this->nombre_comercial = $nombre_comercial;
    }

    function setPersona_contacto($persona_contacto) {
        $this->persona_contacto = $persona_contacto;
    }

    function setEmail_contacto($email_contacto) {
        $this->email_contacto = $email_contacto;
    }

    function setTitular_cuenta($titular_cuenta) {
        $this->titular_cuenta = $titular_cuenta;
    }

    function setRuc_titular($ruc_titular) {
        $this->ruc_titular = $ruc_titular;
    }

    function setNumero_cuenta($numero_cuenta) {
        $this->numero_cuenta = $numero_cuenta;
    }

    function setTipo_cuenta($tipo_cuenta) {
        $this->tipo_cuenta = $tipo_cuenta;
    }

    function setEmail_facturacion($email_facturacion) {
        $this->email_facturacion = $email_facturacion;
    }

    function setBanco_cuenta($banco_cuenta) {
        $this->banco_cuenta = $banco_cuenta;
    }

        
    public function exchangeArray($data)
    {
        $this->id_empresa = (isset($data['id_empresa'])) ? $data['id_empresa'] : null;
        $this->razon_social = (isset($data['razon_social'])) ? $data['razon_social'] : null;
        $this->registro_contribuyente = (isset($data['registro_contribuyente'])) ? $data['registro_contribuyente'] : null;
        $this->direccion_facturacion = (isset($data['direccion_facturacion'])) ? $data['direccion_facturacion'] : null;
        $this->direccion_comercial = (isset($data['direccion_comercial'])) ? $data['direccion_comercial'] : null;
        $this->telefono = (isset($data['telefono'])) ? $data['telefono'] : null;
        $this->horario = (isset($data['horario'])) ? $data['horario'] : null;
        $this->web_site = (isset($data['web_site'])) ? $data['web_site'] : null;
        $this->ubicacion_gps = (isset($data['ubicacion_gps'])) ? $data['ubicacion_gps'] : null;
        $this->descripcion = (isset($data['descripcion'])) ? $data['descripcion'] : null;
        $this->tipo_documento_representante = (isset($data['tipo_documento_representante'])) ? $data['tipo_documento_representante'] : null;
        $this->documento_representante = (isset($data['documento_representante'])) ? $data['documento_representante'] : null;
        $this->nombre_representante = (isset($data['nombre_representante'])) ? $data['nombre_representante'] : null;
        $this->rubro = (isset($data['rubro'])) ? $data['rubro'] : null;
        $this->id_operador = (isset($data['id_operador'])) ? $data['id_operador'] : null;
        
        $this->nombre_comercial = (isset($data['nombre_comercial'])) ? $data['nombre_comercial'] : null;
        $this->persona_contacto = (isset($data['persona_contacto'])) ? $data['persona_contacto'] : null;
        $this->email_contacto = (isset($data['email_contacto'])) ? $data['email_contacto'] : null;
        $this->titular_cuenta = (isset($data['titular_cuenta'])) ? $data['titular_cuenta'] : null;
        $this->ruc_titular = (isset($data['ruc_titular'])) ? $data['ruc_titular'] : null;
        $this->numero_cuenta = (isset($data['numero_cuenta'])) ? $data['numero_cuenta'] : null;
        $this->tipo_cuenta = (isset($data['tipo_cuenta'])) ? $data['tipo_cuenta'] : null;
        $this->email_facturacion = (isset($data['email_facturacion'])) ? $data['email_facturacion'] : null;
        $this->banco_cuenta = (isset($data['banco_cuenta'])) ? $data['banco_cuenta'] : null;
        
    }
 
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }


}
