<?php
/**
 * Description of UserForm
 */
namespace Dashboard\Form;

use Zend\Form\Form;
use Dashboard\Model\Role;

class UserForm extends Form
{
    public function __construct($roleTable, $empresaTable) {
        parent::__construct('userForm');
        
        $roles = $roleTable->fetchAll();
        $selRol = array();
        $selRol[0] = 'Seleccione un Rol';
        foreach($roles as $role) {
            $id = $role->getId();
            $selRol[$id] = $role->getName();
        }
        
        $empresas = $empresaTable->getEmpresaList();
        $selEmpresas = array();
        $selEmpresas[0] = 'Seleccione una Empresa';
        foreach($empresas as $empresa) {
            $id = $empresa['id_empresa'];
            $selEmpresas[$id] = $empresa['razon_social'];
        }
        
        $this->setAttributes(array('method' => 'post',
                                  'class'  => 'form-horizontal',
                                  'role'   => 'form'));
        
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
                'class' => 'form-control input-sm'
            ),
        ));
        
        $this->add(array(
            'name' => 'full_name',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control input-sm',
            ),
        ));
        
        $this->add(array(
            'name' => 'username',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control input-sm',
                'id' => 'username'
            ),
            /*'options' => array(
                'label' => 'Usuario',
            ),*/
        ));
        $this->add(array(
            'name' => 'password',
            'attributes' => array(
                'type'  => 'password',
                'class' => 'form-control input-sm',
            ),
            /*'options' => array(
                'label' => 'Clave',
            ),*/
        ));
        $this->add(array(
            'name' => 'email',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control input-sm',
            ),
            /*'options' => array(
                'label' => 'Email',
            ),*/
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'role_id',
            'options' => array(
                /*'label' => 'Role',*/
                'value_options' => $selRol,
             ),
            'attributes' => array(
                'class' => 'form-control input-sm'
            ),
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'id_empresa',
            'options' => array(
                'value_options' => $selEmpresas,
             ),
            'attributes' => array(
                'class' => 'form-control input-sm'
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Registrar cambios',
                'id' => 'submit',
                'class' => 'btn btn-primary',
            ),
        )); 
        
        $this->add(array(
            'name' => 'btn-regresar',
            'attributes' => array(
                'type'  => 'button',
                'value' => 'Cancelar',
                'id' => 'btn-regresar',
                'class' => 'btn btn-info',
            ),
        )); 
    }
}
