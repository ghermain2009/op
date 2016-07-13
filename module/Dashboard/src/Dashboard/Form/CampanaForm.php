<?php
/**
 * Description of CampanaForm
 */
namespace Dashboard\Form;

use Zend\Form\Form;

class CampanaForm extends Form
{
    public function __construct($empresaTable, $pantallaTable) {
        parent::__construct('campana');
        
        $empresas = $empresaTable->fetchAll();
        $selEmpresa = array();
        foreach($empresas as $empresa) {
            $id = $empresa->getId_empresa();
            $selEmpresa[$id] = $empresa->getNombre_comercial();
        }
        
        $pantallas = $pantallaTable->fetchAll();
        $selTipoPantalla = array();
        foreach($pantallas as $pantalla) {
            $id = $pantalla->getId_tipo_pantalla();
            $selTipoPantalla[$id] = $pantalla->getDescripcion_pantalla();
        }
        
        $this->setAttributes(array('method' => 'post',
                                  'class'  => 'form-horizontal',
                                  'role'   => 'form'));
        $this->add(array(
            'name' => 'id_campana',
            'attributes' => array(
                'type'  => 'hidden',
                'class' => 'form-control input-sm'
            ),
        ));
        $this->add(array(
            'name' => 'titulo',
            'attributes' => array(
                'type'  => 'textarea',
                'class' => 'form-control input-sm',
                'rows'=>'2'
            ),
        ));
        $this->add(array(
            'name' => 'subtitulo',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control input-sm'
            ),
        ));
        $this->add(array(
            'name' => 'descripcion',
            'attributes' => array(
                'type'  => 'textarea',
                'class' => 'form-control input-sm',
                'rows'=>'4'
            ),
          ));
        $this->add(array(
            'name' => 'sobre_campana',
            'attributes' => array(
                'type'  => 'hidden',
                'class' => 'form-control input-sm',
                'rows'=>'4',
                'id' => 'sobre_campana'
            ),
          ));
        $this->add(array(
            'name' => 'observaciones',
            'attributes' => array(
                'type'  => 'hidden',
                'class' => 'form-control input-sm',
                'rows'=>'4',
                'id' => 'observaciones'
            ),
          ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'id_empresa',
            'options' => array(
                 'value_options' => $selEmpresa,
             ),
            'attributes' => array(
                'class' => 'form-control input-sm'
            ),
        ));
        $this->add(array(
            'name' => 'fecha_inicio',
            'attributes' => array(
                'id'    => 'fecha_inicio',
                'type'  => 'text',
                'class' => 'form-control input-sm'
            ),
          ));
        $this->add(array(
            'name' => 'hora_inicio',
            'attributes' => array(
                'id'    => 'hora_inicio',
                'type'  => 'text',
                'class' => 'form-control input-sm',
                'data-format' => 'hh:mm:ss'
            ),
          ));
        $this->add(array(
            'name' => 'fecha_final',
            'attributes' => array(
                'id'    => 'fecha_final',
                'type'  => 'text',
                'class' => 'form-control input-sm'
            ),
          ));
        $this->add(array(
            'name' => 'hora_final',
            'attributes' => array(
                'id'    => 'hora_final',
                'type'  => 'text',
                'class' => 'form-control input-sm',
                'data-format' => 'hh:mm:ss'
            ),
          ));
        $this->add(array(
            'name' => 'fecha_validez',
            'attributes' => array(
                'id'    => 'fecha_validez',
                'type'  => 'text',
                'class' => 'form-control input-sm'
            ),
          ));
        $this->add(array(
            'name' => 'cantidad_cupones',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control input-sm',
            ),
          ));
        $this->add(array(
            'name' => 'tiempo_online',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control input-sm',
            ),
          ));
        $this->add(array(
            'name' => 'tiempo_offline',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control input-sm',
            ),
          ));
        $this->add(array(
            'name' => 'comision_campana',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control input-sm',
            ),
          ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'id_tipo_pantalla',
            'options' => array(
                 'value_options' => $selTipoPantalla,
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
                'id' => 'submitbutton',
                'class' => 'btn btn-primary',
            ),
        ));    
    }
}
