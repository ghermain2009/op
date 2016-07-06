<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Dashboard\Model;
/**
 * Description of Cupliquidacion
 *
 * @author gtapia
 */
class Cupliquidacion {
    //put your code here
    public $id_liquidacion;
    public $fecha_liquidacion;
    public $cantidad_cupones;
    public $total_importe;
    public $comision;
    public $impuesto;
    public $total_liquidacion;
    public $id_campana;
    
    public function getId_liquidacion() {
        return $this->id_liquidacion;
    }

    public function getFecha_liquidacion() {
        return $this->fecha_liquidacion;
    }

    public function getCantidad_cupones() {
        return $this->cantidad_cupones;
    }

    public function getTotal_importe() {
        return $this->total_importe;
    }

    public function getComision() {
        return $this->comision;
    }

    public function getImpuesto() {
        return $this->impuesto;
    }

    public function getTotal_liquidacion() {
        return $this->total_liquidacion;
    }

    public function getId_campana() {
        return $this->id_campana;
    }

    public function setId_liquidacion($id_liquidacion) {
        $this->id_liquidacion = $id_liquidacion;
    }

    public function setFecha_liquidacion($fecha_liquidacion) {
        $this->fecha_liquidacion = $fecha_liquidacion;
    }

    public function setCantidad_cupones($cantidad_cupones) {
        $this->cantidad_cupones = $cantidad_cupones;
    }

    public function setTotal_importe($total_importe) {
        $this->total_importe = $total_importe;
    }

    public function setComision($comision) {
        $this->comision = $comision;
    }

    public function setImpuesto($impuesto) {
        $this->impuesto = $impuesto;
    }

    public function setTotal_liquidacion($total_liquidacion) {
        $this->total_liquidacion = $total_liquidacion;
    }

    public function setId_campana($id_campana) {
        $this->id_campana = $id_campana;
    }

    
    public function exchangeArray($data)
    {
        $this->id_liquidacion = (isset($data['id_liquidacion'])) ? $data['id_liquidacion'] : null;
        $this->fecha_liquidacion = (isset($data['fecha_liquidacion'])) ? $data['fecha_liquidacion'] : null;
        $this->cantidad_cupones = (isset($data['cantidad_cupones'])) ? $data['cantidad_cupones'] : null;
        $this->total_importe = (isset($data['total_importe'])) ? $data['total_importe'] : null;
        $this->comision = (isset($data['comision'])) ? $data['comision'] : null;
        $this->impuesto = (isset($data['$impuesto'])) ? $data['$impuesto'] : null;
        $this->total_liquidacion = (isset($data['total_liquidacion'])) ? $data['total_liquidacion'] : null;
        $this->id_campana = (isset($data['id_campana'])) ? $data['id_campana'] : null;
    }
    
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
    
    
}
