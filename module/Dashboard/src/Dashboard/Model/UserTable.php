<?php

namespace Dashboard\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Expression;
use Zend\Stdlib\ArrayUtils;

class UserTable
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
    
    /**
     * This functions returns a query to get 
     * all the users
     * @return \Zend\Db\Sql\Select
     */
    public function getUsersList()
    {
        $select = new Select();
        $select->from(array(
                    'u' => 'user'
                ))
                ->join(array(
                    'r' => 'role'
                    ), 
                    'u.role_id = r.id'
                 )
                ->order('u.id');
        
        return $select;
    }
    
    /**
     * This function returns the user by ID
     * @param int $userId
     * @return array
     */
    public function getUser($userId)
    {
        $sql = new Sql($this->tableGateway->getAdapter());
        $select = $sql
                  ->select()
                  ->from(array('u' => 'user'))
                  ->where(array('u.id' => $userId))
                  ->order('u.id');
        $stmt = $sql->prepareStatementForSqlObject($select);
        $results = $stmt->execute(); 
        return $results;
    }
    
    public function getUserAgente($userName)
    {
        $sql = new Sql($this->tableGateway->getAdapter());
        $select = $sql
                  ->select()
                  ->from(array('u' => 'user'))
                  ->where(array('u.username' => $userName,
                                'u.role_id' => '4'))
                  ->order('u.id');
        $stmt = $sql->prepareStatementForSqlObject($select);
        $results = $stmt->execute(); 
        return $results;
    }
    
    /**
     * This function allows to add users
     * @param array $params
     * @return boolean
     */
    public function addUser($params)
    {
        $params['password'] = sha1($params['password']);

        $sql = new Sql($this->tableGateway->getAdapter());
        $insert = $sql->insert('user')->values($params);
                
        $stmt = $sql->prepareStatementForSqlObject($insert);
        
        return $stmt->execute()->getGeneratedValue();
    }
    
    /**
     * This function allows to edit Users
     * @param array $set
     * @param array $where
     * @return boolean
     */
    public function editUser($set, $where)
    {
        if (!empty($set['password'])) {
            $set['password'] = sha1($set['password']);
        } else {
            unset($set['password']);
        }
        $rs = $this->tableGateway->update($set, $where);
        return $rs;
    }
    
    public function deleteUser($userId)
    {
        $where = array('id' => $userId);
        $rs = $this->tableGateway->delete($where);
        return $rs;
    }
    
    public function verificarUsuario($username)
    {
        $sql = new Sql($this->tableGateway->getAdapter());
        $select = $sql
                  ->select()
                  ->columns(array('existe' => new Expression("count(1)")))
                  ->from('user')
                  ->where(array('username' => $username));
        
        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute(); 
        return ArrayUtils::iteratorToArray($result);
    }
}
