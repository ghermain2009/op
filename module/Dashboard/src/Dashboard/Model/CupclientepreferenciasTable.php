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
/**
 * Description of CupclientepreferenciasTable
 *
 * @author Administrador
 */
class CupclientepreferenciasTable {
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
    
    public function addPreferencias($datos) {

        if (isset($datos)) {

            $email_cliente = $datos["email"];
            
            $sql = new Sql($this->tableGateway->adapter);

            $delete = $sql->delete();

            $delete->from('cup_cliente_preferencias')
                    ->where(array('email_cliente' => $email_cliente));

            $statement = $sql->prepareStatementForSqlObject($delete);

            $result = $statement->execute();
            
            $prefernacias = $datos["preferencia"];

            foreach ($prefernacias as $preferencia) {
                $insert = $sql->insert('cup_cliente_preferencias')->values(array(
                    'email_cliente' => (isset($datos['email'])) ? $datos['email'] : null,
                    'id_categoria' => (isset($preferencia)) ? $preferencia : null
                ));
                
                $statement = $sql->prepareStatementForSqlObject($insert);

                $result = $statement->execute();
            }
            
            return 1;

        } else {
            return 2;
        }
        
    }
    
    public function getPreferenciasByUser($email) {

        $sql = new Sql($this->tableGateway->getAdapter());
        $select = $sql
                ->select()
                ->from(array('c' => 'cup_cliente_preferencias'))
                ->where(array('c.email_cliente' => $email));

        $stmt = $sql->prepareStatementForSqlObject($select);

        $results = $stmt->execute();

        return $results;
    }
}
