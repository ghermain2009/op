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
use Zend\Authentication\AuthenticationService;
/**
 * Description of CupliquidacioncuponTable
 *
 * @author gtapia
 */
class CupliquidacioncuponTable {
    //put your code here
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
     
    public function getTableGateway()
    {
        return $this->tableGateway;
    }
 
    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }
    
    public function addLiquidacionCupon($row) {
        
        $sql = new Sql($this->tableGateway->adapter);

        $insert = $sql->insert('cup_liquidacion_cupon')->values($row);

        $statement = $sql->prepareStatementForSqlObject($insert);

        $result = $statement->execute();

        return $result; /* Se inserto Informacion */
        
    }
}
