<?php

/**
 * LiquidacionController - This allows add, delete and edit users
 * @autor Francis Gonzales <fgonzalestello91@gmail.com>
 */

namespace Dashboard\Controller;

use Dashboard\Form\LiquidacionForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use ZfcDatagrid\Column;
use Zend\Session\Container;
use Zend\Json\Json;

class LiquidacionController extends AbstractActionController
{
    public function indexAction()
    {
        $viewmodel = new ViewModel();
        $sl = $this->getServiceLocator();
        $empresaTable = $sl->get('Dashboard/Model/GenempresaTable');
        $form = new LiquidacionForm($empresaTable);
        $request = $this->getRequest();
        $serviceLocator = $this->getServiceLocator();
        $form->get('submit');
        $message = ""; //Message
        
        if ($request->isPost()) {
            // @TODO addfilters
            //$form->setInputFilter($filters);
            $form->setData($request->getPost());
            if ($form->isValid()) {
                //echo $data['id_liquidacion'];
                $data = $form->getData();
                $liquidacionTable = $serviceLocator->get('Dashboard\Model\CupliquidacionTable');
                unset($data['submit']);
                $rs = $liquidacionTable->addLiquidacion($data);
                if ($rs) {
                    //$form = new LiquidacionForm($empresaTable);
                    $this->redirect()->toRoute('dash_liquidacion_edit',array('id' => $rs));
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
                $this->redirect()->toRoute('dash_liquidacion');
            }
        }
        
        $sl = $this->getServiceLocator();
        $dbAdapter = $sl->get('Zend\Db\Adapter\Adapter');
        $grid = $sl->get('ZfcDatagrid\Datagrid');
        $grid->setDefaultItemsPerPage(5);
        $grid->setToolbarTemplate('layout/list-toolbar');
        $grid->setDataSource($sl->get('Dashboard\Model\CupliquidacionTable')
                                ->getLiquidacionList(), $dbAdapter);
        
        $col = new Column\Select('id_liquidacion', 'c');
        $col->setLabel('id');
        $col->setWidth(25);
        $col->setIdentity(true);
        $col->setSortDefault(1, 'ASC');
        $grid->addColumn($col);
        
        $col = new Column\Select('titulo', 'c');
        $col->setLabel('Titulo');
        $col->setWidth(25);
        $grid->addColumn($col);
        
        $col = new Column\Select('subtitulo', 'c');
        $col->setLabel('Sub-Titulo');
        $col->setWidth(25);
        $grid->addColumn($col);
        
        
        $col = new Column\Select('razon_social', 'e');
        $col->setLabel('Empresa');
        $col->setWidth(25);
        $grid->addColumn($col);
             
        $editBtn = new Column\Action\Button();
        $editBtn->setLabel('Edit');
        $editBtn->setAttribute('class', 'btn btn-primary');
        $editBtn->setAttribute('href', '/dashboard/liquidacion/edit/id/' . $editBtn->getRowIdPlaceholder());
        
        $delBtn = new Column\Action\Button();
        $delBtn->setLabel('Delete');
        $delBtn->setAttribute('class', 'btn btn-danger');
        $delBtn->setAttribute('href', '/dashboard/liquidacion/delete/id/' . $delBtn->getRowIdPlaceholder());
        
        $col = new Column\Action();
        $col->addAction($editBtn);
        $col->addAction($delBtn);
        $grid->addColumn($col);
        
        return $grid->getResponse();
    }
    
    public function editAction()
    {
        $serviceLocator = $this->getServiceLocator();
        
        $config = $serviceLocator->get('Config');
        $dir_image = $config['constantes']['dir_image'];
        
        
        
        $liquidacionId = $this->params('id');
        
        $edit_liquidacion = new Container('edit_liquidacion');
        $edit_liquidacion->id = $liquidacionId;
        
        $request = $this->getRequest();
        $viewmodel = new ViewModel(array('dir_image' => $dir_image));
        $sl = $this->getServiceLocator();
        $empresaTable = $sl->get('Dashboard\Model\GenempresaTable');
        $liquidacionTable = $sl->get('Dashboard\Model\CupliquidacionTable');
        $liquidacionOpcionTable = $sl->get('Dashboard\Model\CupliquidacionopcionTable');
        $liquidacionCategoriaTable = $sl->get('Dashboard\Model\CupliquidacioncategoriaTable');
        
        $form = new LiquidacionForm($empresaTable);
        
        if ($request->isPost()) {
            // @TODO addfilters
            //$form->setInputFilter($filters);
            $dataPost = $request->getPost();
            $form->setData($dataPost);
            if ($form->isValid()) {
                $data = $form->getData();
                unset($data['submit']);
                $dataId = array('id_liquidacion' => $liquidacionId);
                $liquidacionTable->editLiquidacion($data, $dataId);
                
                if(trim($dataPost["id_categoria"]) != '') {
                    $liquidacionCategoriaTable->savecategorias($dataPost["id_categoria"], $liquidacionId);
                }
                
            }
        } else {
            $liquidacionData = $liquidacionTable->getLiquidacion($liquidacionId);
            foreach ($liquidacionData as $liquidacion) {
                $form->get('id_liquidacion')->setValue($liquidacion['id_liquidacion']);
                $form->get('titulo')->setValue($liquidacion['titulo']);
                $form->get('subtitulo')->setValue($liquidacion['subtitulo']);
                $form->get('descripcion')->setValue($liquidacion['descripcion']);
                $form->get('id_empresa')->setValue($liquidacion['id_empresa']);
                $form->get('fecha_inicio')->setValue($liquidacion['fecha_inicio']);
                $form->get('hora_inicio')->setValue($liquidacion['hora_inicio']);
                $form->get('fecha_final')->setValue($liquidacion['fecha_final']);
                $form->get('hora_final')->setValue($liquidacion['hora_final']);
                $form->get('fecha_validez')->setValue($liquidacion['fecha_validez']);
            }
        }
        
        $opciones = $liquidacionOpcionTable->getOpcionxLiquidacionAll($liquidacionId);
        $opcionLiquidacion = array();
        foreach ($opciones as $opcion) {
            $opcionLiquidacion[] = $opcion;
        }
        
        $categorias = $liquidacionCategoriaTable->getcategoriaxliquidacion($liquidacionId);
        $categoriaLiquidacion = array();
        foreach ($categorias as $categoria) {
            $categoriaLiquidacion[] = $categoria;
        }
       
        $viewmodel->form = $form;
        $viewmodel->setVariable('opciones', $opcionLiquidacion);
        $viewmodel->setVariable('categorias', $categoriaLiquidacion);
        
        return $viewmodel;
    }
    
   /* public function deleteAction()
    {
        $sl = $this->getServiceLocator();
        $userId = $this->params('id');
        $userTable = $sl->get('Dashboard\Model\LiquidacionTable');
        $userTable->deleteLiquidacion($userId);
        $this->redirect()->toRoute('dash_user_list');
    }*/
    
    public function inicioAction()
    {
        $request = $this->getRequest();
        
        return new ViewModel();
    }
    
    public function cuponAction() {
        $cupon = $this->params()->fromPost("cupon",null);
        $tipo = $this->params()->fromPost("tipo",null);
        
        $serviceLocator = $this->getServiceLocator();
        $cuponTable = $serviceLocator->get('Dashboard\Model\CupcuponTable');

        $datos = $cuponTable->validarCupon($cupon, $tipo);
        
        $viewmodel = new ViewModel(array('datos' => $datos));
        $viewmodel->setTerminal(true);
        return $viewmodel;
    }
    
    public function editopcionAction(){
        
        $opcion = $this->params()->fromPost("opcion",null);
        $liquidacion = $this->params()->fromPost("liquidacion",null);
        
        
        $serviceLocator = $this->getServiceLocator();
        $liquidacionOpcionTable = $serviceLocator->get('Dashboard\Model\CupliquidacionopcionTable');
        
        $opciones = $liquidacionOpcionTable->getOpcionxLiquidacionId($opcion, $liquidacion);
        
        $datos = array();
        foreach ($opciones as $opc) {
            $datos[] = $opc;
        }
        
        //$datos = array('opcion' => $opcion, 'liquidacion' => $liquidacion);
        
        return $this->getResponse()->setContent(Json::encode($datos));
    }
    
    public function saveopcionAction(){
        
        $id_liquidacion_opcion = $this->params()->fromPost("id_liquidacion_opcion",null);
        $id_liquidacion = $this->params()->fromPost("id_liquidacion",null);
        $descripcion = $this->params()->fromPost("descripcion",null);
        $precio_regular = $this->params()->fromPost("precio_regular",null);
        $precio_especial = $this->params()->fromPost("precio_especial",null);
        
        $data = array('id_liquidacion_opcion' => $id_liquidacion_opcion,
                      'id_liquidacion' => $id_liquidacion,
                      'descripcion' => $descripcion,
                      'precio_regular' => $precio_regular,
                      'precio_especial' => $precio_especial
            );
        
        $serviceLocator = $this->getServiceLocator();
        $liquidacionOpcionTable = $serviceLocator->get('Dashboard\Model\CupliquidacionopcionTable');
        
        $datos = $liquidacionOpcionTable->addOpcionxLiquidacion($data);
        
        
        return $this->getResponse()->setContent(Json::encode($datos));
    }
}
