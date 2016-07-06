<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Dashboard\Controller;

use Dashboard\Form\CategoriahabitacionForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use ZfcDatagrid\Column;
/**
 * Description of CategoriahabitacionController
 *
 * @author Administrador
 */
class CategoriahabitacionController extends AbstractActionController {
    //put your code here
    public function indexAction()
    {   
        $viewmodel = new ViewModel();
        $form = new CategoriahabitacionForm();
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
                $categoriahabitacionTable = $serviceLocator->get('Dashboard\Model\HoscategoriahabitacionTable');
                unset($data['submit']);
                unset($data['btn-regresar']);
                $rs = $categoriahabitacionTable->addCategoriahabitacion($data);
                
                if ($rs) {
                    //$form = new CategoriahabitacionForm();
                    $this->redirect()->toRoute('dash_categoriahabitacion_edit', array('id' => $rs));
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
                $this->redirect()->toRoute('dash_categoriahabitacion');
            }
        }
        
        $sl = $this->getServiceLocator();
        $dbAdapter = $sl->get('Zend\Db\Adapter\Adapter');
        $grid = $sl->get('ZfcDatagrid\Datagrid');
        $grid->setDefaultItemsPerPage(5);
        $grid->setToolbarTemplate('layout/list-toolbar');
        $grid->setDataSource($sl->get('Dashboard\Model\HoscategoriahabitacionTable')
                                ->getCategoriahabitacionList(), $dbAdapter);
        
        $col = new Column\Select('id_categoria');
        $col->setLabel('id');
        $col->setWidth(25);
        $col->setIdentity(true);
        $col->setSortDefault(1, 'ASC');
        $grid->addColumn($col);
        
        $col = new Column\Select('descripcion_categoria');
        $col->setLabel('Tipo Habitación');
        $col->setWidth(50);
        $grid->addColumn($col);
        
        $col = new Column\Select('personas_categoria');
        $col->setLabel('Cantidad Personas');
        $col->setWidth(25);
        $grid->addColumn($col);
        
        $editBtn = new Column\Action\Button();
        $editBtn->setLabel(' ');
        $editBtn->setAttribute('class', 'btn btn-primary glyphicon glyphicon-edit');
        $editBtn->setAttribute('href', '/dashboard/categoriahabitacion/edit/id/' . $editBtn->getRowIdPlaceholder());
        $editBtn->setAttribute('data-toggle', 'tooltip');
        $editBtn->setAttribute('data-placement', 'left');
        $editBtn->setAttribute('title', 'Modificar Tipo Hospedaje');
        
        $delBtn = new Column\Action\Button();
        $delBtn->setLabel(' ');
        $delBtn->setAttribute('class', 'btn btn-danger glyphicon glyphicon-trash');
        $delBtn->setAttribute('href', '/dashboard/categoriahabitacion/delete/id/' . $delBtn->getRowIdPlaceholder());
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
        $categoriahabitacionId = $this->params('id');
        $userTable = $sl->get('Dashboard\Model\HoscategoriahabitacionTable');
        $userTable->deleteCategoriahabitacion($categoriahabitacionId);
        $this->redirect()->toRoute('dash_categoriahabitacion_list');
    }
    
    public function editAction()
    {
        $categoriahabitacionId = $this->params('id');
        $request = $this->getRequest();
        $viewmodel = new ViewModel();
        $sl = $this->getServiceLocator();
        $categoriahabitacionTable = $sl->get('Dashboard\Model\HoscategoriahabitacionTable');
        
        $form = new CategoriahabitacionForm($categoriahabitacionTable);
        
        if ($request->isPost()) {
            // @TODO addfilters
            //$form->setInputFilter($filters);
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $data = $form->getData();
                unset($data['submit']);
                unset($data['btn-regresar']);
                $dataId = array('id_categoria' => $categoriahabitacionId);
                $categoriahabitacionTable->editCategoriahabitacion($data, $dataId);
            }
        } else {
            $categoriahabitacionData = $categoriahabitacionTable->getCategoriahabitacion($categoriahabitacionId);
            foreach ($categoriahabitacionData as $categoriahabitacion) {
                $form->get('id_categoria')->setValue($categoriahabitacion['id_categoria']);
                $form->get('descripcion_categoria')->setValue($categoriahabitacion['descripcion_categoria']);
                $form->get('personas_categoria')->setValue($categoriahabitacion['personas_categoria']);
            }
        }
       
        $viewmodel->form = $form;
        return $viewmodel;
    }
}
