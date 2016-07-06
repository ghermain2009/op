<?php
/**
 * Description of CampanaForm
 */
namespace Dashboard\Form;

use Zend\Form\Form;

class EmpresaForm extends Form
{
    public function __construct($tipoDocumentoTable) {
        parent::__construct('empresaForm');
        
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
                'rows'=>'2',
                'placeholder' => 'Ingrese la Razón Social de la Empresa'
            ),
        ));
        
        $this->add(array(
            'name' => 'nombre_comercial',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control input-sm',
                'rows'=>'2',
                'placeholder' => 'Ingrese el Nombre Comercial de la Empresa'
            ),
        ));
        
        
        $this->add(array(
            'name' => 'registro_contribuyente',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control input-sm',
                'placeholder' => 'Ingrese el número de registro del Contribuyente RUC, CUIT u otro según País'
            ),
        ));
        $this->add(array(
            'name' => 'direccion_facturacion',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control input-sm',
                'placeholder' => 'Ingrese la dirección de Facturación de la Empresa'
            ),
        ));
        $this->add(array(
            'name' => 'direccion_comercial',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control input-sm',
                'placeholder' => 'Ingrese la dirección de Comercial de la Empresa'
            ),
        ));
        $this->add(array(
            'name' => 'telefono',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control input-sm',
                'placeholder' => 'Ingrese teléfono de referencia de la Empresa'
            ),
        ));
        $this->add(array(
            'name' => 'horario',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control input-sm',
                'placeholder' => 'Ingrese el Horario de atención de la Empresa'
            ),
        ));
        $this->add(array(
            'name' => 'web_site',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control input-sm',
                'placeholder' => 'Ingrese el Web Site de la Empresa'
            ),
        ));
        
        $this->add(array(
            'name' => 'ubicacion_gps',
            'attributes' => array(
                'type'  => 'textarea',
                'class' => 'form-control input-sm',
                'rows'=>'3',
                'placeholder' => 'Ingrese la ubicación GPS, utilice el enlace ubicado debajo de este cuadro'
            ),
        ));
        $this->add(array(
            'name' => 'descripcion',
            'attributes' => array(
                'type'  => 'textarea',
                'class' => 'form-control input-sm',
                'rows'=>'3',
                'placeholder' => 'Ingrese resumen de descripción de la Actividad de la Empresa'
            ),
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'tipo_documento_representante',
            'options' => array(
                 'value_options' => $selTipoDocumento,
             ),
            'attributes' => array(
                'class' => 'form-control input-sm',
                'placeholder' => 'Seleccione el Tipo de Documento de Identidad del Representante Legal'
            ),
        ));
        $this->add(array(
            'name' => 'documento_representante',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control input-sm',
                'placeholder' => 'Ingrese el número de Documento de Identidad del Representante Legal'
            ),
        ));
        $this->add(array(
            'name' => 'nombre_representante',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control input-sm',
                'placeholder' => 'Ingrese el nombre completo del Representante Legal'
            ),
        ));
        
        $this->add(array(
            'name' => 'persona_contacto',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control input-sm',
                'placeholder' => 'Persona Contacto.'
            ),
        ));
        $this->add(array(
            'name' => 'email_contacto',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control input-sm',
                'placeholder' => 'Email Persona de Contacto'
            ),
        ));
        
        $this->add(array(
            'name' => 'rubro',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control input-sm',
                'placeholder' => 'Ingrese el Rubro de la Empresa'
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
            'name' => 'titular_cuenta',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control input-sm',
                'placeholder' => 'Ingrese el Titular de la Cuenta'
            ),
        ));
        $this->add(array(
            'name' => 'ruc_titular',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control input-sm',
                'placeholder' => 'Ingrese el RUC del Titular de la Cuenta'
            ),
        ));
        $this->add(array(
            'name' => 'numero_cuenta',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control input-sm',
                'placeholder' => 'Ingrese el Número de Cuenta'
            ),
        ));
        $this->add(array(
            'name' => 'tipo_cuenta',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control input-sm',
                'placeholder' => 'Ingrese el Tipo de Cuenta'
            ),
        ));
        $this->add(array(
            'name' => 'email_facturacion',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control input-sm',
                'placeholder' => 'Ingrese el Email de Facturación'
            ),
        ));
        $this->add(array(
            'name' => 'banco_cuenta',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control input-sm',
                'placeholder' => 'Ingrese el Banco de la Cuenta'
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
