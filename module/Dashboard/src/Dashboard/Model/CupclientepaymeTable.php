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
use Zend\Stdlib\ArrayUtils;
use Zend\Db\Sql\Predicate\IsNull;
/**
 * Description of CupclientepaymeTable
 *
 * @author Administrador
 */
class CupclientepaymeTable {
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
        return ArrayUtils::iteratorToArray($resultSet);
    }
    
    public function addClientepayme($email) {
        
        $sql = new Sql($this->tableGateway->getAdapter());
        $select = $sql
                ->select()
                ->columns(array('id_cliente'))
                ->from(array('a' => 'cup_cliente_payme'))
                ->where(array('a.email' => $email));

        $stmt = $sql->prepareStatementForSqlObject($select);

        $datosPayme = ArrayUtils::iteratorToArray($stmt->execute());
        
        if( count($datosPayme) == 1 ) {
            
            return $datosPayme[0]['id_cliente'];
            
        } else {
            
            $insert = $sql->insert('cup_cliente_payme')->values(array(
                'email' => (isset($email)) ? $email : null,
            ));
            
            $statement = $sql->prepareStatementForSqlObject($insert);

            return $statement->execute()->getGeneratedValue();
            
        }
       
    }
    
    public function updClientepayme($email,$tokenwallet) {
        
        $set = array('cardholderwallet' => $tokenwallet,
                     'fecha_registro' => new Expression("NOW()")
                    );
        $where = array('email' => $email,
                       new IsNull('cardholderwallet'));

        $rs = $this->tableGateway->update($set, $where);
        
        return $rs;
    }
    
    public function getClientepayme($email) {
        
        $sql = new Sql($this->tableGateway->getAdapter());
        $select = $sql
                ->select()
                ->from(array('cup_cliente_payme'))
                ->where(array('email' => $email));

        $stmt = $sql->prepareStatementForSqlObject($select);

        return ArrayUtils::iteratorToArray($stmt->execute());
        
    }
}
