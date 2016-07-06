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
/**
 * Description of HoscategoriahabitacionTable
 *
 * @author Administrador
 */
class HoscategoriahabitacionTable {
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
    
    public function addCategoriahabitacion($data) 
    {
        $sql = new Sql($this->tableGateway->getAdapter());
        $insert = $sql->insert('hos_categoria_habitacion')->values($data);
                
        $stmt = $sql->prepareStatementForSqlObject($insert);
        
        return $stmt->execute()->getGeneratedValue();
    }
    
    
    public function getCategoriahabitacion($idTipo)
    {
        $sql = new Sql($this->tableGateway->getAdapter());
        $select =  $sql
                    ->select()
                    ->from('hos_categoria_habitacion')
                    ->where(array('id_categoria' => $idTipo))
                    ->order('id_categoria');
        
        $stmt = $sql->prepareStatementForSqlObject($select);
        $results = $stmt->execute(); 
        return $results;
    }
    
    public function editCategoriahabitacion($set, $where)
    {
        $rs = $this->tableGateway->update($set, $where);
        return $rs;
    }
    
    public function getCategoriahabitacionList()
    {
        $select = new Select();
        $select->from('hos_categoria_habitacion')
                ->order('id_categoria');
        
        return $select;
    }
    
    public function deleteCategoriahabitacion($idTipo)
    {
        $where = array('id_categoria' => $idTipo);
        $rs = $this->tableGateway->delete($where);
        return $rs;
    }
    
}
