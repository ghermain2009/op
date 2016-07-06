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
 * Description of CupcampanacategoriaTable
 *
 * @author gtapia
 */
class CupcampanacategoriaTable {

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

    public function getcategoriaxcampana($id) {
        
        $sql = new Sql($this->tableGateway->adapter);


        $select = $sql->select();

        $select->columns(array(
                    'categoria' => 'descripcion'
                ))
                ->from('gen_categoria')
                ->join('gen_sub_categoria', new Expression("gen_categoria.id_categoria = gen_sub_categoria.id_categoria"), 
                        array('subcategoria' => 'descripcion', 'id_sub_categoria')
                )
                ->join('cup_campana_categoria', new Expression("gen_sub_categoria.id_sub_categoria = cup_campana_categoria.id_sub_categoria and cup_campana_categoria.id_campana = ifnull(".$id.",0)"), 
                        array('sel' => new Expression("case when ifnull(cup_campana_categoria.id_sub_categoria,0) = 0 then 0 else 1 end")),
                        'left')
                ->order(array('gen_categoria.descripcion','gen_sub_categoria.descripcion'));
        
        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        return $result;
    }
    
    public function savecategorias($categorias, $campana) {
        
        $categoria = explode(',', $categorias);
        
        $sql = new Sql($this->tableGateway->adapter);
        $select = $sql->delete();
        $select->from('cup_campana_categoria')
                ->where(array('id_campana' => $campana));
        
        $statement = $sql->prepareStatementForSqlObject($select);
        $statement->execute();
        
        foreach( $categoria as $cateid ) {
            
            $id = $cateid;
            
            $params = array('id_campana' => $campana , 'id_sub_categoria' => $id);
            
            $this->tableGateway->insert($params);
            
        }
        
        return;
    }

}
