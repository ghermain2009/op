<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Dashboard\Controller;

use Dashboard\Form\VoucherForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use ZfcDatagrid\Column;
use DOMPDFModule\View\Model\PdfModel;
/**
 * Description of VoucherController
 *
 * @author Administrador
 */
class VoucherController extends AbstractActionController {
    //put your code here
    public function indexAction()
    {   
        $viewmodel = new ViewModel();
        $serviceLocator = $this->getServiceLocator();
        $hospedajeTable = $serviceLocator->get('Dashboard\Model\HoshospedajeTable');
        
        $request = $this->getRequest();
        $postData = $request->getPost(); 
        $id_hospedaje = $postData->id_hospedaje;
        
        $form = new VoucherForm($hospedajeTable,
                                $id_hospedaje);
        
        
        $form->get('submit');
        $message = ""; //Message
        
        if ($request->isPost()) {
            // @TODO addfilters
            //$form->setInputFilter($filters);
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $data = $form->getData();
                $voucherTable = $serviceLocator->get('Dashboard\Model\HosvoucherTable');
                unset($data['submit']);
                unset($data['btn-regresar']);
                $rs = $voucherTable->addVoucher($data);
                
                if ($rs) {
                    //$form = new VoucherForm();
                    $this->redirect()->toRoute('dash_voucher_edit', array('id' => $rs));
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
                $this->redirect()->toRoute('dash_voucher');
            }
        }
        
        $sl = $this->getServiceLocator();
        $dbAdapter = $sl->get('Zend\Db\Adapter\Adapter');
        $grid = $sl->get('ZfcDatagrid\Datagrid');
        $grid->setDefaultItemsPerPage(5);
        $grid->setToolbarTemplate('layout/list-toolbar');
        $grid->setDataSource($sl->get('Dashboard\Model\HosvoucherTable')
                                ->getVoucherList(), $dbAdapter);
        
        $col = new Column\Select('id_voucher');
        $col->setLabel('id');
        $col->setWidth(25);
        $col->setIdentity(true);
        $col->setSortDefault(1, 'ASC');
        $grid->addColumn($col);
        
        $col = new Column\Select('codigo_cupon');
        $col->setLabel('Numero Cupón');
        $col->setWidth(25);
        $grid->addColumn($col);
        
        $col = new Column\Select('descripcion_hospedaje');
        $col->setLabel('Hospedaje');
        $col->setWidth(25);
        $grid->addColumn($col);
        
        $col = new Column\Select('descripcion_categoria');
        $col->setLabel('Habitación');
        $col->setWidth(25);
        $grid->addColumn($col);
        
        $col = new Column\Select('nombre_pasajero');
        $col->setLabel('Pasajero');
        $col->setWidth(25);
        $grid->addColumn($col);
        
        $editBtn = new Column\Action\Button();
        $editBtn->setLabel(' ');
        $editBtn->setAttribute('class', 'btn btn-primary glyphicon glyphicon-edit');
        $editBtn->setAttribute('href', '/dashboard/voucher/edit/id/' . $editBtn->getRowIdPlaceholder());
        $editBtn->setAttribute('data-toggle', 'tooltip');
        $editBtn->setAttribute('data-placement', 'left');
        $editBtn->setAttribute('title', 'Modificar Tipo Hospedaje');
        
        /*$delBtn = new Column\Action\Button();
        $delBtn->setLabel(' ');
        $delBtn->setAttribute('class', 'btn btn-danger glyphicon glyphicon-trash');
        $delBtn->setAttribute('href', '/dashboard/voucher/delete/id/' . $delBtn->getRowIdPlaceholder());
        $delBtn->setAttribute('data-toggle', 'tooltip');
        $delBtn->setAttribute('data-placement', 'left');
        $delBtn->setAttribute('title', 'Eliminar Tipo Hospedaje');*/

        
        $col = new Column\Action();
        $col->addAction($editBtn);
        //$col->addAction($delBtn);
        $grid->addColumn($col);
        
        return $grid->getResponse();
    }
    
    public function deleteAction()
    {
        $sl = $this->getServiceLocator();
        $voucherId = $this->params('id');
        $userTable = $sl->get('Dashboard\Model\HosvoucherTable');
        $userTable->deleteVoucher($voucherId);
        $this->redirect()->toRoute('dash_voucher_list');
    }
    
