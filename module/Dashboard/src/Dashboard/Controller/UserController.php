<?php

/**
 * UserController - This allows add, delete and edit users
 * @autor Francis Gonzales <fgonzalestello91@gmail.com>
 */

namespace Dashboard\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Dashboard\Form\UserForm;
use ZfcDatagrid\Column;
use Zend\Json\Json;

class UserController extends AbstractActionController
{
    public function indexAction()
    {
        $viewmodel = new ViewModel();
        $sl = $this->getServiceLocator();
        $roleTable = $sl->get('Dashboard/Model/RoleTable');
        $empresaTable = $sl->get('Dashboard/Model/GenempresaTable');
        $form = new UserForm($roleTable, $empresaTable);
        $request = $this->getRequest();
        $serviceLocator = $this->getServiceLocator();
        $form->get('submit');
        $message = ""; //Message
        
        if ($request->isPost()) {
            // @TODO addfilters
            //$form->setInputFilter($filters);
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $data = $form->getData();
                $userTable = $serviceLocator->get('Dashboard\Model\UserTable');
                unset($data['submit']);
                unset($data['btn-regresar']);
                if($data['id_empresa'] == 0) $data['id_empresa'] = NULL;
                
                $rs = $userTable->addUser($data);
                if ($rs) {
                    //$form = new UserForm($roleTable, $empresaTable);
                    $this->redirect()->toRoute('dash_user_edit', array('id' => $rs));
                }
            }
        }
        $viewmodel->form = $form;
        $viewmodel->message = $message;
        return $viewmodel;
    }
    
    public function listAction()
    {
        $request = $this->getRequest();
        
        if ($request->isPost()) {
            $postData = $request->getPost();
            if ($postData->btnAdd === 'add') {
                $this->redirect()->toRoute('dash_user');
            }
        }
        
        $sl = $this->getServiceLocator();
        $dbAdapter = $sl->get('Zend\Db\Adapter\Adapter');
        $grid = $sl->get('ZfcDatagrid\Datagrid');
        $grid->setDefaultItemsPerPage(5);
        $grid->setToolbarTemplate('layout/list-toolbar');
        $grid->setDataSource($sl->get('Dashboard\Model\UserTable')
                                ->getUsersList(), $dbAdapter);
        
        $col = new Column\Select('id', 'u');
        $col->setLabel('id');
        $col->setWidth(20);
        $col->setIdentity(true);
        $col->setSortDefault(1, 'ASC');
        $grid->addColumn($col);
        
        $col = new Column\Select('username', 'u');
        $col->setLabel('Username');
        $col->setWidth(15);
        $grid->addColumn($col);
        
        $col = new Column\Select('full_name', 'u');
        $col->setLabel('Name');
        $col->setWidth(20);
        $grid->addColumn($col);
        
        $col = new Column\Select('email', 'u');
        $col->setLabel('Email');
        $col->setWidth(20);
        $grid->addColumn($col);
        
        $col = new Column\Select('name', 'r');
        $col->setLabel('Rol');
        $col->setWidth(15);
        $grid->addColumn($col);
        
        $editBtn = new Column\Action\Button();
        $editBtn->setLabel(' ');
        $editBtn->setAttribute('class', 'btn btn-success glyphicon glyphicon-edit');
        $editBtn->setAttribute('href', '/dashboard/user/edit/id/' . $editBtn->getRowIdPlaceholder());
        $editBtn->setAttribute('data-toggle', 'tooltip');
        $editBtn->setAttribute('data-placement', 'left');
        $editBtn->setAttribute('title', 'Modificar Usuario');
        
        $delBtn = new Column\Action\Button();
        $delBtn->setLabel(' ');
        $delBtn->setAttribute('class', 'btn btn-danger glyphicon glyphicon-trash');
        $delBtn->setAttribute('href', '/dashboard/user/delete/id/' . $delBtn->getRowIdPlaceholder());
        $delBtn->setAttribute('data-toggle', 'tooltip');
        $delBtn->setAttribute('data-placement', 'left');
        $delBtn->setAttribute('title', 'Eliminar Usuario');
        
        $col = new Column\Action();
        $col->addAction($editBtn);
        $col->addAction($delBtn);
        $grid->addColumn($col);
        
        return $grid->getResponse();
    }
    
    public function editAction()
    {
        $userId = $this->params('id');
        $request = $this->getRequest();
        $viewmodel = new ViewModel();
        $sl = $this->getServiceLocator();
        $roleTable = $sl->get('Dashboard\Model\RoleTable');
        $userTable = $sl->get('Dashboard\Model\UserTable');
        $empresaTable = $sl->get('Dashboard\Model\GenempresaTable');
        $form = new UserForm($roleTable, $empresaTable);
        
        if ($request->isPost()) {
            // @TODO addfilters
            //$form->setInputFilter($filters);
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $data = $form->getData();
                unset($data['submit']);
                unset($data['btn-regresar']);
                if($data['id_empresa'] == 0) $data['id_empresa'] = NULL;
                $dataId = array('id' => $userId);
                $userTable->editUser($data, $dataId);
            }
        } else {
            $userData = $userTable->getUser($userId);
            foreach ($userData as $user) {
                $form->get('id')->setValue($user['id']);
                $form->get('username')->setValue($user['username']);
                $form->get('email')->setValue($user['email']);
                $form->get('role_id')->setValue($user['role_id']);
                $form->get('full_name')->setValue($user['full_name']);
                //$form->get('password')->setValue($user['password']);
                $form->get('id_empresa')->setValue($user['id_empresa']);
            }
        }
       
        $viewmodel->form = $form;
        return $viewmodel;
    }
    
    public function deleteAction()
    {
        $sl = $this->getServiceLocator();
        $userId = $this->params('id');
        $userTable = $sl->get('Dashboard\Model\UserTable');
        $userTable->deleteUser($userId);
        $this->redirect()->toRoute('dash_user_list');
    }
    
    public function  existeusuarioAction(){
        $username = $this->params()->fromPost("username", null);
        $sl = $this->getServiceLocator();
        $userTable = $sl->get('Dashboard\Model\UserTable');
        $datos = $userTable->verificarUsuario($username);

        if( $datos[0]['existe'] == 0 ) {
            $disponible = array('valid' => true);
        } else {
            $disponible = array('valid' => false);
        }
        return $this->getResponse()->setContent(Json::encode($disponible));
    }
}
