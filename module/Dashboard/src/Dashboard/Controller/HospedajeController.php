<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Dashboard\Controller;

use Dashboard\Form\HospedajeForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use ZfcDatagrid\Column;
/**
 * Description of HospedajeController
 *
 * @author Administrador
 */
class HospedajeController extends AbstractActionController {
    //put your code here
    public function indexAction()
    {   
        $viewmodel = new ViewModel();
        $serviceLocator = $this->getServiceLocator();
        $hospedajeTable = $serviceLocator->get('Dashboard\Model\HoshospedajeTable');
        $tipohospedajeTable = $serviceLocator->get('Dashboard\Model\HostipohospedajeTable');
        $paisTable = $serviceLocator->get('Dashboard\Model\UbipaisTable');
        $departamentoTable = $serviceLocator->get('Dashboard\Model\UbidepartamentoTable');
        
        $request = $this->getRequest();
        $postData = $request->getPost(); 
        $id_pais = $postData->id_pais;
        
        $form = new HospedajeForm($tipohospedajeTable,
                                  $paisTable,
                                  $departamentoTable,
                                  $id_pais);
        
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
                $rs = $hospedajeTable->addHospedaje($data);
                
                if ($rs) {
                    //$form = new HospedajeForm();
                    $this->redirect()->toRoute('dash_hospedaje_edit', array('id' => $rs));
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
                $this->redirect()->toRoute('dash_hospedaje');
            }
        }
        
        $sl = $this->getServiceLocator();
        $dbAdapter = $sl->get('Zend\Db\Adapter\Adapter');
        $grid = $sl->get('ZfcDatagrid\Datagrid');
        $grid->setDefaultItemsPerPage(5);
        $grid->setToolbarTemplate('layout/list-toolbar');
        $grid->setDataSource($sl->get('Dashboard\Model\HoshospedajeTable')
                                ->getHospedajeList(), $dbAdapter);
        
        $col = new Column\Select('id_hospedaje');
        $col->setLabel('id');
        $col->setWidth(25);
        $col->setIdentity(true);
        $col->setSortDefault(1, 'ASC');
        $grid->addColumn($col);
        
        $col = new Column\Select('descripcion_hospedaje');
        $col->setLabel('Adicional Establecimiento');
        $col->setWidth(40);
        $grid->addColumn($col);
        
        $col = new Column\Select('descripcion_tipo');
        $col->setLabel('Tipo');
        $col->setWidth(35);
        $grid->addColumn($col);
        
        $editBtn = new Column\Action\Button();
        $editBtn->setLabel(' ');
        $editBtn->setAttribute('class', 'btn btn-primary glyphicon glyphicon-edit');
        $editBtn->setAttribute('href', '/dashboard/hospedaje/edit/id/' . $editBtn->getRowIdPlaceholder());
        $editBtn->setAttribute('data-toggle', 'tooltip');
        $editBtn->setAttribute('data-placement', 'left');
        $editBtn->setAttribute('title', 'Modificar Tipo Hospedaje');
        
