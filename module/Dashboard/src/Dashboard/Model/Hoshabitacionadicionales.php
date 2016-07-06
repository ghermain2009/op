<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Dashboard\Model;
/**
 * Description of Hoshabitacionadicionales
 *
 * @author Administrador
 */
class Hoshabitacionadicionales {
    //put your code here
    public $id_hospedaje;
    public $id_categoria;
    public $id_adicionales;
    
    function getId_hospedaje() {
        return $this->id_hospedaje;
    }

    function getId_categoria() {
        return $this->id_categoria;
    }

    function getId_adicionales() {
        return $this->id_adicionales;
    }

    function setId_hospedaje($id_hospedaje) {
        $this->id_hospedaje = $id_hospedaje;
    }

    function setId_categoria($id_categoria) {
        $this->id_categoria = $id_categoria;
    }

    function setId_adicionales($id_adicionales) {
        $this->id_adicionales = $id_adicionales;
    }

    public function exchangeArray($data)
    {
        $this->id_hospedaje = (isset($data['id_hospedaje'])) ? $data['id_hospedaje'] : null;
        $this->id_categoria = (isset($data['id_categoria'])) ? $data['id_categoria'] : null;
        $this->id_adicionales = (isset($data['id_adicionales'])) ? $data['id_adicionales'] : null;
    }
 
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}