    public function editAction()
    {
        $voucherId = $this->params('id');
        $request = $this->getRequest();
        $viewmodel = new ViewModel();
        $sl = $this->getServiceLocator();
        $voucherTable = $sl->get('Dashboard\Model\HosvoucherTable');
        $hospedajeTable = $sl->get('Dashboard\Model\HoshospedajeTable');
        
        $voucherData = $voucherTable->getVoucher($voucherId);
        foreach ($voucherData as $voucher) {
            $id_hospedaje = $voucher['id_hospedaje'];
        }
        
        $form = new VoucherForm($hospedajeTable,
                                $id_hospedaje);
        
        if ($request->isPost()) {
            // @TODO addfilters
            //$form->setInputFilter($filters);
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $data = $form->getData();
                unset($data['submit']);
                unset($data['btn-regresar']);
                $dataId = array('id_voucher' => $voucherId);
                $voucherTable->editVoucher($data, $dataId);
            }
        } else {
            $voucherData = $voucherTable->getVoucher($voucherId);
            foreach ($voucherData as $voucher) {
                $form->get('id_voucher')->setValue($voucher['id_voucher']);
                $form->get('codigo_cupon')->setValue($voucher['codigo_cupon']);
                $form->get('id_hospedaje')->setValue($voucher['id_hospedaje']);
                $form->get('id_categoria')->setValue($voucher['id_categoria']);
                $form->get('fecha_ingreso')->setValue($voucher['fecha_ingreso']);
                $form->get('fecha_salida')->setValue($voucher['fecha_salida']);
                $form->get('numero_dias')->setValue($voucher['numero_dias']);
                $form->get('cantidad_adultos')->setValue($voucher['cantidad_adultos']);
                $form->get('cantidad_ninos')->setValue($voucher['cantidad_ninos']);
                $form->get('cantidad_infantes')->setValue($voucher['cantidad_infantes']);
                $form->get('observacion')->setValue($voucher['observacion']);
            }
        }
       
        $viewmodel->form = $form;
        return $viewmodel;
    }
    
    public function descargaVoucherAction(){

        set_time_limit(0);
        
        $id_voucher = $this->params()->fromQuery("id_voucher", null);
        $response = $this->getResponse();
        
        $nombreDocumento = '';
        
        $serviceLocator = $this->getServiceLocator();
        $voucherTable = $serviceLocator->get('Dashboard\Model\HosvoucherTable');
        $hospedajeTable = $serviceLocator->get('Dashboard\Model\HoshospedajeTable');
        $datosVoucher = $voucherTable->getDatosVoucher($id_voucher);
        
        $config = $serviceLocator->get('Config');
        $dir_image = $config['constantes']['dir_image'];
        $sep_path  = $config['constantes']['sep_path'];
        $localhost = $config['constantes']['localhost'];
        
        //$directorio = $dir_image.$sep_path."..".$sep_path."..".$sep_path."data".$sep_path."voucher-hospedaje".$sep_path;
        
        foreach( $datosVoucher as $voucher ) {
            
            $nombreDocumento = 'RE-'.$voucher['nombre_voucher'];
            $adicionalesHospedaje  = $hospedajeTable->getAdicionalesxHospedaje($voucher['id_hospedaje']);
            $adicionalesHabitacion = $hospedajeTable->getAdicionalesxHabitacion($voucher['id_hospedaje'], $voucher['id_categoria']);
            
            $cantidad = 0;
            $adicionales = '';
            foreach( $adicionalesHospedaje as $adicional ) {
                $cantidad++;
                if( $cantidad == 1 ) {
                    $adicionales = $adicionales.$adicional['descripcion_adicionales'];
                } else {
                    $adicionales = $adicionales.' - '.$adicional['descripcion_adicionales'];
                }
            }
            
            foreach( $adicionalesHabitacion as $adicional ) {
                $cantidad++;
                if( $cantidad == 1 ) {
                    $adicionales = $adicionales.$adicional['descripcion_adicionales'];
                } else {
                    $adicionales = $adicionales.' - '.$adicional['descripcion_adicionales'];
                }
            }
            
            
            $variables = array(
                'datos_voucher' => $voucher,
                'localhost' => $localhost,
                'adicionales' => $adicionales
            );
        
            $documentoPdf = new PdfModel();
            $documentoPdf->setOption('filename', $nombreDocumento.'.pdf');
            $documentoPdf->setOption('paperOrientation', 'portrait');
            $documentoPdf->setVariables($variables);

            $documentoPdf->setTerminal(true);
            $documentoPdf->setTemplate('dashboard/voucher/voucher-pdf.phtml');
            $htmlPdf = $serviceLocator->get('viewPdfrenderer')->getHtmlRenderer()->render($documentoPdf);
            $engine = $serviceLocator->get('viewPdfrenderer')->getEngine();
            // Cargamos el HTML en DOMPDF
            $engine->load_html($htmlPdf);
            $engine->render();
            // Obtenemos el PDF en memoria
            $pdfCode = $engine->output();
            
        }
        $response->setContent($pdfCode);

        $headers = $response->getHeaders();
        $headers->clearHeaders()
                ->addHeaderLine('Content-Type', 'application/pdf')
                ->addHeaderLine('Content-Disposition', 'attachment; filename="'.$nombreDocumento.'.pdf"')
                ->addHeaderLine('Content-Length', strlen($pdfCode));


        return $this->response;
        
    }
}
