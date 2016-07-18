<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Dashboard\Controller;

use DOMPDFModule\View\Model\PdfModel;
use Dashboard\Form\EmpresaForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use ZfcDatagrid\Column;
use Zend\Session\Container;
use Zend\Json\Json;
use Zend\Stdlib\ArrayUtils;
use Zend\Mail\Message;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;
use Zend\Mail\Transport\SmtpOptions;
use Zend\View\Renderer\PhpRenderer;
use Zend\View\Resolver\TemplateMapResolver;
/**
 * Description of EmpresaController
 *
 * @author Administrador
 */
class EmpresaController extends AbstractActionController {
    //put your code here
    public function indexAction() {
        $viewmodel = new ViewModel();
        $serviceLocator = $this->getServiceLocator();
        $tipoDocumentoTable = $serviceLocator->get('Dashboard\Model\GentipodocumentoTable');
        $form = new EmpresaForm($tipoDocumentoTable);
        $request = $this->getRequest();
        
        $form->get('submit');
        $message = ""; //Message

        if ($request->isPost()) {
            // @TODO addfilters
            //$form->setInputFilter($filters);
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $data = $form->getData();
                
                $empresaTable = $serviceLocator->get('Dashboard\Model\GenempresaTable');
                unset($data['submit']);
                unset($data['btn-regresar']);
                $rs = $empresaTable->addEmpresa($data);
                if ($rs) {
                    //$form = new EmpresaForm($tipoDocumentoTable);
                    $this->redirect()->toRoute('dash_empresa_edit', array('id' => $rs));
                }
            }
        }
        $viewmodel->form = $form;
        $viewmodel->message = $message;
        return $viewmodel;
    }

    public function listAction() {
        $request = $this->getRequest();

        if ($request->isPost()) {
            $postData = $request->getPost();
            if ($postData->btnAdd === 'add') {
                $this->redirect()->toRoute('dash_empresa');
            }
        }

        $sl = $this->getServiceLocator();
        $grid = $sl->get('ZfcDatagrid\Datagrid');
        $grid->setDefaultItemsPerPage(5);
        $grid->setToolbarTemplate('layout/list-toolbar');
        $grid->setDataSource($sl->get('Dashboard\Model\GenempresaTable')->getEmpresaList());
        
        $col = new Column\Select('id_empresa');
        $col->setLabel('id');
        $col->setWidth(25);
        $col->setIdentity(true);
        $col->setSortDefault(1, 'ASC');
        $grid->addColumn($col);
        
        $col = new Column\Select('can_contrato');
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
        
        
        $col = new Column\Select('razon_social');
        $col->setLabel('Razón Social');
        $col->setWidth(15);
        $grid->addColumn($col);
        
        $col = new Column\Select('registro_contribuyente');
        $col->setLabel('RUC / CUIT');
        $col->setWidth(10);
        $grid->addColumn($col);

        $col = new Column\Select('direccion_facturacion');
        $col->setLabel('Dirección');
        $col->setWidth(15);
        $grid->addColumn($col);

        $col = new Column\Select('descripcion');
        $col->setLabel('Descripción');
        $col->setWidth(35);
        $grid->addColumn($col);

        $editBtn = new Column\Action\Button();
        $editBtn->setLabel(' ');
        $editBtn->setAttribute('class', 'btn btn-success glyphicon glyphicon-edit');
        $editBtn->setAttribute('href', '/dashboard/empresa/edit/id/' . $editBtn->getRowIdPlaceholder());
        $editBtn->setAttribute('data-toggle', 'tooltip');
        $editBtn->setAttribute('data-placement', 'left');
        $editBtn->setAttribute('title', 'Modificar Empresa');
        
        $conBtn = new Column\Action\Button();
        $conBtn->setLabel(' ');
        $conBtn->setAttribute('class', 'btn btn-info glyphicon glyphicon-list-alt');
        $conBtn->setAttribute('href', 'javascript:registrarcontrato('.$conBtn->getRowIdPlaceholder().');');
        $conBtn->setAttribute('data-toggle', 'tooltip');
        $conBtn->setAttribute('data-placement', 'left');
        $conBtn->setAttribute('title', 'Contrato Empresa');

        $col = new Column\Action();
        $col->addAction($editBtn);
        $col->addAction($conBtn);
        $grid->addColumn($col);
        
        return $grid->getResponse();
        
    }

    public function editAction() {
        $serviceLocator = $this->getServiceLocator();

        $config = $serviceLocator->get('Config');
        $dir_image = $config['constantes']['dir_image'];



        $empresaId = $this->params('id');

        $edit_campana = new Container('edit_empresa');
        $edit_campana->id = $empresaId;

        $request = $this->getRequest();
        $viewmodel = new ViewModel(array('dir_image' => $dir_image));
        $sl = $this->getServiceLocator();
        $tipoDocumentoTable = $sl->get('Dashboard\Model\GentipodocumentoTable');
        $empresaTable = $sl->get('Dashboard\Model\GenempresaTable');
        
        $form = new EmpresaForm($tipoDocumentoTable);

        if ($request->isPost()) {
            // @TODO addfilters
            //$form->setInputFilter($filters);
            $dataPost = $request->getPost();
            $form->setData($dataPost);
            if ($form->isValid()) {
                $data = $form->getData();
                unset($data['submit']);
                unset($data['btn-regresar']);
                $dataId = array('id_empresa' => $empresaId);
                $empresaTable->editEmpresa($data, $dataId);

                /*if (trim($dataPost["id_categoria"]) != '') {
                    $empresaCategoriaTable->savecategorias($dataPost["id_categoria"], $empresaId);
                }*/
            }
        } else {
            $empresaData = $empresaTable->getEmpresa($empresaId);
            $empresa = $empresaData[0];
            //foreach ($empresaData as $empresa) {
                $form->get('id_empresa')->setValue($empresa['id_empresa']);
                $form->get('razon_social')->setValue($empresa['razon_social']);
                $form->get('registro_contribuyente')->setValue($empresa['registro_contribuyente']);
                $form->get('direccion_facturacion')->setValue($empresa['direccion_facturacion']);
                $form->get('direccion_comercial')->setValue($empresa['direccion_comercial']);
                $form->get('telefono')->setValue($empresa['telefono']);
                $form->get('horario')->setValue($empresa['horario']);
                $form->get('web_site')->setValue($empresa['web_site']);
                $form->get('ubicacion_gps')->setValue($empresa['ubicacion_gps']);
                $form->get('descripcion')->setValue($empresa['descripcion']);
                $form->get('tipo_documento_representante')->setValue($empresa['tipo_documento_representante']);
                $form->get('documento_representante')->setValue($empresa['documento_representante']);
                $form->get('nombre_representante')->setValue($empresa['nombre_representante']);
                $form->get('rubro')->setValue($empresa['rubro']);
                $form->get('id_operador')->setValue($empresa['id_operador']);
                
                $form->get('nombre_comercial')->setValue($empresa['nombre_comercial']);
                $form->get('persona_contacto')->setValue($empresa['persona_contacto']);
                $form->get('email_contacto')->setValue($empresa['email_contacto']);
                $form->get('titular_cuenta')->setValue($empresa['titular_cuenta']);
                $form->get('ruc_titular')->setValue($empresa['ruc_titular']);
                $form->get('numero_cuenta')->setValue($empresa['numero_cuenta']);
                $form->get('tipo_cuenta')->setValue($empresa['tipo_cuenta']);
                $form->get('email_facturacion')->setValue($empresa['email_facturacion']);
                $form->get('banco_cuenta')->setValue($empresa['banco_cuenta']);
                
                $form->get('tipo_empresa')->setValue($empresa['tipo_empresa']);
                
            //}
        }

//        $opciones = $empresaOpcionTable->getOpcionxCampanaAll($empresaId);
//        $opcionCampana = array();
//        foreach ($opciones as $opcion) {
//            $opcionCampana[] = $opcion;
//        }


        $viewmodel->form = $form;
        //$viewmodel->setVariable('opciones', $opcionCampana);

        return $viewmodel;
    }
    
        /* public function deleteAction()
      {
      $sl = $this->getServiceLocator();
      $userId = $this->params('id');
      $userTable = $sl->get('Dashboard\Model\CampanaTable');
      $userTable->deleteCampana($userId);
      $this->redirect()->toRoute('dash_user_list');
      } */
    
    public function contratoAction() {
        
        $id = $this->params()->fromPost("id", null);
        
        $serviceLocator = $this->getServiceLocator();
        $empresaTable = $serviceLocator->get('Dashboard\Model\GenempresaTable');
        $contratos = $empresaTable->getContratoxEmpresa($id);
        
        if( count($contratos) > 0) {
            $id_contrato = $contratos[0]['id_contrato'];
        } else {
            $id_contrato = -1;
        }
        
        return $this->getResponse()->setContent(Json::encode(array('id_contrato' => $id_contrato)));
        
    }
    
    public function anexocontratoAction() {
        
        $id = $this->params()->fromPost("id", null);
        
        $serviceLocator = $this->getServiceLocator();
        $empresaTable = $serviceLocator->get('Dashboard\Model\CupcampanaTable');
        $contratos = $empresaTable->getContratoxCampana($id);
        
        if( count($contratos) > 0) {
            $id_contrato = $contratos[0]['id_contrato'];
            
            if( !empty($contratos[0]['nombre_documento_contrato']) ) {
                $id_contrato = $contratos[0]['id_contrato'];
                $email_contacto = $contratos[0]['email_contacto'];
                $nombre_contacto = $contratos[0]['nombre_contacto'];
                $nombre_contrato = $contratos[0]['nombre_documento_contrato'];
                if( !empty($contratos[0]['nombre_documento_anexo']) ) {
                    $id_anexocontrato = 0;
                } else {
                    $id_anexocontrato = -1;
                }
            } else {
                $id_contrato = -1;
                $id_anexocontrato = -1;
            }
        } 
        
        return $this->getResponse()->setContent(Json::encode(array('id_contrato' => $id_contrato,
                                                                   'id_anexocontrato' => $id_anexocontrato,
                                                                   'email_contacto' => $email_contacto,
                                                                   'nombre_contacto' => $nombre_contacto,
                                                                   'nombre_contrato' => $nombre_contrato)));
        
    }
    
    public function registrarcontratoAction() {
        $id_empresa = $this->params()->fromPost("id_empresa", null);
        $nombre     = $this->params()->fromPost("nombre", null);
        $email      = $this->params()->fromPost("email", null);
        
        $serviceLocator = $this->getServiceLocator();
        $contratoTable = $serviceLocator->get('Dashboard\Model\ConcontratoTable');
        
        $contrato = array('id_empresa'      => $id_empresa,
                          'nombre_contacto' => $nombre,
                          'email_contacto'  => $email,
                          'id_estado'       => '1'
                          );
        
        $id_contrato = $contratoTable->addContrato($contrato);
        
        return $this->getResponse()->setContent(Json::encode(array('id_contrato' => $id_contrato)));
    }
    
    public function registraranexocontratoAction() {
        $id_contrato     = $this->params()->fromPost("id_contrato", null);
        $id_campana      = $this->params()->fromPost("id_campana", null);
        $nombre_contrato = $this->params()->fromPost("nombre_contrato", null);
        $nombre_contacto = $this->params()->fromPost("nombre_contacto", null);
        $email_contacto  = $this->params()->fromPost("email_contacto", null);
        
        $serviceLocator = $this->getServiceLocator();
        $contratoTable = $serviceLocator->get('Dashboard\Model\ConcontratoanexoTable');
        
        $nombre_anexo = $nombre_contrato.'_ANEXO_'.$id_campana.'_'.date('Ymd');
        
        $anexocontrato = array('id_contrato'      => $id_contrato,
                               'id_campana'       => $id_campana,
                               'nombre_documento' => $nombre_anexo,
                               'nombre_contacto'  => $nombre_contacto,
                               'email_contacto'   => $email_contacto,
                               'id_estado'        => '1'
                          );
        
        $contratoTable->addAnexoContrato($anexocontrato);
        
        return $this->getResponse()->setContent(Json::encode(array('id_anexocontrato' => 0,
                                                                   'id_contrato' => $id_contrato)));
    }
    
    public function editarcontratoAction() {
        
        set_time_limit(0);
        
        $id_contrato = $this->params()->fromPost("id_contrato", null);
        
        $serviceLocator = $this->getServiceLocator();
        $contratoTable = $serviceLocator->get('Dashboard\Model\ConcontratoTable');
        $contrato = $contratoTable->getContratoId($id_contrato);
        
        $config = $serviceLocator->get('Config');
        $dir_image = $config['constantes']['dir_image'];
        $sep_path = $config['constantes']['sep_path'];
        
        $directorio = $dir_image.$sep_path."..".$sep_path."..".$sep_path."data".$sep_path."contratos".$sep_path;
        
        foreach( $contrato as $cont ) {
            
            $empresaTable = $serviceLocator->get('Dashboard\Model\GenempresaTable');
            $datosEmpresa = $empresaTable->getEmpresa($cont['id_empresa']);
        
            if(!is_file($directorio.$cont["nombre_documento"].'.pdf')) {
                $documentoPdf = new PdfModel();
                $documentoPdf->setOption('filename', $cont["nombre_documento"].'.pdf');
                $documentoPdf->setOption('paperOrientation', 'portrait');
                $documentoPdf->setVariables(array(
                    'ruc' => $datosEmpresa[0]['registro_contribuyente'],
                    'razon' => $datosEmpresa[0]['razon_social'],
                    'direccion' => $datosEmpresa[0]['direccion_facturacion'],
                    'tipdoc_representante' => $datosEmpresa[0]['tipo_documento'],
                    'numero_representante' => $datosEmpresa[0]['documento_representante'],
                    'nombre_representante' => $datosEmpresa[0]['nombre_representante'],
                    'rubro' => $datosEmpresa[0]['rubro'],
                    'nombre_mes' => $this->_obtenerNombreMes(date('m'))
                ));

                $documentoPdf->setTerminal(true);
                $documentoPdf->setTemplate('dashboard/empresa/contrato-pdf.phtml');
                $htmlPdf = $serviceLocator->get('viewPdfrenderer')->getHtmlRenderer()->render($documentoPdf);
                $engine = $serviceLocator->get('viewPdfrenderer')->getEngine();
                // Cargamos el HTML en DOMPDF
                $engine->load_html($htmlPdf);
                $engine->render();
                // Obtenemos el PDF en memoria
                $pdfCode = $engine->output();

                file_put_contents($directorio.$cont["nombre_documento"].'.pdf', $pdfCode);
            }
        }
        
        return new ViewModel(array('contrato' => $contrato ));
        
    }
    
    public function editaranexocontratoAction() {
        
        set_time_limit(0);
        
        $id_contrato = $this->params()->fromPost("id_contrato", null);
        $id_campana = $this->params()->fromPost("id_campana", null);
        
        $serviceLocator = $this->getServiceLocator();
        $contratoTable = $serviceLocator->get('Dashboard\Model\ConcontratoanexoTable');
        $contrato = $contratoTable->getContratoAnexoId($id_contrato, $id_campana);
        
        $config = $serviceLocator->get('Config');
        $dir_image = $config['constantes']['dir_image'];
        $sep_path = $config['constantes']['sep_path'];
        
        $directorio = $dir_image.$sep_path."..".$sep_path."..".$sep_path."data".$sep_path."contratos".$sep_path;
        
        foreach( $contrato as $cont ) {
            
            $empresaTable = $serviceLocator->get('Dashboard\Model\GenempresaTable');
            $campanaTable = $serviceLocator->get('Dashboard\Model\CupcampanaTable');
            
            $datosEmpresa = $empresaTable->getEmpresa($cont['id_empresa']);
            $datosCampana   = $campanaTable->getCampanaId($id_campana);
            $opcionesCampana = $campanaTable->getCampanaOpciones($id_campana);
        
            if(!is_file($directorio.$cont["nombre_documento"].'.pdf')) {
                $documentoPdf = new PdfModel();
                $documentoPdf->setOption('filename', $cont["nombre_documento"].'.pdf');
                $documentoPdf->setOption('paperOrientation', 'portrait');
                $documentoPdf->setVariables(array(
                    'nombre_mes' => $this->_obtenerNombreMes(date('m')),
                    'datos_campana' => $datosCampana,
                    'opciones_campana' => $opcionesCampana,
                    'datos_empresa' => $datosEmpresa
                ));

                $documentoPdf->setTerminal(true);
                $documentoPdf->setTemplate('dashboard/empresa/anexo-contrato-pdf.phtml');
                $htmlPdf = $serviceLocator->get('viewPdfrenderer')->getHtmlRenderer()->render($documentoPdf);
                $engine = $serviceLocator->get('viewPdfrenderer')->getEngine();
                // Cargamos el HTML en DOMPDF
                $engine->load_html($htmlPdf);
                $engine->render();
                // Obtenemos el PDF en memoria
                $pdfCode = $engine->output();

                file_put_contents($directorio.$cont["nombre_documento"].'.pdf', $pdfCode);
            }
        }
        
        return new ViewModel(array('contrato' => $contrato ));
        
    }
    
    public function actualizacontratoAction() {
        
        set_time_limit(0);
        
        $id_contrato = $this->params()->fromQuery("id_contrato", null);
        
        
        
        $serviceLocator = $this->getServiceLocator();
        $response = $this->getResponse();
        $contratoTable = $serviceLocator->get('Dashboard\Model\ConcontratoTable');
        $contrato = $contratoTable->getContratoId($id_contrato);
        
        $config = $serviceLocator->get('Config');
        $dir_image = $config['constantes']['dir_image'];
        $sep_path = $config['constantes']['sep_path'];
        
        $directorio = $dir_image.$sep_path."..".$sep_path."..".$sep_path."data".$sep_path."contratos".$sep_path;
        $rutaDocumento = '';
        $nombreDocumento = '';
        foreach( $contrato as $cont ) {
            
            $empresaTable = $serviceLocator->get('Dashboard\Model\GenempresaTable');
            $datosEmpresa = $empresaTable->getEmpresa($cont['id_empresa']);
        
            //if(!is_file($directorio.$cont["nombre_documento"].'.pdf')) {
                $documentoPdf = new PdfModel();
                $documentoPdf->setOption('filename', $cont["nombre_documento"].'.pdf');
                $documentoPdf->setOption('paperOrientation', 'portrait');
                $documentoPdf->setVariables(array(
                    'ruc' => $datosEmpresa[0]['registro_contribuyente'],
                    'razon' => $datosEmpresa[0]['razon_social'],
                    'direccion' => $datosEmpresa[0]['direccion_facturacion'],
                    'tipdoc_representante' => $datosEmpresa[0]['tipo_documento'],
                    'numero_representante' => $datosEmpresa[0]['documento_representante'],
                    'nombre_representante' => $datosEmpresa[0]['nombre_representante'],
                    'rubro' => $datosEmpresa[0]['rubro'],
                    'nombre_mes' => $this->_obtenerNombreMes(date('m'))
                ));

                $documentoPdf->setTerminal(true);
                $documentoPdf->setTemplate('dashboard/empresa/contrato-pdf.phtml');
                $htmlPdf = $serviceLocator->get('viewPdfrenderer')->getHtmlRenderer()->render($documentoPdf);
                $engine = $serviceLocator->get('viewPdfrenderer')->getEngine();
                // Cargamos el HTML en DOMPDF
                $engine->load_html($htmlPdf);
                $engine->render();
                // Obtenemos el PDF en memoria
                $pdfCode = $engine->output();
                
                $nombreDocumento = $cont["nombre_documento"];
                $rutaDocumento = $directorio.$nombreDocumento.'.pdf';
                file_put_contents($rutaDocumento, $pdfCode);
            //}
        }
        
        $contenidoDocumento = file_get_contents($rutaDocumento);
        $response->setContent($contenidoDocumento);

        $headers = $response->getHeaders();
        $headers->clearHeaders()
                ->addHeaderLine('Content-Type', 'application/pdf')
                ->addHeaderLine('Content-Disposition', 'attachment; filename="'.$nombreDocumento.'.pdf"')
                ->addHeaderLine('Content-Length', strlen($contenidoDocumento));


        return $this->response;
        
    }
    
    public function actualizaanexocontratoAction() {
        
        set_time_limit(0);
        
        $id_contrato = $this->params()->fromQuery("id_contrato", null);
        $id_campana = $this->params()->fromQuery("id_campana", null);
        
        $serviceLocator = $this->getServiceLocator();
        $response = $this->getResponse();
        $contratoTable = $serviceLocator->get('Dashboard\Model\ConcontratoanexoTable');
        $contrato = $contratoTable->getContratoAnexoId($id_contrato, $id_campana);
        
        $config = $serviceLocator->get('Config');
        $dir_image = $config['constantes']['dir_image'];
        $sep_path = $config['constantes']['sep_path'];
        
        $directorio = $dir_image.$sep_path."..".$sep_path."..".$sep_path."data".$sep_path."contratos".$sep_path;
        $rutaDocumento = '';
        $nombreDocumento = '';
        foreach( $contrato as $cont ) {
            
            $empresaTable = $serviceLocator->get('Dashboard\Model\GenempresaTable');
            $campanaTable = $serviceLocator->get('Dashboard\Model\CupcampanaTable');
            
            $datosEmpresa = $empresaTable->getEmpresa($cont['id_empresa']);
            $datosCampana   = $campanaTable->getCampanaId($id_campana);
            $opcionesCampana = $campanaTable->getCampanaOpciones($id_campana);
        
            //if(!is_file($directorio.$cont["nombre_documento"].'.pdf')) {
                $documentoPdf = new PdfModel();
                $documentoPdf->setOption('filename', $cont["nombre_documento"].'.pdf');
                $documentoPdf->setOption('paperOrientation', 'portrait');
                $documentoPdf->setVariables(array(
                    'nombre_mes' => $this->_obtenerNombreMes(date('m')),
                    'datos_campana' => $datosCampana,
                    'opciones_campana' => $opcionesCampana,
                    'datos_empresa' => $datosEmpresa
                ));

                $documentoPdf->setTerminal(true);
                $documentoPdf->setTemplate('dashboard/empresa/anexo-contrato-pdf.phtml');
                $htmlPdf = $serviceLocator->get('viewPdfrenderer')->getHtmlRenderer()->render($documentoPdf);
                $engine = $serviceLocator->get('viewPdfrenderer')->getEngine();
                // Cargamos el HTML en DOMPDF
                $engine->load_html($htmlPdf);
                $engine->render();
                // Obtenemos el PDF en memoria
                $pdfCode = $engine->output();
                
                $nombreDocumento = $cont["nombre_documento"];
                $rutaDocumento = $directorio.$nombreDocumento.'.pdf';
                file_put_contents($rutaDocumento, $pdfCode);
            //}
        }
        
        $contenidoDocumento = file_get_contents($rutaDocumento);
        $response->setContent($contenidoDocumento);

        $headers = $response->getHeaders();
        $headers->clearHeaders()
                ->addHeaderLine('Content-Type', 'application/pdf')
                ->addHeaderLine('Content-Disposition', 'attachment; filename="'.$nombreDocumento.'.pdf"')
                ->addHeaderLine('Content-Length', strlen($contenidoDocumento));


        return $this->response;
        
    }
    
    public function obtenerPdfContratoAction() 
    {
        $serviceLocator = $this->getServiceLocator();
        $response = $this->getResponse();
        $config = $serviceLocator->get('Config');
        $dir_image = $config['constantes']['dir_image'];
        $sep_path = $config['constantes']['sep_path'];
        
        $directorio = $dir_image.$sep_path."..".$sep_path."..".$sep_path."data".$sep_path."contratos".$sep_path;
        
        $params = $this->params()->fromQuery();
        
        $nombreDocumento = !empty($params['nombre_documento']) ? $params['nombre_documento'] : '';
        
        $rutaDocumento = $directorio. 
                         $nombreDocumento.'.pdf';
        
        //if(!is_file($rutaDocumento)) {
        //    $this->redirect()->toRoute('documento-electronico');
        //}

        $contenidoDocumento = file_get_contents($rutaDocumento);
        $response->setContent($contenidoDocumento);

        $headers = $response->getHeaders();
        $headers->clearHeaders()
                ->addHeaderLine('Content-Type', 'application/pdf')
                ->addHeaderLine('Content-Disposition', 'attachment; filename="'.$nombreDocumento.'.pdf"')
                ->addHeaderLine('Content-Length', strlen($contenidoDocumento));


        return $this->response;
    }
    
    private function _obtenerNombreMes($mes) {
        switch($mes) {
            case '01' : $nombre = 'Enero';
                break;
            case '02' : $nombre = 'Febrero';
                break;
            case '03' : $nombre = 'Marzo';
                break;
            case '04' : $nombre = 'Abril';
                break;
            case '05' : $nombre = 'Mayo';
                break;
            case '06' : $nombre = 'Junio';
                break;
            case '07' : $nombre = 'Julio';
                break;
            case '08' : $nombre = 'Agosto';
                break;
            case '09' : $nombre = 'Setiembre';
                break;
            case '10' : $nombre = 'Octubre';
                break;
            case '11' : $nombre = 'Noviembre';
                break;
            case '12' : $nombre = 'Diciembre';
                break;
        }
        
        return $nombre;
    }
    
    public function enviarContratoAction() {

        $email_contacto = $this->params()->fromPost("email_contacto", null);
        $nombre_contacto = $this->params()->fromPost("nombre_contacto", null);
        $id_contrato = $this->params()->fromPost("id_contrato", null);

        $serviceLocator = $this->getServiceLocator();
        $config = $serviceLocator->get('Config');
        
        $set = array('nombre_contacto' => $nombre_contacto,
                     'email_contacto' => $email_contacto);
        
        $where = array('id_contrato' => $id_contrato);
        
        $campanaTable = $serviceLocator->get('Dashboard\Model\ConcontratoTable');
        $campanaTable->editContrato($set,$where);
        
        $activo   = $config['correo']['activo'];
        $name     = $config['correo']['name'];
        $host     = $config['correo']['host'];
        $port     = $config['correo']['port'];
        $tls      = $config['correo']['tls'];
        $username = $config['correo']['username'];
        $password = $config['correo']['password'];
        $cuenta   = $config['correo']['cuenta-mensajes-empresas'];
        $localhost = $config['constantes']['localhost'];
        $telefono = $config['empresa']['telefono'];

        $data = array();
        $data[0]['validar'] = '2';
        
        $nombre = $nombre_contacto;
        $token = base64_encode($id_contrato);

        if( $activo == '1' ) {

            $message = new Message();
            $message->addTo($email_contacto)
                    ->addBcc("german@rebueno.ec")
                    ->addFrom($cuenta)
                    ->setSubject('Firma de Contrato Rebueno!‏');

            if( $tls ) {
                $connection_config = array(
                    'ssl' => 'tls',
                    'username' => $username,
                    'password' => $password
                );
            } else {
                $connection_config = array(
                    'username' => $username,
                    'password' => $password
                );
            }

            $transport = new SmtpTransport();
            $options = new SmtpOptions(array(
                'name' => $name,
                'host' => $host,
                'port' => $port,
                'connection_class' => 'login',
                'connection_config' => $connection_config
            ));

            $resolver = new TemplateMapResolver();
            $resolver->setMap(array(
                'mailLayout' => __DIR__ . '/../../../../Dashboard/view/dashboard/empresa/emailcontrato.phtml'
            ));

            $rendered = new PhpRenderer();
            $rendered->setResolver($resolver);

            $viewModel = new ViewModel();
            $viewModel->setTemplate('mailLayout')->setVariables(array(
                'nombre' => $nombre,
                'token' => $token,
                'localhost' => $localhost,
                'telefono' => $telefono
            ));

            $content = $rendered->render($viewModel);

            $html = new MimePart($content);
            $html->type = "text/html";

            $body = new MimeMessage();
            $body->addPart($html);

            $message->setBody($body);

            $transport->setOptions($options);
            $transport->send($message);
            
            $data[0]['validar'] = '1';
            
        }

        return $this->getResponse()->setContent(Json::encode($data));
    }
    
    public function enviarAnexoContratoAction() {

        $email_contacto = $this->params()->fromPost("email_contacto", null);
        $nombre_contacto = $this->params()->fromPost("nombre_contacto", null);
        $id_contrato = $this->params()->fromPost("id_contrato", null);
        $id_campana = $this->params()->fromPost("id_campana", null);

        $serviceLocator = $this->getServiceLocator();
        $config = $serviceLocator->get('Config');
        
        $set = array('nombre_contacto' => $nombre_contacto,
                     'email_contacto' => $email_contacto);
        
        $where = array('id_contrato' => $id_contrato,
                       'id_campana' => $id_campana);
        
        $campanaTable = $serviceLocator->get('Dashboard\Model\ConcontratoanexoTable');
        $campanaTable->editAnexoContrato($set,$where);
        
        $activo   = $config['correo']['activo'];
        $name     = $config['correo']['name'];
        $host     = $config['correo']['host'];
        $port     = $config['correo']['port'];
        $tls      = $config['correo']['tls'];
        $username = $config['correo']['username'];
        $password = $config['correo']['password'];
        $cuenta   = $config['correo']['cuenta-mensajes-empresas'];
        $localhost = $config['constantes']['localhost'];
        $telefono = $config['empresa']['telefono'];

        $data = array();
        $data[0]['validar'] = '2';
        
        $nombre = $nombre_contacto;
        $token = base64_encode($id_contrato);
        $token_campana = base64_encode($id_campana);

        if( $activo == '1' ) {

            $message = new Message();
            $message->addTo($email_contacto)
                    ->addBcc("german@rebueno.ec")
                    ->addFrom($cuenta)
                    ->setSubject('Firma de Anexo Contrato Rebueno!‏');

            if( $tls ) {
                $connection_config = array(
                    'ssl' => 'tls',
                    'username' => $username,
                    'password' => $password
                );
            } else {
                $connection_config = array(
                    'username' => $username,
                    'password' => $password
                );
            }

            $transport = new SmtpTransport();
            $options = new SmtpOptions(array(
                'name' => $name,
                'host' => $host,
                'port' => $port,
                'connection_class' => 'login',
                'connection_config' => $connection_config
            ));

            $resolver = new TemplateMapResolver();
            $resolver->setMap(array(
                'mailLayout' => __DIR__ . '/../../../../Dashboard/view/dashboard/empresa/emailanexocontrato.phtml'
            ));

            $rendered = new PhpRenderer();
            $rendered->setResolver($resolver);

            $viewModel = new ViewModel();
            $viewModel->setTemplate('mailLayout')->setVariables(array(
                'nombre' => $nombre,
                'token' => $token,
                'token_campana' => $token_campana,
                'localhost' => $localhost,
                'telefono' => $telefono
            ));

            $content = $rendered->render($viewModel);

            $html = new MimePart($content);
            $html->type = "text/html";

            $body = new MimeMessage();
            $body->addPart($html);

            $message->setBody($body);

            $transport->setOptions($options);
            $transport->send($message);
            
            $data[0]['validar'] = '1';
            
        }

        return $this->getResponse()->setContent(Json::encode($data));
    }
    
    public function enviarArteAction() {

        $email_contacto = $this->params()->fromPost("email_contacto", null);
        $nombre_contacto = $this->params()->fromPost("nombre_contacto", null);
        $id_contrato = $this->params()->fromPost("id_contrato", null);
        $id_campana = $this->params()->fromPost("id_campana", null);

        $serviceLocator = $this->getServiceLocator();
        $config = $serviceLocator->get('Config');
        $passwordReset = 'RebuenoEcuador';
        
        $campanaTable = $serviceLocator->get('Dashboard\Model\CupcampanaTable');
        $empresaTable = $serviceLocator->get('Dashboard\Model\GenempresaTable');
        $usuarioTable = $serviceLocator->get('Dashboard\Model\UserTable');
        $campana = $campanaTable->getCampanaId($id_campana);
        $subtitulo = $campana[0]['subtitulo'];
        $id_empresa = $campana[0]['id_empresa'];
        $empresa = $empresaTable->getEmpresa($id_empresa);
        $id_usuario = $empresa[0]['registro_contribuyente'];
        
        
        
        $existe = $usuarioTable->verificarUsuario($id_usuario);
        if( $existe[0]['existe'] > 0 ) {
            
            $set = array('password' => $passwordReset);
            
            $where = array('username' => $id_usuario);
            
            $usuarioTable->editUser($set, $where);
            
        } else {
        
            $nuevo_usuario = array('username' => $id_usuario,
                  'password' => $passwordReset,
                  'full_name' => $nombre_contacto,
                  'email' => $email_contacto,
                  'role_id' => 3,
                  'id_empresa' => $id_empresa);
            
            $usuarioTable->addUser($nuevo_usuario);
            
        }
        
        
        
        $set = array('nombre_contacto_arte' => $nombre_contacto,
                     'email_contacto_arte' => $email_contacto,
                     'fecha_envio_arte' => date('Y-m-d H:i:s'),
                     'id_estado_arte' => '2');
        
        $where = array('id_contrato' => $id_contrato,
                       'id_campana' => $id_campana);
        
        $contratoanexoTable = $serviceLocator->get('Dashboard\Model\ConcontratoanexoTable');
        $contratoanexoTable->editAnexoContrato($set,$where);
        
        $activo   = $config['correo']['activo'];
        $name     = $config['correo']['name'];
        $host     = $config['correo']['host'];
        $port     = $config['correo']['port'];
        $tls      = $config['correo']['tls'];
        $username = $config['correo']['username'];
        $password = $config['correo']['password'];
        $cuenta   = $config['correo']['cuenta-mensajes-empresas'];
        $localhost = $config['constantes']['localhost'];
        $telefono = $config['empresa']['telefono'];

        $data = array();
        $data[0]['validar'] = '2';
        
        $nombre = $nombre_contacto;
        $token_campana = base64_encode($id_campana);

        if( $activo == '1' ) {

            $message = new Message();
            $message->addTo($email_contacto)
                    ->addBcc("german@rebueno.ec")
                    ->addFrom($cuenta)
                    ->setSubject('Aprobación del Arte Rebueno!‏');

            if( $tls ) {
                $connection_config = array(
                    'ssl' => 'tls',
                    'username' => $username,
                    'password' => $password
                );
            } else {
                $connection_config = array(
                    'username' => $username,
                    'password' => $password
                );
            }

            $transport = new SmtpTransport();
            $options = new SmtpOptions(array(
                'name' => $name,
                'host' => $host,
                'port' => $port,
                'connection_class' => 'login',
                'connection_config' => $connection_config
            ));

            $resolver = new TemplateMapResolver();
            $resolver->setMap(array(
                'mailLayout' => __DIR__ . '/../../../../Dashboard/view/dashboard/empresa/emailarteanexo.phtml'
            ));

            $rendered = new PhpRenderer();
            $rendered->setResolver($resolver);

            $viewModel = new ViewModel();
            $viewModel->setTemplate('mailLayout')->setVariables(array(
                'nombre' => $nombre,
                'token_campana' => $token_campana,
                'subtitulo' => $subtitulo,
                'localhost' => $localhost,
                'telefono' => $telefono,
                'usuario' => $id_usuario,
                'password' => $passwordReset
            ));

            $content = $rendered->render($viewModel);

            $html = new MimePart($content);
            $html->type = "text/html";

            $body = new MimeMessage();
            $body->addPart($html);

            $message->setBody($body);

            $transport->setOptions($options);
            $transport->send($message);
            
            $data[0]['validar'] = '1';
            
        }

        return $this->getResponse()->setContent(Json::encode($data));
    }
    
    public function aceptarArteAction() {
        $id_contrato     = base64_decode($this->params()->fromPost("contrato", null));
        $id_campana      = base64_decode($this->params()->fromPost("campana", null));
        
        $serviceLocator = $this->getServiceLocator();
        $contratoanexoTable = $serviceLocator->get('Dashboard\Model\ConcontratoanexoTable');
        
        $set = array('fecha_aceptacion_arte' => date('Y-m-d H:i:s'),
                     'id_estado_arte'        => '3');
        
        $where = array('id_contrato'      => $id_contrato,
                       'id_campana'       => $id_campana);
        
        $contratoanexoTable->editAnexoContrato($set,$where);
        
        return $this->getResponse()->setContent(Json::encode(array('respuesta' => 1)));
    }
    
}
