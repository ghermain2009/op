<?php
/**
 * Description of CampanaForm
 */
namespace Dashboard\Form;

use Zend\Form\Form;

class PagobancarioForm extends Form
{
    public function __construct($tipoDocumentoTable) {
        parent::__construct('campana');
        
        $tipoDocumentos = $tipoDocumentoTable->fetchAll();
        $selTipoDocumento = array();
        foreach($tipoDocumentos as $tipoDocumento) {
            $id = $tipoDocumento['id_tipo_documento'];
            $selTipoDocumento[$id] = $tipoDocumento['descripcion'];
        }
        
        $this->setAttributes(array('method' => 'post',
                                  'class'  => 'form-horizontal',
                                  'role'   => 'form'));
        $this->add(array(
            'name' => 'id_empresa',
            'attributes' => array(
                'type'  => 'hidden',
                'class' => 'form-control input-sm'
            ),
        ));
        
        $this->add(array(
            'name' => 'razon_social',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control input-sm',
                'rows'=>'2'
            ),
        ));
        $this->add(array(
            'name' => 'registro_contribuyente',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control input-sm'
            ),
        ));
        $this->add(array(
            'name' => 'direccion_facturacion',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control input-sm'
            ),
        ));
        $this->add(array(
            'name' => 'direccion_comercial',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control input-sm'
            ),
        ));
        $this->add(array(
            'name' => 'telefono',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control input-sm'
            ),
        ));
        $this->add(array(
            'name' => 'horario',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control input-sm'
            ),
        ));
        $this->add(array(
            'name' => 'web_site',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control input-sm'
            ),
        ));
        
        $this->add(array(
            'name' => 'ubicacion_gps',
            'attributes' => array(
                'type'  => 'textarea',
                'class' => 'form-control input-sm',
                'rows'=>'3'
            ),
        ));
        $this->add(array(
            'name' => 'numero_cuenta',
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
                'rows'=>'3'
            ),
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'tipo_documento_representante',
            'options' => array(
                 'value_options' => $selTipoDocumento,
             ),
            'attributes' => array(
                'class' => 'form-control input-sm'
            ),
        ));
        $this->add(array(
            'name' => 'documento_representante',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control input-sm'
            ),
        ));
        $this->add(array(
            'name' => 'nombre_representante',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control input-sm'
            ),
        ));
        
        $this->add(array(
            'name' => 'id_operador',
            'attributes' => array(
                'type'  => 'text',
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
