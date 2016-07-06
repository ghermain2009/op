<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Dashboard\Model;
/**
 * Description of Cupcampana
 *
 * @author Administrador
 */
class Cupcampana {
    //put your code here
    public  $id_campana;
    public  $titulo;
    public  $subtitulo;
    public  $descripcion;
    public  $sobre_campana;
    public  $observaciones;
    public  $fecha_inicio;
    public  $hora_inicio;
    public  $fecha_final;
    public  $hora_final;
    public  $fecha_validez;
    public  $id_empresa;
    public  $id_user;
    public  $fecha_registro;
    public  $cantidad_cupones;
    public  $tiempo_online;
    public  $tiempo_offline;
    public  $comision_campana;
            
    function getId_campana() {
        return $this->id_campana;
    }

    function getTitulo() {
        return $this->titulo;
    }

    function getSubtitulo() {
        return $this->subtitulo;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function getSobre_campana() {
        return $this->sobre_campana;
    }

    function getObservaciones() {
        return $this->observaciones;
    }

    function getFecha_inicio() {
        return $this->fecha_inicio;
    }

    function getHora_inicio() {
        return $this->hora_inicio;
    }

    function getFecha_final() {
        return $this->fecha_final;
    }

    function getHora_final() {
        return $this->hora_final;
    }

    function getFecha_validez() {
        return $this->fecha_validez;
    }

    function getId_empresa() {
        return $this->id_empresa;
    }

    function getId_user() {
        return $this->id_user;
    }

    function getFecha_registro() {
        return $this->fecha_registro;
    }

    function getCantidad_cupones() {
        return $this->cantidad_cupones;
    }

    function getTiempo_online() {
        return $this->tiempo_online;
    }

    function getTiempo_offline() {
        return $this->tiempo_offline;
    }

    function getComision_campana() {
        return $this->comision_campana;
    }
    
    function setId_campana($id_campana) {
        $this->id_campana = $id_campana;
    }

    function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    function setSubtitulo($subtitulo) {
        $this->subtitulo = $subtitulo;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    function setSobre_campana($sobre_campana) {
        $this->sobre_campana = $sobre_campana;
    }

    function setObservaciones($observaciones) {
        $this->observaciones = $observaciones;
    }

    function setFecha_inicio($fecha_inicio) {
        $this->fecha_inicio = $fecha_inicio;
    }

    function setHora_inicio($hora_inicio) {
        $this->hora_inicio = $hora_inicio;
    }

    function setFecha_final($fecha_final) {
        $this->fecha_final = $fecha_final;
    }

    function setHora_final($hora_final) {
        $this->hora_final = $hora_final;
    }

    function setFecha_validez($fecha_validez) {
        $this->fecha_validez = $fecha_validez;
    }

    function setId_empresa($id_empresa) {
        $this->id_empresa = $id_empresa;
    }

    function setId_user($id_user) {
        $this->id_user = $id_user;
    }

    function setFecha_registro($fecha_registro) {
        $this->fecha_registro = $fecha_registro;
    }

    function setCantidad_cupones($cantidad_cupones) {
        $this->cantidad_cupones = $cantidad_cupones;
    }

    function setTiempo_online($tiempo_online) {
        $this->tiempo_online = $tiempo_online;
    }

    function setTiempo_offline($tiempo_offline) {
        $this->tiempo_offline = $tiempo_offline;
    }

    function setComision_campana($comision_campana) {
        $this->comision_campana = $comision_campana;
    }

    
    public function exchangeArray($data)
    {
        $this->id_campana = (isset($data['id_campana'])) ? $data['id_campana'] : null;
        $this->titulo = (isset($data['titulo'])) ? $data['titulo'] : null;
        $this->subtitulo = (isset($data['subtitulo'])) ? $data['subtitulo'] : null;
        $this->descripcion = (isset($data['descripcion'])) ? $data['descripcion'] : null;
        $this->sobre_campana = (isset($data['sobre_campana'])) ? $data['sobre_campana'] : null;
        $this->observaciones = (isset($data['observaciones'])) ? $data['observaciones'] : null;
        $this->fecha_inicio = (isset($data['fecha_inicio'])) ? $data['fecha_inicio'] : null;
        $this->hora_inicio = (isset($data['hora_inicio'])) ? $data['hora_inicio'] : null;
        $this->fecha_final = (isset($data['fecha_final'])) ? $data['fecha_final'] : null;
        $this->hora_final = (isset($data['hora_final'])) ? $data['hora_final'] : null;
        $this->fecha_validez = (isset($data['fecha_validez'])) ? $data['fecha_validez'] : null;
        $this->id_empresa = (isset($data['id_empresa'])) ? $data['id_empresa'] : null;
        $this->id_user = (isset($data['id_user'])) ? $data['id_user'] : null;
        $this->fecha_registro = (isset($data['fecha_registro'])) ? $data['fecha_registro'] : null;
        $this->cantidad_cupones = (isset($data['cantidad_cupones'])) ? $data['cantidad_cupones'] : null;
        $this->tiempo_online = (isset($data['tiempo_online'])) ? $data['tiempo_online'] : null;
        $this->tiempo_offline = (isset($data['tiempo_offline'])) ? $data['tiempo_offline'] : null;
        $this->comision_campana = (isset($data['comision_campana'])) ? $data['comision_campana'] : null;
        
    }
    
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

}
