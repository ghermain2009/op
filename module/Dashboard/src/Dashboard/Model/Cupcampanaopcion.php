<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Dashboard\Model;
/**
 * Description of Cupcampanaopcion
 *
 * @author Administrador
 */
class Cupcampanaopcion {
    //put your code here
    public $id_campana_opcion;
    public $descripcion;
    public $precio_regular;
    public $precio_especial;
    public $cantidad;
    public $vendidos;
    public $id_campana;
    public $comision;
            
    function getId_campana_opcion() {
        return $this->id_campana_opcion;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function getPrecio_regular() {
        return $this->precio_regular;
    }

    function getPrecio_especial() {
        return $this->precio_especial;
    }

    function getCantidad() {
        return $this->cantidad;
    }

    function getVendidos() {
        return $this->vendidos;
    }

    function getId_campana() {
        return $this->id_campana;
    }
    
    function getComision() {
        return $this->comision;
    }
    
    function setId_campana_opcion($id_campana_opcion) {
        $this->id_campana_opcion = $id_campana_opcion;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    function setPrecio_regular($precio_regular) {
        $this->precio_regular = $precio_regular;
    }

    function setPrecio_especial($precio_especial) {
        $this->precio_especial = $precio_especial;
    }

    function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }

    function setVendidos($vendidos) {
        $this->vendidos = $vendidos;
    }

    function setId_campana($id_campana) {
        $this->id_campana = $id_campana;
    }
    
    function setComision($comision) {
        $this->comision = $comision;
    }
    
    public function exchangeArray($data)
    {
           
        $this->id_campana_opcion = (isset($data['id_campana_opcion'])) ? $data['id_campana_opcion'] : null;
        $this->descripcion = (isset($data['descripcion'])) ? $data['descripcion'] : null;
        $this->precio_regular = (isset($data['precio_regular'])) ? $data['precio_regular'] : null;
        $this->precio_especial = (isset($data['precio_especial'])) ? $data['precio_especial'] : null;
        $this->cantidad = (isset($data['cantidad'])) ? $data['cantidad'] : null;
        $this->vendidos = (isset($data['vendidos'])) ? $data['vendidos'] : null;
        $this->id_campana = (isset($data['id_campana'])) ? $data['id_campana'] : null;
        $this->comision = (isset($data['comision'])) ? $data['comision'] : null;
        
    }
 
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
    
}
