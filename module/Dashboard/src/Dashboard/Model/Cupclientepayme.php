<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Dashboard\Model;
/**
 * Description of Cupclientepayme
 *
 * @author Administrador
 */
class Cupclientepayme {
    //put your code here
    public $id_cliente;
    public $email;
    public $cardholderwallet;
    public $fecha_registro;
    
    function getId_cliente() {
        return $this->id_cliente;
    }

    function getEmail() {
        return $this->email;
    }

    function getCardholderwallet() {
        return $this->cardholderwallet;
    }

    function getFecha_registro() {
        return $this->fecha_registro;
    }

    function setId_cliente($id_cliente) {
        $this->id_cliente = $id_cliente;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setCardholderwallet($cardholderwallet) {
        $this->cardholderwallet = $cardholderwallet;
    }

    function setFecha_registro($fecha_registro) {
        $this->fecha_registro = $fecha_registro;
    }

    public function exchangeArray($data)
    {
        $this->id_cliente = (isset($data['id_cliente'])) ? $data['id_cliente'] : null;
        $this->email = (isset($data['email'])) ? $data['email'] : null;
        $this->cardholderwallet = (isset($data['cardholderwallet'])) ? $data['cardholderwallet'] : null;
        $this->fecha_registro = (isset($data['fecha_registro'])) ? $data['fecha_registro'] : null;
    }
 
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
    
}
