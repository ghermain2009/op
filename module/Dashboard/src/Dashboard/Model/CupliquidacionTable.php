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
use Zend\Stdlib\ArrayUtils;
/**
 * Description of CupliquidacionTable
 *
 * @author gtapia
 */
class CupliquidacionTable {
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
    
    public function getLiquidacionList()
    {
        $select = new Select();
        $select->from(array(
                    'c' => 'cup_liquidacion'
                ))
                ->join(array(
                    'e' => 'cup_campana'
                    ), 
                    'c.id_campana = e.id_campana'
                 )
                ->order('c.id_campana');
        
        return $select;
    }
    
    public function addPreLiquidacion($id_campana) {
        
        $sql = new Sql($this->tableGateway->adapter);

        $insert = $sql->insert('cup_liquidacion')->values(array(
            'fecha_liquidacion' => new Expression("NOW()"),
            'id_campana' => $id_campana,
            'estado_liquidacion' => '1'
        ));

        $statement = $sql->prepareStatementForSqlObject($insert);
        
        $result = $statement->execute()->getGeneratedValue();
        
        return $result; /* Se inserto Informacion */
        
    }
    
    public function updPreLiquidacion($set, $where) {
        
        $rs = $this->tableGateway->update($set, $where);
        
        return $rs;
        
    }
    
    public function getLiquidaciones($id_empresa, $cantidad = 0) {

        $sql = new Sql($this->tableGateway->adapter);
                
        $select = $sql->select();

        $select->columns(array(
            'id_liquidacion',
            'fecha_liquidacion' => new Expression("date_format(fecha_liquidacion,'%d-%m-%Y')"),
            'cantidad_cupones',
            'total_importe',
            'comision',
            'impuesto',
            'total_liquidacion',
            'estado_liquidacion',
            'id_campana'
        ))
        ->from('cup_liquidacion');
        
        if( $cantidad > 0 ) { 
            $select->limit($cantidad); 
        }
        
        $select->join('cup_campana', new Expression("cup_liquidacion.id_campana = cup_campana.id_campana and "
                                           . "cup_campana.id_empresa = $id_empresa"),
                array());
        //->where(new In('id_estado_compra', array('5','7')));
        
        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        return ArrayUtils::iteratorToArray($result);
    }
    
    public function getLiquidacionById($id_liquidacion) {

        $sql = new Sql($this->tableGateway->adapter);
                
        $select = $sql->select();

        $select->columns(array(
            'id_liquidacion',
            'fecha_liquidacion' => new Expression("date_format(fecha_liquidacion,'%d-%m-%Y')"),
            'cantidad_cupones',
            'total_importe',
            'comision',
            'impuesto',
            'comision_sin_impuesto' => new Expression("comision - impuesto"),
            'total_liquidacion',
            'estado_liquidacion',
            'id_campana'
        ))
        ->from('cup_liquidacion')
        ->where(array('cup_liquidacion.id_liquidacion' => $id_liquidacion));
        
        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        return ArrayUtils::iteratorToArray($result);
    }
    
    public function getLiquidacionCupones($id_liquidacion) {

        $sql = new Sql($this->tableGateway->adapter);
                
        $select = $sql->select();

        $select->columns(array(
            'id_liquidacion',
            'codigo_cupon'
        ))
        ->from('cup_liquidacion_cupon')
        ->join('cup_cupon_detalle', new Expression("cup_liquidacion_cupon.codigo_cupon = cup_cupon_detalle.codigo_cupon "),
                array('fecha_validacion' => new Expression("date_format(fecha_validacion,'%d %M %Y %H:%i')"),
                      'precio_unitario'))
        ->where(array('cup_liquidacion_cupon.id_liquidacion' => $id_liquidacion));
        
        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        return ArrayUtils::iteratorToArray($result);
    }
}
