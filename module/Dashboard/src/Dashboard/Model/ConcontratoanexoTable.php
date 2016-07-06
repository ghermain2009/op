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
 * Description of ConcontratoanexoTable
 *
 * @author gtapia
 */
class ConcontratoanexoTable {
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
    
    public function addAnexoContrato($params)
    {
        $params['fecha_registro'] = date('Y-m-d H:i:s');

        $sql = new Sql($this->tableGateway->getAdapter());
        $insert = $sql->insert('con_contrato_anexo')->values($params);
                
        $stmt = $sql->prepareStatementForSqlObject($insert);
        
        $stmt->execute();

        return 1;
    }
    
    public function getContratoAnexoId($id_contrato, $id_campana)
    {
        $sql = new Sql($this->tableGateway->adapter);
                
        $select = $sql->select();
        $select->columns(array('id_contrato' => 'id_contrato',
                               'id_campana'  => 'id_campana',
                               'nombre_contacto' => 'nombre_contacto',
                               'email_contacto' => 'email_contacto',
                               'fecha_registro' => new Expression("DATE_FORMAT(con_contrato_anexo.fecha_registro,'%d-%m-%Y %h:%i:%s')") ,
                               'firma_documento' => 'firma',
                               'fecha_firma' => new Expression("DATE_FORMAT(con_contrato_anexo.fecha_firma,'%d-%m-%Y %h:%i:%s')") ,
                               'nombre_documento' => 'nombre_documento',
                               'id_estado'   => 'id_estado',
                               'nombre_contacto_arte' => 'nombre_contacto',
                               'email_contacto_arte' => 'email_contacto',
                               'fecha_envio_arte' => new Expression("DATE_FORMAT(con_contrato_anexo.fecha_envio_arte,'%d-%m-%Y %h:%i:%s')") ,
                               'fecha_aceptacion_arte' => new Expression("DATE_FORMAT(con_contrato_anexo.fecha_aceptacion_arte,'%d-%m-%Y %h:%i:%s')") ,
                               'id_estado_arte'   => 'id_estado_arte'));
        $select->from('con_contrato_anexo')
        ->join('con_contrato', new Expression("con_contrato_anexo.id_contrato = con_contrato.id_contrato"),
                array('id_empresa'))
        ->where(array('con_contrato_anexo.id_contrato' => $id_contrato,
                      'id_campana' => $id_campana));

        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        return ArrayUtils::iteratorToArray($result);
    }
    
    public function editAnexoContrato($set, $where)
    {
      
        $rs = $this->tableGateway->update($set, $where);
        return $rs;
    }
}
