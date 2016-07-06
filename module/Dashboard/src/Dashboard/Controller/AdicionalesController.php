<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Dashboard\Controller;

use Dashboard\Form\AdicionalesForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use ZfcDatagrid\Column;
/**
 * Description of AdicionalesController
 *
 * @author Administrador
 */
class AdicionalesController extends AbstractActionController {
    //put your code here
    public function indexAction()
    {   
        $viewmodel = new ViewModel();
        $serviceLocator = $this->getServiceLocator();
        $adicionalesTable = $serviceLocator->get('Dashboard\Model\HosadicionalesTable');
        $tipoadicionalTable = $serviceLocator->get('Dashboard\Model\HostipoadicionalTable');
        $form = new AdicionalesForm($tipoadicionalTable);
        $request = $this->getRequest();
        
        $form->get('submit');
        $message = ""; //Message
        
        if ($request->isPost()) {
            // @TODO addfilters
            //$form->setInputFilter($filters);
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $data = $form->getData();
                
                unset($data['submit']);
                unset($data['btn-regresar']);
                $rs = $adicionalesTable->addAdicionales($data);
                
                if ($rs) {
                    //$form = new AdicionalesForm();
                    $this->redirect()->toRoute('dash_adicionales_edit', array('id' => $rs));
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
                $this->redirect()->toRoute('dash_adicionales');
            }
        }
        
        $sl = $this->getServiceLocator();
        $dbAdapter = $sl->get('Zend\Db\Adapter\Adapter');
        $grid = $sl->get('ZfcDatagrid\Datagrid');
        $grid->setDefaultItemsPerPage(5);
        $grid->setToolbarTemplate('layout/list-toolbar');
        $grid->setDataSource($sl->get('Dashboard\Model\HosadicionalesTable')
                                ->getAdicionalesList(), $dbAdapter);
        
        $col = new Column\Select('id_adicionales');
        $col->setLabel('id');
        $col->setWidth(25);
        $col->setIdentity(true);
        $col->setSortDefault(1, 'ASC');
        $grid->addColumn($col);
        
        $col = new Column\Select('descripcion_adicionales');
        $col->setLabel('Adicional Establecimiento');
        $col->setWidth(40);
        $grid->addColumn($col);
        
        $col = new Column\Select('descripcion_tipo_adicional');
        $col->setLabel('Tipo');
        $col->setWidth(35);
        $grid->addColumn($col);
        
        $editBtn = new Column\Action\Button();
        $editBtn->setLabel(' ');
        $editBtn->setAttribute('class', 'btn btn-primary glyphicon glyphicon-edit');
        $editBtn->setAttribute('href', '/dashboard/adicionales/edit/id/' . $editBtn->getRowIdPlaceholder());
        $editBtn->setAttribute('data-toggle', 'tooltip');
        $editBtn->setAttribute('data-placement', 'left');
        $editBtn->setAttribute('title', 'Modificar Tipo Hospedaje');
        
        $delBtn = new Column\Action\Button();
        $delBtn->setLabel(' ');
        $delBtn->setAttribute('class', 'btn btn-danger glyphicon glyphicon-trash');
        $delBtn->setAttribute('href', '/dashboard/adicionales/delete/id/' . $delBtn->getRowIdPlaceholder());
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
        $adicionalesId = $this->params('id');
        $userTable = $sl->get('Dashboard\Model\HosadicionalesTable');
        $userTable->deleteAdicionales($adicionalesId);
        $this->redirect()->toRoute('dash_adicionales_list');
    }
    
    public function editAction()
    {
        $adicionalesId = $this->params('id');
        $request = $this->getRequest();
        $viewmodel = new ViewModel();
        $sl = $this->getServiceLocator();
        $adicionalesTable = $sl->get('Dashboard\Model\HosadicionalesTable');
        $tipoadicionalTable = $sl->get('Dashboard\Model\HostipoadicionalTable');
        
        $form = new AdicionalesForm($tipoadicionalTable);
        
        if ($request->isPost()) {
            // @TODO addfilters
            //$form->setInputFilter($filters);
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $data = $form->getData();
                unset($data['submit']);
                unset($data['btn-regresar']);
                $dataId = array('id_adicionales' => $adicionalesId);
                $adicionalesTable->editAdicionales($data, $dataId);
            }
        } else {
            $adicionalesData = $adicionalesTable->getAdicionales($adicionalesId);
            foreach ($adicionalesData as $adicionales) {
                $form->get('id_adicionales')->setValue($adicionales['id_adicionales']);
                $form->get('id_tipo_adicional')->setValue($adicionales['id_tipo_adicional']);
                $form->get('descripcion_adicionales')->setValue($adicionales['descripcion_adicionales']);
            }
        }
       
        $viewmodel->form = $form;
        return $viewmodel;
    }
}
