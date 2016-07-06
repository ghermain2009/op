<?php
/**
 * Description of RoleForm
 */
namespace Dashboard\Form;

use Zend\Form\Form;

class HospedajeForm extends Form
{
    public function __construct($tipohospedajeTable,
                                $paisTable,
                                $departamentoTable,
                                $id_pais = null) {
        parent::__construct('hospedajeForm');
        
        $tipohospedajes = $tipohospedajeTable->fetchAll();
        $selAdicional = array();
        $selAdicional[0] = 'Seleccione un Tipo de Hospedaje';
        foreach($tipohospedajes as $tipohospedaje) {
            //var_dump($tipohospedaje);
            $id = $tipohospedaje->getId_tipo();
            $selAdicional[$id] = $tipohospedaje->getDescripcion_tipo();
        }
        
        $paises = $paisTable->fetchAll();
        $selPais = array();
        $selPais[0] = 'Seleccione un Pais';
        foreach($paises as $pais) {
            //var_dump($tipohospedaje);
            $id = $pais->getId_pais();
            $selPais[$id] = $pais->getDescripcion();
        }
        
        $departamentos = $departamentoTable->getDepartamentosxPais($id_pais);
        $selDepartamento = array();
        $selDepartamento[0] = 'Seleccione un Departamento';
        foreach($departamentos as $departamento) {
            //var_dump($tipohospedaje);
            $id = $departamento['id_departamento'];
            $selDepartamento[$id] = $departamento['descripcion'];
        }
        
        $this->setAttributes(array('method' => 'post',
                                  'class'  => 'form-horizontal',
                                  'role'   => 'form'));
        
        $this->add(array(
            'name' => 'id_hospedaje',
            'attributes' => array(
                'type'  => 'hidden',
                'class' => 'form-control input-sm',
                'id' => 'id_hospedaje'
            ),
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'id_tipo',
            'options' => array(
                 'value_options' => $selAdicional,
             ),
            'attributes' => array(
                'class' => 'form-control input-sm'
            ),
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'id_pais',
            'options' => array(
                 'value_options' => $selPais,
             ),
            'attributes' => array(
                'class' => 'form-control input-sm',
                'id' => 'id_pais'
            ),
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'id_departamento',
            'options' => array(
                 'value_options' => $selDepartamento,
             ),
            'attributes' => array(
                'class' => 'form-control input-sm'
            ),
        ));
        
        $this->add(array(
            'name' => 'descripcion_hospedaje',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control input-sm',
            ),
        ));
        
        $this->add(array(
            'name' => 'categoria_hospedaje',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control input-sm',
            ),
        ));
        
        $this->add(array(
            'name' => 'direccion_hospedaje',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control input-sm',
            ),
        ));
        
        $this->add(array(
            'name' => 'telefono_hospedaje',
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
                'rows'=>'3',
            ),
        ));
         
        $this->add(array(
            'name' => 'email_confirmacion',
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
