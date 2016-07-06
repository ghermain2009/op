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
use Zend\Authentication\AuthenticationService;
use Zend\Stdlib\ArrayUtils;
use Zend\Db\Sql\Predicate\NotIn;
/**
 * Description of HosadicionalesTable
 *
 * @author Administrador
 */
class HosadicionalesTable {
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
    
    public function addAdicionales($data) 
    {
        $sql = new Sql($this->tableGateway->getAdapter());
        $insert = $sql->insert('hos_adicionales')->values($data);
                
        $stmt = $sql->prepareStatementForSqlObject($insert);
        
        return $stmt->execute()->getGeneratedValue();
    }
    
    
    public function getAdicionales($idTipo)
    {
        $sql = new Sql($this->tableGateway->getAdapter());
        $select =  $sql
                    ->select()
                    ->from('hos_adicionales')
                    ->where(array('id_adicionales' => $idTipo))
                    ->order('id_adicionales');
        
        $stmt = $sql->prepareStatementForSqlObject($select);
        $results = $stmt->execute(); 
        return $results;
    }
    
    public function getAdicionalesNotIn($idTipo)
    {
        $sql = new Sql($this->tableGateway->getAdapter());
        $select =  $sql
                    ->select()
                    ->from('hos_adicionales')
                    ->where->notIn('id_adicionales', array($idTipo)) 
                    ->order('id_tipo_adicional');
        
        $stmt = $sql->prepareStatementForSqlObject($select);
        $results = $stmt->execute(); 
        return $results;
    }
    
    public function editAdicionales($set, $where)
    {
        $rs = $this->tableGateway->update($set, $where);
        return $rs;
    }
    
    public function getAdicionalesList()
    {
        $select = new Select();
        $select->from(array('a' => 'hos_adicionales'))
               ->join(array('b' => 'hos_tipo_adicional'), 'a.id_tipo_adicional = b.id_tipo_adicional')
               ->order('a.id_adicionales');
        
        return $select;
    }
    
    public function deleteAdicionales($idTipo)
    {
        $where = array('id_adicionales' => $idTipo);
        $rs = $this->tableGateway->delete($where);
        return $rs;
    }
}
