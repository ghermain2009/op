<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Dashboard\Model;
/**
 * Description of Cupliquidacioncupon
 *
 * @author gtapia
 */
class Cupliquidacioncupon {
    //put your code here
    public $id_liquidacion;
    public $id_cupon;
    
    public function getId_liquidacion() {
        return $this->id_liquidacion;
    }

    public function getId_cupon() {
        return $this->id_cupon;
    }

    public function setId_liquidacion($id_liquidacion) {
        $this->id_liquidacion = $id_liquidacion;
    }

    public function setId_cupon($id_cupon) {
        $this->id_cupon = $id_cupon;
    }

    public function exchangeArray($data)
    {
        $this->id_liquidacion = (isset($data['id_liquidacion'])) ? $data['id_liquidacion'] : null;
        $this->id_cupon = (isset($data['id_cupon'])) ? $data['id_cupon'] : null;
    }
    
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}
