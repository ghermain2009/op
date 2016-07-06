<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Dashboard\Model;
/**
 * Description of Hoshospedajecategoria
 *
 * @author Administrador
 */
class Hoshospedajecategoria {
    //put your code here
    public $id_hospedaje;
    public $id_categoria;
    public $importe_habitacion;
    
    function getId_hospedaje() {
        return $this->id_hospedaje;
    }

    function getId_categoria() {
        return $this->id_categoria;
    }

    function getImporte_habitacion() {
        return $this->importe_habitacion;
    }

    function setId_hospedaje($id_hospedaje) {
        $this->id_hospedaje = $id_hospedaje;
    }

    function setId_categoria($id_categoria) {
        $this->id_categoria = $id_categoria;
    }

    function setImporte_habitacion($importe_habitacion) {
        $this->importe_habitacion = $importe_habitacion;
    }

    public function exchangeArray($data)
    {
        $this->id_hospedaje = (isset($data['id_hospedaje'])) ? $data['id_hospedaje'] : null;
        $this->id_categoria = (isset($data['id_categoria'])) ? $data['id_categoria'] : null;
        $this->importe_habitacion = (isset($data['importe_habitacion'])) ? $data['importe_habitacion'] : null;
    }
 
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
    
}
