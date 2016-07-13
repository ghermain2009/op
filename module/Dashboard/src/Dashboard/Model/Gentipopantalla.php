<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Dashboard\Model;
/**
 * Description of Gentipopantalla
 *
 * @author Administrador
 */
class Gentipopantalla {
    //put your code here
    public $id_tipo_pantalla;
    public $descripcion_pantalla;
    
    function getId_tipo_pantalla() {
        return $this->id_tipo_pantalla;
    }

    function getDescripcion_pantalla() {
        return $this->descripcion_pantalla;
    }

    function setId_tipo_pantalla($id_tipo_pantalla) {
        $this->id_tipo_pantalla = $id_tipo_pantalla;
    }

    function setDescripcion_pantalla($descripcion_pantalla) {
        $this->descripcion_pantalla = $descripcion_pantalla;
    }

    public function exchangeArray($data)
    {
        $this->id_tipo_pantalla = (isset($data['id_tipo_pantalla'])) ? $data['id_tipo_pantalla'] : null;
        $this->descripcion_pantalla = (isset($data['descripcion_pantalla'])) ? $data['descripcion_pantalla'] : null;
    }
 
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}
