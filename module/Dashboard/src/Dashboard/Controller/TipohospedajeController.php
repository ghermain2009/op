<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Dashboard\Controller;

use Dashboard\Form\TipohospedajeForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use ZfcDatagrid\Column;
/**
 * Description of TipohospedajeController
 *
 * @author Administrador
 */
class TipohospedajeController extends AbstractActionController {
    //put your code here
    public function indexAction()
    {   
        $viewmodel = new ViewModel();
        $form = new TipohospedajeForm();
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
                $tipohospedajeTable = $serviceLocator->get('Dashboard\Model\HostipohospedajeTable');
                unset($data['submit']);
                unset($data['btn-regresar']);
                $rs = $tipohospedajeTable->addTipohospedaje($data);
                
                if ($rs) {
                    //$form = new TipohospedajeForm();
                    $this->redirect()->toRoute('dash_tipohospedaje_edit', array('id' => $rs));
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
                $this->redirect()->toRoute('dash_tipohospedaje');
            }
        }
        
        $sl = $this->getServiceLocator();
        $dbAdapter = $sl->get('Zend\Db\Adapter\Adapter');
        $grid = $sl->get('ZfcDatagrid\Datagrid');
        $grid->setDefaultItemsPerPage(5);
        $grid->setToolbarTemplate('layout/list-toolbar');
        $grid->setDataSource($sl->get('Dashboard\Model\HostipohospedajeTable')
                                ->getTipohospedajeList(), $dbAdapter);
        
        $col = new Column\Select('id_tipo');
        $col->setLabel('id');
        $col->setWidth(25);
        $col->setIdentity(true);
        $col->setSortDefault(1, 'ASC');
        $grid->addColumn($col);
        
        $col = new Column\Select('descripcion_tipo');
        $col->setLabel('Tipo Hospedaje');
        $col->setWidth(75);
        $grid->addColumn($col);
        
        $editBtn = new Column\Action\Button();
        $editBtn->setLabel(' ');
        $editBtn->setAttribute('class', 'btn btn-primary glyphicon glyphicon-edit');
        $editBtn->setAttribute('href', '/dashboard/tipohospedaje/edit/id/' . $editBtn->getRowIdPlaceholder());
        $editBtn->setAttribute('data-toggle', 'tooltip');
        $editBtn->setAttribute('data-placement', 'left');
        $editBtn->setAttribute('title', 'Modificar Tipo Hospedaje');
        
        $delBtn = new Column\Action\Button();
        $delBtn->setLabel(' ');
        $delBtn->setAttribute('class', 'btn btn-danger glyphicon glyphicon-trash');
        $delBtn->setAttribute('href', '/dashboard/tipohospedaje/delete/id/' . $delBtn->getRowIdPlaceholder());
        $delBtn->setAttribute('data-toggle', 'tooltip');
        $delBtn->setAttribute('data-placement', 'left');
        $delBtn->setAttribute('title', 'Eliminar Tipo Hospedaje');

        
        $col = new Column\Action();
        $col->addAction($editBtn);
        $col->addAction($delBtn);
        $grid->addColumn($col);
        
        return $grid->getResponse();
    }
    
    public function deleteAction()
    {
        $sl = $this->getServiceLocator();
        $tipohospedajeId = $this->params('id');
        $userTable = $sl->get('Dashboard\Model\HostipohospedajeTable');
        $userTable->deleteTipohospedaje($tipohospedajeId);
        $this->redirect()->toRoute('dash_tipohospedaje_list');
    }
    
    public function editAction()
    {
        $tipohospedajeId = $this->params('id');
        $request = $this->getRequest();
        $viewmodel = new ViewModel();
        $sl = $this->getServiceLocator();
        $tipohospedajeTable = $sl->get('Dashboard\Model\HostipohospedajeTable');
        
        $form = new TipohospedajeForm($tipohospedajeTable);
        
        if ($request->isPost()) {
            // @TODO addfilters
            //$form->setInputFilter($filters);
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $data = $form->getData();
                unset($data['submit']);
                unset($data['btn-regresar']);
                $dataId = array('id_tipo' => $tipohospedajeId);
                $tipohospedajeTable->editTipohospedaje($data, $dataId);
            }
        } else {
            $tipohospedajeData = $tipohospedajeTable->getTipohospedaje($tipohospedajeId);
            foreach ($tipohospedajeData as $tipohospedaje) {
                $form->get('id_tipo')->setValue($tipohospedaje['id_tipo']);
                $form->get('descripcion_tipo')->setValue($tipohospedaje['descripcion_tipo']);
            }
        }
       
        $viewmodel->form = $form;
        return $viewmodel;
    }
}
