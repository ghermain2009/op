<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Dashboard\Model;

/**
 * Description of Cupcuponcarrito
 *
 * @author gtapia
 */
class Cupcuponcarrito {
    //put your code here
    public $id_cupon_carrito;
    public $cantidad_carito;
    public $precio_total;
    public $id_tarjeta;
    public $id_estado_compra;
    public $fecha_registro;
    public $fecha_compra;
    public $id_empresa;
    public $user_id;
    
    function getId_cupon_carrito() {
        return $this->id_cupon_carrito;
    }

    function getCantidad_carito() {
        return $this->cantidad_carito;
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

    function getFecha_registro() {
        return $this->fecha_registro;
    }

    function getFecha_compra() {
        return $this->fecha_compra;
    }

    function getId_empresa() {
        return $this->id_empresa;
    }

    function getUser_id() {
        return $this->user_id;
    }

    function setId_cupon_carrito($id_cupon_carrito) {
        $this->id_cupon_carrito = $id_cupon_carrito;
    }

    function setCantidad_carito($cantidad_carito) {
        $this->cantidad_carito = $cantidad_carito;
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

    function setFecha_registro($fecha_registro) {
        $this->fecha_registro = $fecha_registro;
    }

    function setFecha_compra($fecha_compra) {
        $this->fecha_compra = $fecha_compra;
    }

    function setId_empresa($id_empresa) {
        $this->id_empresa = $id_empresa;
    }

    function setUser_id($user_id) {
        $this->user_id = $user_id;
    }

    public function exchangeArray($data)
    {
        $this->id_cupon_carrito = (isset($data['id_cupon_carrito'])) ? $data['id_cupon_carrito'] : null;
        $this->cantidad_carito = (isset($data['cantidad_carito'])) ? $data['cantidad_carito'] : null;
        $this->precio_total = (isset($data['precio_total'])) ? $data['precio_total'] : null;
        $this->id_tarjeta = (isset($data['id_tarjeta'])) ? $data['id_tarjeta'] : null;
        $this->id_estado_compra = (isset($data['id_estado_compra'])) ? $data['id_estado_compra'] : null;
        $this->fecha_registro = (isset($data['fecha_registro'])) ? $data['fecha_registro'] : null;
        $this->fecha_compra = (isset($data['fecha_compra'])) ? $data['fecha_compra'] : null;
        $this->id_empresa = (isset($data['id_empresa'])) ? $data['id_empresa'] : null;
        $this->user_id = (isset($data['user_id'])) ? $data['user_id'] : null;
    }
 
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
    
}
