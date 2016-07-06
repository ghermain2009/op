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
 * Description of ConcontratoTable
 *
 * @author gtapia
 */
class ConcontratoTable {
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
    
    public function addContrato($params)
    {
        $params['fecha_registro'] = date('Y-m-d H:i:s');
        
        $sql = new Sql($this->tableGateway->getAdapter());
        $insert = $sql->insert('con_contrato')->values($params);
                
        $stmt = $sql->prepareStatementForSqlObject($insert);
        
        $id_contrato = $stmt->execute()->getGeneratedValue();
        
        $update = $sql->update('con_contrato')->set(array('nombre_documento' => new Expression("CONCAT('CON-RE-',LPAD(".$id_contrato.",6,'0'),date_format(Now(),'-%Y'))")))->where(array('id_contrato' => $id_contrato ));
                
        $stmt = $sql->prepareStatementForSqlObject($update);
        
        $stmt->execute();

        return $id_contrato;
    }
    
    public function getContratoId($id_contrato)
    {
        $sql = new Sql($this->tableGateway->adapter);
                
        $select = $sql->select();
        $select->columns(array('id_contrato' => 'id_contrato',
                               'id_empresa'  => 'id_empresa',
                               'nombre_contacto' => 'nombre_contacto',
                               'email_contacto' => 'email_contacto',
                               'fecha_registro' => new Expression("DATE_FORMAT(fecha_registro,'%d-%m-%Y %h:%i:%s')") ,
                               'firma_documento' => 'firma_documento',
                               'fecha_firma' => new Expression("DATE_FORMAT(fecha_firma,'%d-%m-%Y %h:%i:%s')") ,
                               'nombre_documento' => 'nombre_documento',
                               'id_estado'   => 'id_estado'));
        $select->from('con_contrato')
        ->where(array('id_contrato' => $id_contrato));

        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        return ArrayUtils::iteratorToArray($result);
    }
    
    public function editContrato($set, $where)
    {
      
        $rs = $this->tableGateway->update($set, $where);
        return $rs;
    }
}
