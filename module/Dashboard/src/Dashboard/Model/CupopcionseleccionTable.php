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
 * Description of CupopcionseleccionTable
 *
 * @author gtapia
 */
class CupopcionseleccionTable {
    //put your code here
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
    
    public function getSeleccionOpcionId($id_opcion_selecion) {
        $sql = new Sql($this->tableGateway->adapter);

        $select = $sql->select();

        $select->columns(array(
                    'id_opcion_seleccion',
                    'id_campana_opcion',
                    'id_campana',
                    'tipo_seleccion',
                    'dias_bloqueo',
                    'descripcion_primaria',
                    'descripcion_secundaria',
                    'valor_inicial',
                    'valor_final',
                    'incremento',
                    'utiliza_descripcion_precio',
                    'importe_seleccion',
                    'descripcion_interna'
                ))
                ->from('cup_opcion_seleccion')
                ->where(array('id_opcion_seleccion' => $id_opcion_selecion));

        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        return ArrayUtils::iteratorToArray($result);
        
    }
    
    public function addSeleccionxOpcion($datos) {
        
        if(trim($datos["id_opcion_seleccion"]) == '' ) {

            $sql = new Sql($this->tableGateway->adapter);

            $insert = $sql->insert('cup_opcion_seleccion')->values(array(
                'id_campana_opcion' => (isset($datos['id_campana_opcion'])) ? $datos['id_campana_opcion'] : null,
                'id_campana' => (isset($datos['id_campana'])) ? $datos['id_campana'] : null,
                'tipo_seleccion' => (isset($datos['tipo_seleccion'])) ? $datos['tipo_seleccion'] : null,
                'descripcion_primaria' => (isset($datos['descripcion_primaria'])) ? $datos['descripcion_primaria'] : null,
                'descripcion_secundaria' => (isset($datos['descripcion_secundaria'])) ? $datos['descripcion_secundaria'] : null,
                'dias_bloqueo' => (isset($datos['dias_bloqueo'])) ? $datos['dias_bloqueo'] : null,
                'valor_inicial' => (isset($datos['valor_inicial'])) ? $datos['valor_inicial'] : null,
                'valor_final' => (isset($datos['valor_final'])) ? $datos['valor_final'] : null,
                'incremento' => (isset($datos['incremento'])) ? $datos['incremento'] : null,
                'importe_seleccion' => (isset($datos['importe_seleccion'])) ? $datos['importe_seleccion'] : null,
                'descripcion_interna' => (isset($datos['descripcion_interna'])) ? $datos['descripcion_interna'] : null,
                'utiliza_descripcion_precio' => (isset($datos['utiliza_descripcion_precio'])) ? $datos['utiliza_descripcion_precio'] : null,
            ));
            
            $statement = $sql->prepareStatementForSqlObject($insert);

            $result = $statement->execute()->getGeneratedValue();
            
            $datos = array('resultado' => 'I', 'id' => $result);
            
        } else {
            
            $set = array('tipo_seleccion' => (isset($datos['tipo_seleccion'])) ? $datos['tipo_seleccion'] : null,
                         'descripcion_primaria' => (isset($datos['descripcion_primaria'])) ? $datos['descripcion_primaria'] : null,
                         'descripcion_secundaria' => (isset($datos['descripcion_secundaria'])) ? $datos['descripcion_secundaria'] : null,
                         'dias_bloqueo' => (isset($datos['dias_bloqueo'])) ? $datos['dias_bloqueo'] : null,
                         'valor_inicial' => (isset($datos['valor_inicial'])) ? $datos['valor_inicial'] : null,
                         'valor_final' => (isset($datos['valor_final'])) ? $datos['valor_final'] : null,
                         'incremento' => (isset($datos['incremento'])) ? $datos['incremento'] : null,
                         'importe_seleccion' => (isset($datos['importe_seleccion'])) ? $datos['importe_seleccion'] : null,
                         'descripcion_interna' => (isset($datos['descripcion_interna'])) ? $datos['descripcion_interna'] : null,
                         'utiliza_descripcion_precio' => (isset($datos['utiliza_descripcion_precio'])) ? $datos['utiliza_descripcion_precio'] : null,
            );
            
            $where = array('id_opcion_seleccion' => (isset($datos['id_opcion_seleccion'])) ? $datos['id_opcion_seleccion'] : null,
                           'id_campana_opcion' => (isset($datos['id_campana_opcion'])) ? $datos['id_campana_opcion'] : null,
                           'id_campana' => (isset($datos['id_campana'])) ? $datos['id_campana'] : null);
        
            $result = $this->tableGateway->update($set, $where);
            
            
            
            $datos = array('resultado' => 'U', 'id' => $datos["id_opcion_seleccion"]);
            
        }
        
        return $datos;
    }
    
    public function delSeleccionxOpcionId($id_seleccion) {
        $sql = new Sql($this->tableGateway->adapter);

        $select = $sql->delete('cup_opcion_seleccion');
        $select->where(array('id_opcion_seleccion' => $id_seleccion));

        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        return $result;
    }
    
    public function delSeleccionxOpcionxCampanaId($id_campana_opcion, $id_campana) {
        $sql = new Sql($this->tableGateway->adapter);

        $select = $sql->delete('cup_opcion_seleccion');
        $select->where(array('id_campana_opcion' => $id_campana_opcion, 'id_campana' => $id_campana ));

        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        return $result;
    }
    
    
}
