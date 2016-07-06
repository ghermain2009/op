<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Dashboard\Model;
/**
 * Description of Cupopcionseleccion
 *
 * @author gtapia
 */
class Cupopcionseleccion {
    //put your code here
    public $id_opcion_seleccion;
    public $id_campana_opcion;
    public $id_campana;
    public $tipo_seleccion;
    public $dias_bloqueo;
    public $descripcion_primaria;
    public $descripcion_secundaria;
    public $valor_inicial;
    public $valor_final;
    public $incremento;
    public $utiliza_descripcion_precio;
    public $importe_seleccion;
    public $descripcion_interna;
    
    function getId_opcion_seleccion() {
        return $this->id_opcion_seleccion;
    }

    function getId_campana_opcion() {
        return $this->id_campana_opcion;
    }

    function getId_campana() {
        return $this->id_campana;
    }

    function getTipo_seleccion() {
        return $this->tipo_seleccion;
    }

    function getDias_bloqueo() {
        return $this->dias_bloqueo;
    }

    function getDescripcion_primaria() {
        return $this->descripcion_primaria;
    }

    function getDescripcion_secundaria() {
        return $this->descripcion_secundaria;
    }

    function getValor_inicial() {
        return $this->valor_inicial;
    }

    function getValor_final() {
        return $this->valor_final;
    }

    function getIncremento() {
        return $this->incremento;
    }

    function getUtiliza_descripcion_precio() {
        return $this->utiliza_descripcion_precio;
    }

    function getImporte_seleccion() {
        return $this->importe_seleccion;
    }

    function getDescripcion_interna() {
        return $this->descripcion_interna;
    }

    function setId_opcion_seleccion($id_opcion_seleccion) {
        $this->id_opcion_seleccion = $id_opcion_seleccion;
    }

    function setId_campana_opcion($id_campana_opcion) {
        $this->id_campana_opcion = $id_campana_opcion;
    }

    function setId_campana($id_campana) {
        $this->id_campana = $id_campana;
    }

    function setTipo_seleccion($tipo_seleccion) {
        $this->tipo_seleccion = $tipo_seleccion;
    }

    function setDias_bloqueo($dias_bloqueo) {
        $this->dias_bloqueo = $dias_bloqueo;
    }

    function setDescripcion_primaria($descripcion_primaria) {
        $this->descripcion_primaria = $descripcion_primaria;
    }

    function setDescripcion_secundaria($descripcion_secundaria) {
        $this->descripcion_secundaria = $descripcion_secundaria;
    }

    function setValor_inicial($valor_inicial) {
        $this->valor_inicial = $valor_inicial;
    }

    function setValor_final($valor_final) {
        $this->valor_final = $valor_final;
    }

    function setIncremento($incremento) {
        $this->incremento = $incremento;
    }

    function setUtiliza_descripcion_precio($utiliza_descripcion_precio) {
        $this->utiliza_descripcion_precio = $utiliza_descripcion_precio;
    }

    function setImporte_seleccion($importe_seleccion) {
        $this->importe_seleccion = $importe_seleccion;
    }

    function setDescripcion_interna($descripcion_interna) {
        $this->descripcion_interna = $descripcion_interna;
    }

        public function exchangeArray($data)
    {
        $this->id_opcion_seleccion = (isset($data['id_opcion_seleccion'])) ? $data['id_opcion_seleccion'] : null;
        $this->id_campana_opcion = (isset($data['id_campana_opcion'])) ? $data['id_campana_opcion'] : null;
        $this->id_campana = (isset($data['id_campana'])) ? $data['id_campana'] : null;
        $this->tipo_seleccion = (isset($data['tipo_seleccion'])) ? $data['tipo_seleccion'] : null;
        $this->dias_bloqueo = (isset($data['dias_bloqueo'])) ? $data['dias_bloqueo'] : null;
        $this->descripcion_primaria = (isset($data['descripcion_primaria'])) ? $data['descripcion_primaria'] : null;
        $this->descripcion_secundaria = (isset($data['descripcion_secundaria'])) ? $data['descripcion_secundaria'] : null;
        $this->valor_inicial = (isset($data['valor_inicial'])) ? $data['valor_inicial'] : null;
        $this->valor_final = (isset($data['valor_final'])) ? $data['valor_final'] : null;
        $this->incremento = (isset($data['incremento'])) ? $data['incremento'] : null;
        $this->utiliza_descripcion_precio = (isset($data['utiliza_descripcion_precio'])) ? $data['utiliza_descripcion_precio'] : null;
        $this->importe_seleccion = (isset($data['importe_seleccion'])) ? $data['importe_seleccion'] : null;
        $this->descripcion_interna = (isset($data['descripcion_interna'])) ? $data['descripcion_interna'] : null;
    }
    
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}