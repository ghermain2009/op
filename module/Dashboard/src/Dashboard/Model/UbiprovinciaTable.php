<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Dashboard\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Predicate\NotIn;
use Zend\Stdlib\ArrayUtils;
/**
 * Description of UbiprovinciaTable
 *
 * @author gtapia
 */
class UbiprovinciaTable {
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
    
    public function getProvinciasxDepartamento($id_pais, $id_departamento) {
        $sql = new Sql($this->tableGateway->adapter);
                
        $select = $sql->select();

        $select->columns(array(
            'id_provincia',
            'descripcion'
        ))
        ->from('ubi_provincia')
        ->where(array('id_pais' => $id_pais,
                      'id_departamento' => $id_departamento))
        ->order('descripcion');

        $statement = $sql->prepareStatementForSqlObject($select);
        
        $result = $statement->execute();

        return ArrayUtils::iteratorToArray($result);
    }
    
}
