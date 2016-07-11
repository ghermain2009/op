<?php
/**
 * Description of CampanaseleccionopcionForm
 */
namespace Dashboard\Form;

use Zend\Form\Form;

class CampanaseleccionopcionForm extends Form
{
    public function __construct($grupos) {
        parent::__construct('seleccionopcion');
        
        $selTipoSeleccion = array('1' => 'Selección Cantidad',
                                  '2' => 'Selección Fecha',
                                  '3' => 'Selección Relación');
        
        $selUtilizaPrecio = array('1' => 'Si',
                                  '2' => 'No');
        
        $selUtilizaGrupo  = array('-1'=> 'Seleccionar',
                                  '1' => 'Si',
                                  '2' => 'No');
        
        $selAgrupado = array();
        $selAgrupado['-1'] = 'Seleccionar';
        foreach( $grupos as $grupo) {
            $id = $grupo['id_opcion_seleccion'];
            $selAgrupado[$id] = $grupo['descripcion_primaria'];
        }
        
        $this->setAttributes(array('id' => 'frmSeleccionOpcion'));
        
        $this->add(array(
            'name' => 'pks_opcion_seleccion',
            'attributes' => array(
                'id' => 'pks_opcion_seleccion',
                'type'  => 'hidden',
                'class' => 'form-control input-sm'
            ),
        ));
        
        $this->add(array(
            'name' => 'pks_campana_opcion',
            'attributes' => array(
                'id' => 'pks_campana_opcion',
                'type'  => 'hidden',
                'class' => 'form-control input-sm'
            ),
        ));
        
        $this->add(array(
            'name' => 'pks_campana',
            'attributes' => array(
                'id' => 'pks_campana',
                'type'  => 'hidden',
                'class' => 'form-control input-sm'
            ),
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'tipo_seleccion',
            'options' => array(
                 'value_options' => $selTipoSeleccion,
             ),
            'attributes' => array(
                'id' => 'tipo_seleccion',
                'class' => 'form-control input-sm'
            ),
        ));
        
        $this->add(array(
            'name' => 'descripcion_primaria',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control input-sm'
            ),
        ));
        
        $this->add(array(
            'name' => 'descripcion_secundaria',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control input-sm'
            ),
        ));
        
        $this->add(array(
            'name' => 'dias_bloqueo',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control input-sm'
            ),
        ));
        
        $this->add(array(
            'name' => 'valor_inicial',
            'attributes' => array(
                'id' => 'valor_inicial',
                'type'  => 'text',
                'class' => 'form-control input-sm'
            ),
        ));
        
        $this->add(array(
            'name' => 'valor_final',
            'attributes' => array(
                'id' => 'valor_final',
                'type'  => 'text',
                'class' => 'form-control input-sm'
            ),
        ));
        
        $this->add(array(
            'name' => 'incremento',
            'attributes' => array(
                'id' => 'incremento',
                'type'  => 'text',
                'class' => 'form-control input-sm'
            ),
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'utiliza_descripcion_precio',
            'options' => array(
                 'value_options' => $selUtilizaPrecio,
             ),
            'attributes' => array(
                'id' => 'utiliza_descripcion_precio',
                'class' => 'form-control input-sm'
            ),
        ));
        
        $this->add(array(
            'name' => 'descripcion_interna',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control input-sm'
            ),
        ));

        $this->add(array(
            'name' => 'importe_seleccion',
            'attributes' => array(
                'id' => 'importe_seleccion',
                'type'  => 'text',
                'class' => 'form-control input-sm'
            ),
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'opcion_multiple',
            'options' => array(
                 'value_options' => $selUtilizaGrupo,
             ),
            'attributes' => array(
                'id' => 'opcion_multiple',
                'class' => 'form-control input-sm'
            ),
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'id_opcion_seleccion_referencia',
            'options' => array(
                 'value_options' => $selAgrupado,
             ),
            'attributes' => array(
                'id' => 'id_opcion_seleccion_referencia',
                'class' => 'form-control input-sm'
            ),
        ));
        
    }
}
