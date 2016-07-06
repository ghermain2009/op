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
 * Description of UbidepartamentoTable
 *
 * @author Administrador
 */
class UbidepartamentoTable {
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
    
    public function getDepartamentosxPais($id_pais) {
        $sql = new Sql($this->tableGateway->adapter);
                
        $select = $sql->select();

        $select->columns(array(
            'id_departamento',
            'descripcion'
        ))
        ->from('ubi_departamento')
        ->where(array('id_pais' => $id_pais))
        ->order('descripcion');

        $statement = $sql->prepareStatementForSqlObject($select);
        
        $result = $statement->execute();

        return ArrayUtils::iteratorToArray($result);
    }
    
    public function getDepartamentosxPaisFavoritos($id_pais) {
        $sql = new Sql($this->tableGateway->adapter);
                
        $select = $sql->select();

        $select->columns(array(
            'id_departamento',
            'descripcion'
        ))
        ->from('ubi_departamento')
        ->where(array('id_pais' => $id_pais,
                      'preferencia' => '1' ))
        ->order('descripcion');

        $statement = $sql->prepareStatementForSqlObject($select);
        
        $result = $statement->execute();

        return ArrayUtils::iteratorToArray($result);
    }
    
}
