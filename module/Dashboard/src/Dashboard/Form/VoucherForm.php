<?php
/**
 * Description of RoleForm
 */
namespace Dashboard\Form;

use Zend\Form\Form;

class VoucherForm extends Form
{
    public function __construct($hospedajeTable,
                                $id_hospedaje = null) {
        parent::__construct('voucherForm');
        
        $hospedajes = $hospedajeTable->fetchAll();
        $selHospedaje = array();
        $selHospedaje[0] = 'Seleccione un Hospedaje';
        foreach($hospedajes as $hospedaje) {
            //var_dump($tipohospedaje);
            $id = $hospedaje->getId_hospedaje();
            $selHospedaje[$id] = $hospedaje->getDescripcion_hospedaje();
        }
        
        $categorias = $hospedajeTable->getCategoriasxHospedajeAll($id_hospedaje);
        $selCategoria = array();
        $selCategoria[0] = 'Seleccione un Tipo Habitación';
        foreach($categorias as $categoria) {
            //var_dump($tipohospedaje);
            $id = $categoria['id_categoria'];
            $selCategoria[$id] = $categoria['descripcion_categoria'];
        }
        
        $this->setAttributes(array('method' => 'post',
                                  'class'  => 'form-horizontal',
                                  'role'   => 'form'));
        
        $this->add(array(
            'name' => 'id_voucher',
            'attributes' => array(
                'type'  => 'hidden',
                'class' => 'form-control input-sm',
                'id' => 'id_voucher'
            ),
        ));
        $this->add(array(
            'name' => 'codigo_cupon',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control input-sm',
            ),
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'id_hospedaje',
            'options' => array(
                 'value_options' => $selHospedaje,
             ),
            'attributes' => array(
                'class' => 'form-control input-sm',
                'id' => 'id_hospedaje'
            ),
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'id_categoria',
            'options' => array(
                 'value_options' => $selCategoria,
             ),
            'attributes' => array(
                'class' => 'form-control input-sm',
                'id' => 'id_categoria'
            ),
        ));
        $this->add(array(
            'name' => 'fecha_ingreso',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control input-sm',
            ),
        ));
        $this->add(array(
            'name' => 'fecha_salida',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control input-sm',
            ),
        ));
        $this->add(array(
            'name' => 'numero_dias',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control input-sm',
            ),
        ));
        $this->add(array(
            'name' => 'cantidad_adultos',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control input-sm',
            ),
        ));
        $this->add(array(
            'name' => 'cantidad_ninos',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control input-sm',
            ),
        ));
        $this->add(array(
            'name' => 'cantidad_infantes',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control input-sm',
            ),
        ));
        $this->add(array(
            'name' => 'observacion',
            'attributes' => array(
                'type'  => 'textarea',
                'class' => 'form-control input-sm',
                'rows'=>'2'
            ),
        ));
        
        $this->add(array(
            'name' => 'nombre_pasajero',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control input-sm',
            ),
        ));
        $this->add(array(
            'name' => 'total_habitaciones',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control input-sm',
            ),
        ));
        $this->add(array(
            'name' => 'codigo_reserva',
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
