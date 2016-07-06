<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Dashboard\Controller;

use DOMPDFModule\View\Model\PdfModel;
use Dashboard\Form\PagobancarioForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use ZfcDatagrid\Column;
use Zend\Session\Container;
use Zend\Json\Json;
use Zend\Stdlib\ArrayUtils;
use Application\Services\Variados;
/**
 * Description of PagobancarioController
 *
 * @author Administrador
 */
class PagobancarioController extends AbstractActionController {
    //put your code here
    

    public function listAction() {
        $request = $this->getRequest();

        if ($request->isPost()) {
            $postData = $request->getPost();
            if ($postData->btnAdd === 'add') {
                $this->redirect()->toRoute('dash_empresa');
            }
        }

        $sl = $this->getServiceLocator();
        $dbAdapter = $sl->get('Zend\Db\Adapter\Adapter');
        $grid = $sl->get('ZfcDatagrid\Datagrid');
        $grid->setDefaultItemsPerPage(10);
        $grid->setToolbarTemplate('layout/list-toolbar');
        $grid->setDataSource($sl->get('Dashboard\Model\CupcuponTable')->getPagobancarioList());
        
        $col = new Column\Select('id_cupon');
        $col->setLabel('id');
        $col->setWidth(15);
        $col->setIdentity(true);
        $col->setSortDefault(1, 'ASC');
        $grid->addColumn($col);
        
        $col = new Column\Select('transaccion');
        $col->setLabel('Transacción');
        $col->setWidth(10);
        $grid->addColumn($col);
        
        $col = new Column\Select('tipo');
        $col->setHidden();
        $col->setWidth(1);
        $style = new Column\Style\BackgroundColor(array(
            183,
            249,
            188
        ));
        $style->addByValue($col, '1');
        $grid->addRowStyle($style);
        $grid->addColumn($col);
        
        
        $col = new Column\Select('campana_descripcion');
        $col->setLabel('Detalle Compra');
        $col->setWidth(15);
        $grid->addColumn($col);
        
        $col = new Column\Select('cantidad');
        $col->setLabel('Cupones');
        $col->setWidth(10);
        $grid->addColumn($col);

        $col = new Column\Select('precio_total');
        $col->setLabel('Precio Total');
        $col->setWidth(10);
        $grid->addColumn($col);

        $col = new Column\Select('fecha_compra');
        $col->setLabel('Fecha Registro');
        $col->setWidth(7);
        $grid->addColumn($col);
        
        $col = new Column\Select('num_operacion');
        $col->setLabel('Operación');
        $col->setWidth(10);
        $grid->addColumn($col);
        
        $col = new Column\Select('fec_operacion');
        $col->setLabel('Fecha Operación');
        $col->setWidth(7);
        $grid->addColumn($col);

        $conBtn = new Column\Action\Button();
        $conBtn->setLabel(' ');
        $conBtn->setAttribute('class', 'btn btn-success glyphicon glyphicon-usd');
        $conBtn->setAttribute('href', 'javascript:registrarpagobancario('.$conBtn->getRowIdPlaceholder().');');
        $conBtn->setAttribute('data-toggle', 'tooltip');
        $conBtn->setAttribute('data-placement', 'left');
        $conBtn->setAttribute('title', 'Confirmar Pago');
        
        $vouBtn = new Column\Action\Button();
        $vouBtn->setLabel(' ');
        $vouBtn->setAttribute('class', 'btn btn-info glyphicon glyphicon-envelope');
        $vouBtn->setAttribute('href', 'javascript:enviarcupones('.$vouBtn->getRowIdPlaceholder().');');
        $vouBtn->setAttribute('data-toggle', 'tooltip');
        $vouBtn->setAttribute('data-placement', 'left');
        $vouBtn->setAttribute('title', 'Enviar Cupones');

        $col = new Column\Action();
        $col->addAction($conBtn);
        $col->addAction($vouBtn);
        $grid->addColumn($col);

        return $grid->getResponse();
        
    }

    public function prepagadoAction() {
        
        $id = $this->params()->fromPost("id", null);
        
        $serviceLocator = $this->getServiceLocator();
        $cuponTable = $serviceLocator->get('Dashboard\Model\CupcuponTable');
        $prepagado = $cuponTable->getCuponPrepagado($id);
        
        if( count($prepagado) > 0) {
            $pagado = 1; 
            $operacion = $prepagado[0]['operacion'];
            $fecha_operacion =  $prepagado[0]['fecha_operacion'];
        } else {
            $pagado = -1;
            $operacion = '';
            $fecha_operacion =  '';
        }
        
        return $this->getResponse()->setContent(Json::encode(array('pagado' => $pagado,
                                                                   'operacion' => $operacion,
                                                                   'fecha_operacion' => $fecha_operacion)));
        
    }
    
    public function registrarpagobancarioAction(){
        
        set_time_limit(0);
        
        $id_cupon = $this->params()->fromPost("id_cupon", null);
        $numero_operacion     = $this->params()->fromPost("numero_operacion", null);
        $fecha_operacion      = $this->params()->fromPost("fecha_operacion", null);
        
        $serviceLocator = $this->getServiceLocator();
        $cuponTable = $serviceLocator->get('Dashboard\Model\CupcuponTable');
        
        $set = array('observacion'      => $numero_operacion,
                     'fecha_operacion'  => $fecha_operacion,
                     'fecha_compra'     => date('Y-m-d H:i:s'),
                     'id_estado_compra' => '3'
                          );
        
        $where = array('id_cupon' => $id_cupon);
        
        $setDetalle = array('id_estado_cupon' => '3',
                            'fecha_cancelacion' => date('Y-m-d H:i:s'));
        
        $cuponTable->updCupon($set, $where);
        $cuponTable->updCuponDetalle($setDetalle, $where);
        
        $opcion_campana = $cuponTable->getDatosOrden($id_cupon);
        
        if (count($opcion_campana) > 0 ) {
            
            $campanaopcionTable = $serviceLocator->get('Dashboard\Model\CupcampanaopcionTable');
            $campanaopcionTable->updCantidadVendidos($opcion_campana[0]['id_campana'], $opcion_campana[0]['id_campana_opcion'], $opcion_campana[0]['cantidad']);
        
            /*Enviamos el correo*/
            $datosCupon = $cuponTable->getCupon($id_cupon);
            $variados = new Variados($serviceLocator);
            $variados->obtenerCuponPdf($datosCupon);
            /********************/
            
            return $this->getResponse()->setContent(Json::encode(array('respuesta' => 1)));
            
        } else {

            return $this->getResponse()->setContent(Json::encode(array('respuesta' => -1)));
            
        }
        
    }
    
    public function reenviarvoucherAction() {
        
            $id_cupon = $this->params()->fromPost("id_cupon", null);
            $email    = $this->params()->fromPost("email", null);
            
            $serviceLocator = $this->getServiceLocator();
            $cuponTable = $serviceLocator->get('Dashboard\Model\CupcuponTable');
        
            /*Enviamos el correo*/
            $datosCupon = $cuponTable->getCupon($id_cupon);
            if( !empty($email) ) {
                for($i=0;$i<count($datosCupon);$i++) {
                     $datosCupon[$i]['email_cliente'] = $email;
                }
            }

            $variados = new Variados($serviceLocator);
            $variados->obtenerCuponPdf($datosCupon);
            /********************/
            
            return $this->getResponse()->setContent(Json::encode(array('respuesta' => 1)));
    }
    
}
