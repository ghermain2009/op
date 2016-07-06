<?php

namespace Dashboard\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Expression;
use Zend\Stdlib\ArrayUtils;

class GenempresaTable
{
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
    
    public function getEmpresaByCampana($id_campana)
    {
        $sql = new Sql($this->tableGateway->adapter);
                
        $select = $sql->select();
        
        $select->columns(array(
            'id_campana'
        ))
        ->from('cup_campana')
        ->join('gen_empresa', new Expression("cup_campana.id_empresa = gen_empresa.id_empresa"))
        ->where(array('id_campana' => $id_campana));

        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        return ArrayUtils::iteratorToArray($result);
    }
    
    /*public function getEmpresaList()
    {
        $select = new Select();
        $select->from(array(
                    'c' => 'gen_empresa'
                ))
                ->join(array('e' => 'con_contrato'), 
                       'c.id_empresa = e.id_empresa',
                        array('can_contrato' => new Expression("case when ifnull(id_contrato,-1) = -1 then 0 else 1 end")),
                        'left'
                 )
                ->order('c.id_empresa');
              
        return $select;
    }*/
    
    public function getEmpresaList()
    {
        $sql = new Sql($this->tableGateway->adapter);
        
        $select = new Select();
        $select->from(array(
                    'c' => 'gen_empresa'
                ))
                ->join(array('e' => 'con_contrato'), 
                       'c.id_empresa = e.id_empresa',
                        array('can_contrato' => new Expression("case when ifnull(id_contrato,-1) = -1 then 0 else 1 end")),
                        'left'
                 )
                ->where(array('c.id_estado' => '1'))
                ->order('c.id_empresa');
              
        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        return ArrayUtils::iteratorToArray($result);
    }
    
    public function getEmpresaAutorizadas()
    {
        $sql = new Sql($this->tableGateway->adapter);
                
        $select = $sql->select();
        
        $select->from('gen_empresa')
        ->order('razon_social');

        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        return ArrayUtils::iteratorToArray($result);
    }
    
    public function getEmpresa($id_empresa)
    {
        $sql = new Sql($this->tableGateway->getAdapter());
        $select = $sql
                  ->select()
                  ->from(array('c' => 'gen_empresa'))
                  ->join(array('d' => 'gen_tipo_documento'), 
                       'c.tipo_documento_representante = d.id_tipo_documento',
                        array('tipo_documento' => 'descripcion'),
                        'left'
                 )
                  ->where(array('c.id_empresa' => $id_empresa));

        $stmt = $sql->prepareStatementForSqlObject($select);
        
        $results = $stmt->execute(); 
        
        return ArrayUtils::iteratorToArray($results);
    }
    
    public function editEmpresa($set, $where)
    {
      
        $rs = $this->tableGateway->update($set, $where);
        return $rs;
    }
    
    public function addEmpresa($params)
    {
        //$auth = new AuthenticationService();
        //$identity = $auth->getIdentity();
        
        //$params['id_user'] = $identity->id;
       
        $sql = new Sql($this->tableGateway->getAdapter());
        $insert = $sql->insert('gen_empresa')->values($params);
                
        $stmt = $sql->prepareStatementForSqlObject($insert);

        return $stmt->execute()->getGeneratedValue();
    }
    
    public function getContratoxEmpresa($id)
    {
        $sql = new Sql($this->tableGateway->getAdapter());
        $select = $sql
                  ->select()
                  ->from(array('c' => 'con_contrato'))
                  ->where(array('c.id_empresa' => $id));

        $stmt = $sql->prepareStatementForSqlObject($select);
        
        $results = $stmt->execute(); 
        
        return ArrayUtils::iteratorToArray($results);
    }
    
    public function gelPlantillaContrato($id) {
        
    }


}
