<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Dashboard\Model;
/**
 * Description of Cupcampanacategoria
 *
 * @author gtapia
 */
class Cupcampanacategoria {
    //put your code here
    public $id_campana;
    public $id_sub_categoria;
    
    public function getId_campana() {
        return $this->id_campana;
    }

    public function getId_sub_categoria() {
        return $this->id_sub_categoria;
    }

    public function setId_campana($id_campana) {
        $this->id_campana = $id_campana;
    }

    public function setId_sub_categoria($id_sub_categoria) {
        $this->id_sub_categoria = $id_sub_categoria;
    }

    public function exchangeArray($data)
    {
        $this->id_campana = (isset($data['id_campana'])) ? $data['id_campana'] : null;
        $this->id_sub_categoria = (isset($data['id_sub_categoria'])) ? $data['id_sub_categoria'] : null;
       
    }
 
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}
