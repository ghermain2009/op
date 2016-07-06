<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Dashboard\Model;
/**
 * Description of Cupcupon
 *
 * @author Administrador
 */
class Cupcupon {
    //put your code here
    public $id_cupon;
    public $email_cliente;
    public $id_campana;
    public $id_campana_opcion;
    public $cantidad;
    public $precio_unitario;
    public $precio_total;
    public $id_tarjeta;
    public $id_estado_compra;
    public $fecha_compra;
    public $observacion;
    public $fecha_operacion;
    public $estado_payme;
    public $brand_payme;
    public $tarjeta_payme;
    public $autorizacion_payme;
    public $error_code_payme;
    public $error_message_payme;
    
    function getId_cupon() {
        return $this->id_cupon;
    }

    function getEmail_cliente() {
        return $this->email_cliente;
    }

    function getId_campana() {
        return $this->id_campana;
    }
    
    function getId_campana_opcion() {
        return $this->id_campana_opcion;
    }

    function getCantidad() {
        return $this->cantidad;
    }

    function getPrecio_unitario() {
        return $this->precio_unitario;
    }

    function getPrecio_total() {
        return $this->precio_total;
    }

    function getId_tarjeta() {
        return $this->id_tarjeta;
    }

    function getId_estado_compra() {
        return $this->id_estado_compra;
    }
    
    function getFecha_compra() {
        return $this->fecha_compra;
    }
    
    function getObservacion() {
        return $this->observacion;
    }

    function getFecha_operacion() {
        return $this->fecha_operacion;
    }

    function getEstado_payme() {
        return $this->estado_payme;
    }

    function getBrand_payme() {
        return $this->brand_payme;
    }

    function getTarjeta_payme() {
        return $this->tarjeta_payme;
    }

    function getAutorizacion_payme() {
        return $this->autorizacion_payme;
    }

    function getError_code_payme() {
        return $this->error_code_payme;
    }

    function getError_message_payme() {
        return $this->error_message_payme;
    }

    function setId_cupon($id_cupon) {
        $this->id_cupon = $id_cupon;
    }

    function setEmail_cliente($email_cliente) {
        $this->email_cliente = $email_cliente;
    }

    function setId_campana($id_campana) {
        $this->id_campana = $id_campana;
    }
    
    function setId_campana_opcion($id_campana_opcion) {
        $this->id_campana_opcion = $id_campana_opcion;
    }

    function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }

    function setPrecio_unitario($precio_unitario) {
        $this->precio_unitario = $precio_unitario;
    }

    function setPrecio_total($precio_total) {
        $this->precio_total = $precio_total;
    }

    function setId_tarjeta($id_tarjeta) {
        $this->id_tarjeta = $id_tarjeta;
    }

    function setId_estado_compra($id_estado_compra) {
        $this->id_estado_compra = $id_estado_compra;
    }
    
    function setFecha_compra($fecha_compra) {
        $this->fecha_compra = $fecha_compra;
    }
    
    function setObservacion($observacion) {
        $this->observacion = $observacion;
    }

    function setFecha_operacion($fecha_operacion) {
        $this->fecha_operacion = $fecha_operacion;
    }

    function setEstado_payme($estado_payme) {
        $this->estado_payme = $estado_payme;
    }

    function setBrand_payme($brand_payme) {
        $this->brand_payme = $brand_payme;
    }

    function setTarjeta_payme($tarjeta_payme) {
        $this->tarjeta_payme = $tarjeta_payme;
    }

    function setAutorizacion_payme($autorizacion_payme) {
        $this->autorizacion_payme = $autorizacion_payme;
    }

    function setError_code_payme($error_code_payme) {
        $this->error_code_payme = $error_code_payme;
    }

    function setError_message_payme($error_message_payme) {
        $this->error_message_payme = $error_message_payme;
    }
    
    public function exchangeArray($data)
    {
        $this->id_cupon = (isset($data['id_cupon'])) ? $data['id_cupon'] : null;
        $this->email_cliente = (isset($data['email_cliente'])) ? $data['email_cliente'] : null;
        $this->id_campana = (isset($data['id_campana'])) ? $data['id_campana'] : null;
        $this->id_campana_opcion = (isset($data['id_campana_opcion'])) ? $data['id_campana_opcion'] : null;
        $this->cantidad = (isset($data['cantidad'])) ? $data['cantidad'] : null;
        $this->precio_unitario = (isset($data['precio_unitario'])) ? $data['precio_unitario'] : null;
        $this->precio_total = (isset($data['precio_total'])) ? $data['precio_total'] : null;
        $this->id_tarjeta = (isset($data['id_tarjeta'])) ? $data['id_tarjeta'] : null;
        $this->id_estado_compra = (isset($data['id_estado_compra'])) ? $data['id_estado_compra'] : null;
        $this->fecha_compra = (isset($data['fecha_compra'])) ? $data['fecha_compra'] : null;
        $this->observacion = (isset($data['observacion'])) ? $data['observacion'] : null;
        $this->fecha_operacion = (isset($data['fecha_operacion'])) ? $data['fecha_operacion'] : null;
        $this->estado_payme = (isset($data['estado_payme'])) ? $data['estado_payme'] : null;
        $this->brand_payme = (isset($data['brand_payme'])) ? $data['brand_payme'] : null;
        $this->tarjeta_payme = (isset($data['fecha_compra'])) ? $data['tarjeta_payme'] : null;
        $this->autorizacion_payme = (isset($data['autorizacion_payme'])) ? $data['autorizacion_payme'] : null;
        $this->error_code_payme = (isset($data['error_code_payme'])) ? $data['error_code_payme'] : null;
        $this->error_message_payme = (isset($data['error_message_payme'])) ? $data['error_message_payme'] : null;
  
    }
 
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
    
}
