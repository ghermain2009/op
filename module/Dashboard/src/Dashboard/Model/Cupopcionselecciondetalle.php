<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Dashboard\Model;

/**
 * Description of Cupopcionselecciondetalle
 *
 * @author gtapia
 */
class Cupopcionselecciondetalle {
    //put your code here
    public $id_opcion_seleccion_detalle;
    public $id_opcion_seleccion;
    public $cantidad_seleccion;
    public $importe_seleccion;
    
    function getId_opcion_seleccion_detalle() {
        return $this->id_opcion_seleccion_detalle;
    }

    function getId_opcion_seleccion() {
        return $this->id_opcion_seleccion;
    }

    function getCantidad_seleccion() {
        return $this->cantidad_seleccion;
    }

    function getImporte_seleccion() {
        return $this->importe_seleccion;
    }

    function setId_opcion_seleccion_detalle($id_opcion_seleccion_detalle) {
        $this->id_opcion_seleccion_detalle = $id_opcion_seleccion_detalle;
    }

    function setId_opcion_seleccion($id_opcion_seleccion) {
        $this->id_opcion_seleccion = $id_opcion_seleccion;
    }

    function setCantidad_seleccion($cantidad_seleccion) {
        $this->cantidad_seleccion = $cantidad_seleccion;
    }

    function setImporte_seleccion($importe_seleccion) {
        $this->importe_seleccion = $importe_seleccion;
    }

    public function exchangeArray($data)
    {
        $this->id_opcion_seleccion_detalle = (isset($data['id_opcion_seleccion_detalle'])) ? $data['id_opcion_seleccion_detalle'] : null;
        $this->id_opcion_seleccion = (isset($data['id_opcion_seleccion'])) ? $data['id_opcion_seleccion'] : null;
        $this->cantidad_seleccion = (isset($data['cantidad_seleccion'])) ? $data['cantidad_seleccion'] : null;
        $this->importe_seleccion = (isset($data['importe_seleccion'])) ? $data['tipo_seleccion'] : null;
    }
    
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
    
}
