<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Dashboard\Model;
/**
 * Description of Hosvoucher
 *
 * @author Administrador
 */
class Hosvoucher {
    //put your code here
    public $id_voucher;
    public $codigo_cupon;
    public $id_hospedaje;
    public $id_categoria;
    public $fecha_ingreso;
    public $fecha_salida;
    public $numero_dias;
    public $cantidad_adultos;
    public $cantidad_ninos;
    public $cantidad_infantes;
    public $observacion;
    public $nombre_pasajero;
    public $total_habitaciones;
    public $codigo_reserva;
    public $fecha_registro;
    
    function getId_voucher() {
        return $this->id_voucher;
    }

    function getCodigo_cupon() {
        return $this->codigo_cupon;
    }

    function getId_hospedaje() {
        return $this->id_hospedaje;
    }

    function getId_categoria() {
        return $this->id_categoria;
    }

    function getFecha_ingreso() {
        return $this->fecha_ingreso;
    }

    function getFecha_salida() {
        return $this->fecha_salida;
    }

    function getNumero_dias() {
        return $this->numero_dias;
    }

    function getCantidad_adultos() {
        return $this->cantidad_adultos;
    }

    function getCantidad_ninos() {
        return $this->cantidad_ninos;
    }

    function getCantidad_infantes() {
        return $this->cantidad_infantes;
    }

    function getObservacion() {
        return $this->observacion;
    }
    
    function getNombre_pasajero() {
        return $this->nombre_pasajero;
    }

    function getTotal_habitaciones() {
        return $this->total_habitaciones;
    }

    function getCodigo_reserva() {
        return $this->codigo_reserva;
    }

    function getFecha_registro() {
        return $this->fecha_registro;
    }

    function setId_voucher($id_voucher) {
        $this->id_voucher = $id_voucher;
    }

    function setCodigo_cupon($codigo_cupon) {
        $this->codigo_cupon = $codigo_cupon;
    }

    function setId_hospedaje($id_hospedaje) {
        $this->id_hospedaje = $id_hospedaje;
    }

    function setId_categoria($id_categoria) {
        $this->id_categoria = $id_categoria;
    }

    function setFecha_ingreso($fecha_ingreso) {
        $this->fecha_ingreso = $fecha_ingreso;
    }

    function setFecha_salida($fecha_salida) {
        $this->fecha_salida = $fecha_salida;
    }

    function setNumero_dias($numero_dias) {
        $this->numero_dias = $numero_dias;
    }

    function setCantidad_adultos($cantidad_adultos) {
        $this->cantidad_adultos = $cantidad_adultos;
    }

    function setCantidad_ninos($cantidad_ninos) {
        $this->cantidad_ninos = $cantidad_ninos;
    }

    function setCantidad_infantes($cantidad_infantes) {
        $this->cantidad_infantes = $cantidad_infantes;
    }

    function setObservacion($observacion) {
        $this->observacion = $observacion;
    }

    function setNombre_pasajero($nombre_pasajero) {
        $this->nombre_pasajero = $nombre_pasajero;
    }

    function setTotal_habitaciones($total_habitaciones) {
        $this->total_habitaciones = $total_habitaciones;
    }

    function setCodigo_reserva($codigo_reserva) {
        $this->codigo_reserva = $codigo_reserva;
    }
    
    function setFecha_registro($fecha_registro) {
        $this->fecha_registro = $fecha_registro;
    }
    
    public function exchangeArray($data)
    {
        $this->id_voucher = (isset($data['id_voucher'])) ? $data['id_voucher'] : null;
        $this->codigo_cupon = (isset($data['codigo_cupon'])) ? $data['codigo_cupon'] : null;
        $this->id_hospedaje = (isset($data['id_hospedaje'])) ? $data['id_hospedaje'] : null;
        $this->id_categoria = (isset($data['id_categoria'])) ? $data['id_categoria'] : null;
        $this->fecha_ingreso = (isset($data['fecha_ingreso'])) ? $data['fecha_ingreso'] : null;
        $this->fecha_salida = (isset($data['fecha_salida'])) ? $data['fecha_salida'] : null;
        $this->numero_dias = (isset($data['numero_dias'])) ? $data['numero_dias'] : null;
        $this->cantidad_adultos = (isset($data['cantidad_adultos'])) ? $data['cantidad_adultos'] : null;
        $this->cantidad_ninos = (isset($data['cantidad_ninos'])) ? $data['cantidad_ninos'] : null;
        $this->cantidad_infantes = (isset($data['cantidad_infantes'])) ? $data['cantidad_infantes'] : null;
        $this->observacion = (isset($data['observacion'])) ? $data['observacion'] : null;
        $this->nombre_pasajero = (isset($data['nombre_pasajero'])) ? $data['nombre_pasajero'] : null;
        $this->total_habitaciones = (isset($data['total_habitaciones'])) ? $data['total_habitaciones'] : null;
        $this->codigo_reserva = (isset($data['codigo_reserva'])) ? $data['codigo_reserva'] : null;
        $this->fecha_registro = (isset($data['fecha_registro'])) ? $data['fecha_registro'] : null;
        
    }
    
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}
