<?php
/**
 * Description of RoleForm
 */
namespace Dashboard\Form;

use Zend\Form\Form;

class AdicionalesForm extends Form
{
    public function __construct($tipoadicionalTable) {
        parent::__construct('adicionalesForm');
        
        $tipoadicionales = $tipoadicionalTable->fetchAll();
        $selAdicional = array();
        $selAdicional[0] = 'Seleccione un Tipo de Adicional';
        foreach($tipoadicionales as $tipoadicional) {
            //var_dump($tipoadicional);
            $id = $tipoadicional->getId_tipo_adicional();
            $selAdicional[$id] = $tipoadicional->getDescripcion_tipo_adicional();
        }
        
        $this->setAttributes(array('method' => 'post',
                                  'class'  => 'form-horizontal',
                                  'role'   => 'form'));
        
        $this->add(array(
            'name' => 'id_adicionales',
            'attributes' => array(
                'type'  => 'hidden',
                'class' => 'form-control input-sm'
            ),
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'id_tipo_adicional',
            'options' => array(
                 'value_options' => $selAdicional,
             ),
            'attributes' => array(
                'class' => 'form-control input-sm'
            ),
        ));
        
        $this->add(array(
            'name' => 'descripcion_adicionales',
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
