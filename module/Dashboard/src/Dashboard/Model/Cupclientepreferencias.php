<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Dashboard\Model;
/**
 * Description of Cupclientepreferencias
 *
 * @author Administrador
 */
class Cupclientepreferencias {
    //put your code here
    public $email_cliente;
    public $id_categoria;
    
    function getEmail_cliente() {
        return $this->email_cliente;
    }

    function getId_categoria() {
        return $this->id_categoria;
    }

    function setEmail_cliente($email_cliente) {
        $this->email_cliente = $email_cliente;
    }

    function setId_categoria($id_categoria) {
        $this->id_categoria = $id_categoria;
    }

    public function exchangeArray($data)
    {
        $this->email_cliente = (isset($data['email_cliente'])) ? $data['email_cliente'] : null;
        $this->id_categoria = (isset($data['id_categoria'])) ? $data['id_categoria'] : null;
    }
 
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}