        $delBtn = new Column\Action\Button();
        $delBtn->setLabel(' ');
        $delBtn->setAttribute('class', 'btn btn-danger glyphicon glyphicon-trash');
        $delBtn->setAttribute('href', '/dashboard/hospedaje/delete/id/' . $delBtn->getRowIdPlaceholder());
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
        $hospedajeId = $this->params('id');
        $userTable = $sl->get('Dashboard\Model\HoshospedajeTable');
        $userTable->deleteHospedaje($hospedajeId);
        $this->redirect()->toRoute('dash_hospedaje_list');
    }
    
    public function editAction()
    {
        $hospedajeId = $this->params('id');
        $request = $this->getRequest();
        $viewmodel = new ViewModel();
        $sl = $this->getServiceLocator();
        $hospedajeTable = $sl->get('Dashboard\Model\HoshospedajeTable');
        $tipohospedajeTable = $sl->get('Dashboard\Model\HostipohospedajeTable');
        $categoriahabitacionTable = $sl->get('Dashboard\Model\HoscategoriahabitacionTable');
        $paisTable = $sl->get('Dashboard\Model\UbipaisTable');
        $departamentoTable = $sl->get('Dashboard\Model\UbidepartamentoTable');
        
        $hospedajeData = $hospedajeTable->getHospedaje($hospedajeId);
        foreach ($hospedajeData as $hospedaje) {
            $id_pais = $hospedaje['id_pais'];
        }
        
        $form = new HospedajeForm($tipohospedajeTable,
                                  $paisTable,
                                  $departamentoTable,
                                  $id_pais);
        
        if ($request->isPost()) {
            // @TODO addfilters
            //$form->setInputFilter($filters);
            $dataPost = $request->getPost();
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $data = $form->getData();
                unset($data['submit']);
                unset($data['btn-regresar']);
                $dataId = array('id_hospedaje' => $hospedajeId);
                $hospedajeTable->editHospedaje($data, $dataId);
                
                $hospedajeTable->saveAdicionalesHospedaje($dataPost["id_adicionales_hospedaje"], $hospedajeId);
            }
        } else {
            $hospedajeData = $hospedajeTable->getHospedaje($hospedajeId);
            foreach ($hospedajeData as $hospedaje) {
                $form->get('id_hospedaje')->setValue($hospedaje['id_hospedaje']);
                $form->get('id_tipo')->setValue($hospedaje['id_tipo']);
                $form->get('descripcion_hospedaje')->setValue($hospedaje['descripcion_hospedaje']);
                $form->get('id_pais')->setValue($hospedaje['id_pais']);
                $form->get('id_departamento')->setValue($hospedaje['id_departamento']);
                $form->get('categoria_hospedaje')->setValue($hospedaje['categoria_hospedaje']);
                $form->get('direccion_hospedaje')->setValue($hospedaje['direccion_hospedaje']);
                $form->get('telefono_hospedaje')->setValue($hospedaje['telefono_hospedaje']);
                $form->get('observacion')->setValue($hospedaje['observacion']);
                $form->get('email_confirmacion')->setValue($hospedaje['email_confirmacion']);
            }
        }
       
        $adicionales = $hospedajeTable->getAdicionalesxHospedajeAll($hospedajeId);
        $adicionalesHospedaje = array();
        foreach ($adicionales as $adicional) {
            $adicionalesHospedaje[] = $adicional;
        }
        
        $categorias = $hospedajeTable->getCategoriasxHospedajeAll($hospedajeId);
        $categoriasHospedaje = array();
        foreach ($categorias as $categoria) {
            $adicionales_habitacion = $hospedajeTable->getAdicionalesxHabitacion($hospedajeId, $categoria['id_categoria']);
            $categoria['adicionales'] = $adicionales_habitacion;
            $categoriasHospedaje[] = $categoria;
        }
        
        $categoriasHabitacion = $categoriahabitacionTable->fetchAll();
        $categoriaHabitacion = array();
        foreach ($categoriasHabitacion as $categoria) {
            $categoriaHabitacion[] = $categoria;
        }

        $viewmodel->form = $form;
        $viewmodel->setVariable('adicionalesHospedaje', $adicionalesHospedaje);
        $viewmodel->setVariable('categoriasHospedaje',  $categoriasHospedaje);
        $viewmodel->setVariable('categoriaHabitacion',  $categoriaHabitacion);
        
        return $viewmodel;
    }
    
    public function adicionalesHabitacionAction()  {
        
        $hospedaje   = $this->params()->fromPost("id_hospedaje", null);
        $categoria   = $this->params()->fromPost("id_categoria", null);
        
        if ( empty($hospedaje) || $hospedaje == '' ) $hospedaje = 0;
        if ( empty($categoria) || $categoria == '' ) $categoria = 0;
        
        $serviceLocator = $this->getServiceLocator();
   
        $hospedajeTable = $serviceLocator->get('Dashboard\Model\HoshospedajeTable');
        $adicionales = $hospedajeTable->getAdicionalesxHabitacionAll($hospedaje,$categoria);
        
        $viewmodel = new ViewModel(array('adicionales' => $adicionales));
        $viewmodel->setTerminal(true);
        
        return $viewmodel;
    }
    
    public function categoriasHospedajeAction()  {
        
        $hospedajeId   = $this->params()->fromPost("id_hospedaje", null);
        if ( empty($hospedajeId) || $hospedajeId == '' ) $hospedajeId = 0;
        
        $serviceLocator = $this->getServiceLocator();
   
        $hospedajeTable = $serviceLocator->get('Dashboard\Model\HoshospedajeTable');
        $categorias = $hospedajeTable->getCategoriasxHospedajeAll($hospedajeId);
        
        $viewmodel = new ViewModel(array('categorias' => $categorias));
        $viewmodel->setTerminal(true);
        
        return $viewmodel;
    }
    
    public function saveHabitacionAction()  {
        
        $hospedaje   = $this->params()->fromPost("id_hospedaje", null);
        $categoria   = $this->params()->fromPost("id_categoria", null);
        $importe     = $this->params()->fromPost("importe_habitacion", null);
        $adicionales = $this->params()->fromPost("adicionales_habitacion", null);
        $tipo        = $this->params()->fromPost("tipo_registro", null);
        
        
        $serviceLocator = $this->getServiceLocator();
        
        $hospedajecategoriaTable = $serviceLocator->get('Dashboard\Model\HoshospedajecategoriaTable');
        $hospedajeadicionalesTable = $serviceLocator->get('Dashboard\Model\HoshabitacionadicionalesTable');
        
        if( $tipo == 'N') {
            $hospedajeCategoria = array('id_hospedaje' => $hospedaje,
                                        'id_categoria' => $categoria,
                                        'importe_habitacion' => $importe);

            $hospedajecategoriaTable->addHospedajeCategoria($hospedajeCategoria);
        } else {
            $set   = array('importe_habitacion' => $importe);
            
            $where = array('id_hospedaje' => $hospedaje,
                           'id_categoria' => $categoria);

            $hospedajecategoriaTable->editHospedajeCategoria($set, $where);
            
            $hospedajeadicionalesTable->deleteHabitacionAdicionales($hospedaje, $categoria);
        }
        
        foreach( $adicionales as $adicional) {
            $habitacionAdicional = array('id_hospedaje'   => $hospedaje,
                                         'id_categoria'   => $categoria,
                                         'id_adicionales' => $adicional['value']);

            $hospedajeadicionalesTable->addHabitacionAdicionales($habitacionAdicional);

        }
        
        return $this->getResponse()->setContent(Json::encode(array('respuesta' => $tipo)));
    }
}
