<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Dashboard\Model;
/**
 * Description of CupCliente
 *
 * @author Administrador
 */
class Cupcliente {

    //put your code here
    public $email_cliente;
    public $id_tipo_documento;
    public $numero_documento;
    public $nombres;
    public $apellidos;
    public $telefono;
    public $celular;
    public $password;
    public $id_sexo;

    function getEmail_cliente() {
        return $this->email_cliente;
    }

    function getId_tipo_documento() {
        return $this->id_tipo_documento;
    }

    function getNumero_documento() {
        return $this->numero_documento;
    }

    function getNombres() {
        return $this->nombres;
    }

    function getApellidos() {
        return $this->apellidos;
    }

    function getTelefono() {
        return $this->telefono;
    }

    function getCelular() {
        return $this->celular;
    }

    function getPassword() {
        return $this->password;
    }

    function getId_sexo() {
        return $this->id_sexo;
    }

    function setEmail_cliente($email_cliente) {
        $this->email_cliente = $email_cliente;
    }

    function setId_tipo_documento($id_tipo_documento) {
        $this->id_tipo_documento = $id_tipo_documento;
    }

    function setNumero_documento($numero_documento) {
        $this->numero_documento = $numero_documento;
    }

    function setNombres($nombres) {
        $this->nombres = $nombres;
    }

    function setApellidos($apellidos) {
        $this->apellidos = $apellidos;
    }

    function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    function setCelular($celular) {
        $this->celular = $celular;
    }

    function setPassword($password) {
        $this->password = $password;
    }

    function setId_sexo($id_sexo) {
        $this->id_sexo = $id_sexo;
    }

    public function exchangeArray($data) {
        $this->email_cliente = (isset($data['email_cliente'])) ? $data['email_cliente'] : null;
        $this->id_tipo_documento = (isset($data['id_tipo_documento'])) ? $data['id_tipo_documento'] : null;
        $this->numero_documento = (isset($data['numero_documento'])) ? $data['numero_documento'] : null;
        $this->nombres = (isset($data['nombres'])) ? $data['nombres'] : null;
        $this->apellidos = (isset($data['apellidos'])) ? $data['apellidos'] : null;
        $this->telefono = (isset($data['telefono'])) ? $data['telefono'] : null;
        $this->celular = (isset($data['celular'])) ? $data['celular'] : null;
        $this->password = (isset($data['password'])) ? $data['password'] : null;
        $this->id_sexo = (isset($data['id_sexo'])) ? $data['id_sexo'] : null;
    }

    public function getArrayCopy() {
        return get_object_vars($this);
    }

}
