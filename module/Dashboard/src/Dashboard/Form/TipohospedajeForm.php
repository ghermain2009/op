<?php
/**
 * Description of RoleForm
 */
namespace Dashboard\Form;

use Zend\Form\Form;

class TipohospedajeForm extends Form
{
    public function __construct($name = null) {
        parent::__construct('tipohospedajeForm');
        
        $this->setAttributes(array('method' => 'post',
                                  'class'  => 'form-horizontal',
                                  'role'   => 'form'));
        
        $this->add(array(
            'name' => 'id_tipo',
            'attributes' => array(
                'type'  => 'hidden',
                'class' => 'form-control input-sm'
            ),
        ));
        $this->add(array(
            'name' => 'descripcion_tipo',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control input-sm',
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
