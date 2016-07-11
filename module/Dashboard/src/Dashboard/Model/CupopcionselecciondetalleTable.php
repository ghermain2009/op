<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Dashboard\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;
use Zend\Stdlib\ArrayUtils;

/**
 * Description of CupopcionselecciondetalleTable
 *
 * @author gtapia
 */
class CupopcionselecciondetalleTable {
    //put your code here
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function getTableGateway() {
        return $this->tableGateway;
    }

    public function fetchAll() {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }
    
    public function getSeleccionOpcionDetalleId($id_opcion_selecion) {
        $sql = new Sql($this->tableGateway->adapter);

        $select = $sql->select();

        $select->columns(array(
                    'id_opcion_seleccion_detalle',
                    'id_opcion_seleccion',
                    'cantidad_seleccion',
                    'importe_seleccion',
                    'descripcion_seleccion',
                    'id_detalle_referencia'
                ))
                ->from('cup_opcion_seleccion_detalle')
                ->where(array('id_opcion_seleccion' => $id_opcion_selecion));

        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        return ArrayUtils::iteratorToArray($result);
        
    }
    
    public function getSeleccionDetalleReferenciaId($id_opcion_selecion,$id_referencia) {
        $sql = new Sql($this->tableGateway->adapter);

        $select = $sql->select();

        $select->columns(array(
                    'id_opcion_seleccion_detalle',
                    'id_opcion_seleccion',
                    'cantidad_seleccion',
                    'importe_seleccion',
                    'descripcion_seleccion',
                    'id_detalle_referencia'
                ))
                ->from('cup_opcion_seleccion_detalle')
                ->where(array('id_opcion_seleccion' => $id_opcion_selecion,
                              'id_detalle_referencia' => $id_referencia));

        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        return ArrayUtils::iteratorToArray($result);
        
    }
    
    public function addSeleccionOpcionDetalle($datos) {
        
        if(trim($datos["id_opcion_seleccion_detalle"]) == '' ) {

            $sql = new Sql($this->tableGateway->adapter);

            $insert = $sql->insert('cup_opcion_seleccion_detalle')->values(array(
                'id_opcion_seleccion' => (isset($datos['id_opcion_seleccion'])) ? $datos['id_opcion_seleccion'] : null,
                'cantidad_seleccion' => (isset($datos['cantidad_seleccion'])) ? $datos['cantidad_seleccion'] : null,
                'importe_seleccion' => (isset($datos['importe_seleccion'])) ? $datos['importe_seleccion'] : null,
                'descripcion_seleccion' => (isset($datos['descripcion_seleccion'])) ? $datos['descripcion_seleccion'] : null,
                'id_detalle_referencia' => (isset($datos['id_detalle_referencia'])) ? $datos['id_detalle_referencia'] : null,
            ));
            
            $statement = $sql->prepareStatementForSqlObject($insert);

            $result = $statement->execute()->getGeneratedValue();
            
            $datos = array('resultado' => 'I', 'id' => $result);
            
        } else {
            
            $set = array('id_opcion_seleccion' => (isset($datos['id_opcion_seleccion'])) ? $datos['id_opcion_seleccion'] : null,
                         'cantidad_seleccion' => (isset($datos['cantidad_seleccion'])) ? $datos['cantidad_seleccion'] : null,
                         'importe_seleccion' => (isset($datos['importe_seleccion'])) ? $datos['importe_seleccion'] : null,
            );
            
            $where = array('id_opcion_seleccion_detalle' => (isset($datos['id_opcion_seleccion_detalle'])) ? $datos['id_opcion_seleccion_detalle'] : null);
        
            $result = $this->tableGateway->update($set, $where);
            
            
            
            $datos = array('resultado' => 'U', 'id' => $datos["id_opcion_seleccion_detalle"]);
            
        }
        
        return $datos;
    }
    
    public function delSeleccionOpcionDetalleId($id_opcion_seleccion) {
        $sql = new Sql($this->tableGateway->adapter);

        $select = $sql->delete('cup_opcion_seleccion_detalle');
        $select->where(array('id_opcion_seleccion' => $id_opcion_seleccion));

        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        return $result;
    }
}
