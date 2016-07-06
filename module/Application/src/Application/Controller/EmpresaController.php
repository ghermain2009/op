<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Controller;

/**
 * Description of InteresController
 *
 * @author gtapia
 */
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Services\Variados;
use DOMPDFModule\View\Model\PdfModel;

class EmpresaController extends AbstractActionController {

    public function firmaContratoAction() {

        $token = $this->params()->fromQuery("token", null);

        $id_contrato = base64_decode($token);
        
        $serviceLocator = $this->getServiceLocator();
        $config = $serviceLocator->get('config');
        
        $contratoTable = $serviceLocator->get('Dashboard\Model\ConcontratoTable');
        $contrato = $contratoTable->getContratoId($id_contrato);
        
        $nombre_documento = '';
        $id_estado = '';
        
        foreach( $contrato as $cont ) {
            $nombre_documento = $cont["nombre_documento"];
            $id_estado = $cont["id_estado"];
        }
                
        $pais = $config['id_pais'];
        $capital = $config['id_capital'];
        
        $departamentoTable = $serviceLocator->get('Dashboard\Model\UbidepartamentoTable');
        $departamentos = $departamentoTable->getDepartamentosxPaisFavoritos($pais);
        
        $provinciaTable = $serviceLocator->get('Dashboard\Model\UbiprovinciaTable');
        $provincias = $provinciaTable->getProvinciasxDepartamento($pais, $capital);
        
        $this->layout()->pais = $pais;
        $this->layout()->capital = $capital;
        $this->layout()->departamentos = $departamentos;
        $this->layout()->provincias = $provincias;
        
        $telefono_empresa = $config['empresa']['telefono'];
        $this->layout()->telefono_empresa = $telefono_empresa;
        
        return new ViewModel(array('nombre_documento' => $nombre_documento,
                                   'id_contrato' => $token,
                                   'id_estado' => $id_estado) );
    }
    
    public function firmaAnexoContratoAction() {

        $token = $this->params()->fromQuery("token", null);
        $token_campana = $this->params()->fromQuery("token_campana", null);

        $id_contrato = base64_decode($token);
        $id_campana = base64_decode($token_campana);
        
        $serviceLocator = $this->getServiceLocator();
        $config = $serviceLocator->get('config');
        
        $contratoTable = $serviceLocator->get('Dashboard\Model\ConcontratoanexoTable');
        $contrato = $contratoTable->getContratoAnexoId($id_contrato,$id_campana);
        
        $nombre_documento = '';
        $id_estado = '';
        
        foreach( $contrato as $cont ) {
            $nombre_documento = $cont["nombre_documento"];
            $id_estado = $cont["id_estado"];
        }
                
        $pais = $config['id_pais'];
        $capital = $config['id_capital'];
        
        $departamentoTable = $serviceLocator->get('Dashboard\Model\UbidepartamentoTable');
        $departamentos = $departamentoTable->getDepartamentosxPaisFavoritos($pais);
        
        $provinciaTable = $serviceLocator->get('Dashboard\Model\UbiprovinciaTable');
        $provincias = $provinciaTable->getProvinciasxDepartamento($pais, $capital);
        
        $this->layout()->pais = $pais;
        $this->layout()->capital = $capital;
        $this->layout()->departamentos = $departamentos;
        $this->layout()->provincias = $provincias;
        
        $telefono_empresa = $config['empresa']['telefono'];
        $this->layout()->telefono_empresa = $telefono_empresa;
        
        return new ViewModel(array('nombre_documento' => $nombre_documento,
                                   'id_contrato' => $token,
                                   'id_campana' => $token_campana,
                                   'id_estado' => $id_estado) );
    }
    
    public function verContratoPdfAction() 
    {
        $serviceLocator = $this->getServiceLocator();
        $response = $this->getResponse();
        $config = $serviceLocator->get('Config');
        $dir_image = $config['constantes']['dir_image'];
        $sep_path  = $config['constantes']['sep_path'];
        
        $directorio = $dir_image.$sep_path."..".$sep_path."..".$sep_path."data".$sep_path."contratos".$sep_path;
        
        $params = $this->params()->fromQuery();
        
        $nombreDocumento = !empty($params['nombre_documento']) ? $params['nombre_documento'] : '';
        
        $rutaDocumento = $directorio. 
                         $nombreDocumento.'.pdf';
        
        $contenidoDocumento = file_get_contents($rutaDocumento);
        $response->setContent($contenidoDocumento);

        $headers = $response->getHeaders();
        $headers->clearHeaders()
                ->addHeaderLine('Content-Type', 'application/pdf')
                ->addHeaderLine('Content-Disposition', 'inline; filename="'.$nombreDocumento.'.pdf"')
                ->addHeaderLine('Content-Length', strlen($contenidoDocumento));


        return $this->response;
    }
    
    public function registrarFirmaAction() {
        
        set_time_limit(0);
        
        $json = $this->params()->fromPost("output",null);
        $id_contrato = base64_decode($this->params()->fromPost("id_contrato", null));
        $nombre_firmante = $this->params()->fromPost("name",null);
        
        $serviceLocator = $this->getServiceLocator();
        $contratoTable = $serviceLocator->get('Dashboard\Model\ConcontratoTable');
        $contrato = $contratoTable->getContratoId($id_contrato);
        //$response = $this->getResponse();
        $config = $serviceLocator->get('Config');
        $dir_image = $config['constantes']['dir_image'];
        $sep_path  = $config['constantes']['sep_path'];
        
        $directorio = $dir_image.$sep_path."..".$sep_path."..".$sep_path."data".$sep_path."contratos".$sep_path;
        
        if( !empty($json)) {
        
            $auxiliar = new Variados($this->serviceLocator);

            $data = $auxiliar->_sigJsonToImage($json);
            
            ob_start();
            imagepng($data);
            $imagedata = ob_get_contents();
            ob_end_clean();
            $img_firma = 'data:image/png;base64,'.base64_encode($imagedata);
            
        } else {
            $img_firma = '';
        }
        
        foreach( $contrato as $cont ) {
            
            $empresaTable = $serviceLocator->get('Dashboard\Model\GenempresaTable');
            $datosEmpresa = $empresaTable->getEmpresa($cont['id_empresa']);
            
            $variables = array(
                'ruc' => $datosEmpresa[0]['registro_contribuyente'],
                'razon' => $datosEmpresa[0]['razon_social'],
                'direccion' => $datosEmpresa[0]['direccion_facturacion'],
                'tipdoc_representante' => $datosEmpresa[0]['tipo_documento'],
                'numero_representante' => $datosEmpresa[0]['documento_representante'],
                'nombre_representante' => $datosEmpresa[0]['nombre_representante'],
                'rubro' => $datosEmpresa[0]['rubro'],
                'nombre_mes' => $this->_obtenerNombreMes(date('m')),
                'nombre_firmante' => $nombre_firmante,
                'img_firma' => $img_firma 
            );
        
            $documentoPdf = new PdfModel();
            $documentoPdf->setOption('filename', $cont["nombre_documento"].'.pdf');
            $documentoPdf->setOption('paperOrientation', 'portrait');
            $documentoPdf->setVariables($variables);

            $documentoPdf->setTerminal(true);
            $documentoPdf->setTemplate('dashboard/empresa/contrato-pdf.phtml');
            $htmlPdf = $serviceLocator->get('viewPdfrenderer')->getHtmlRenderer()->render($documentoPdf);
            $engine = $serviceLocator->get('viewPdfrenderer')->getEngine();
            // Cargamos el HTML en DOMPDF
            $engine->load_html($htmlPdf);
            $engine->render();
            // Obtenemos el PDF en memoria
            $pdfCode = $engine->output();
            
            $nombre_documento = $cont["nombre_documento"];
            file_put_contents($directorio.$nombre_documento.'.pdf', $pdfCode);
            
        }
        
        $set = array('firma_documento' => $nombre_firmante,
                     'fecha_firma' => date('Y-m-d H:i:s'),
                     'id_estado' => '2');
        
        $where = array('id_contrato' => $id_contrato);
        
        $campanaTable = $serviceLocator->get('Dashboard\Model\ConcontratoTable');
        $campanaTable->editContrato($set,$where);
        
        $pais = $config['id_pais'];
        $capital = $config['id_capital'];
        
        $departamentoTable = $serviceLocator->get('Dashboard\Model\UbidepartamentoTable');
        $departamentos = $departamentoTable->getDepartamentosxPaisFavoritos($pais);
        
        $provinciaTable = $serviceLocator->get('Dashboard\Model\UbiprovinciaTable');
        $provincias = $provinciaTable->getProvinciasxDepartamento($pais, $capital);
        
        $this->layout()->pais = $pais;
        $this->layout()->capital = $capital;
        $this->layout()->departamentos = $departamentos;
        $this->layout()->provincias = $provincias;
        
        $telefono_empresa = $config['empresa']['telefono'];
        $this->layout()->telefono_empresa = $telefono_empresa;
        
        return new ViewModel(array('nombre_documento' => $nombre_documento));
        
    }
    
    public function registrarFirmaAnexoAction() {
        
        set_time_limit(0);
        
        $json = $this->params()->fromPost("output",null);
        $id_contrato = base64_decode($this->params()->fromPost("id_contrato", null));
        $id_campana = base64_decode($this->params()->fromPost("id_campana", null));
        $nombre_firmante = $this->params()->fromPost("name",null);
        
        $serviceLocator = $this->getServiceLocator();
        $contratoTable = $serviceLocator->get('Dashboard\Model\ConcontratoanexoTable');
        $contrato = $contratoTable->getContratoAnexoId($id_contrato,$id_campana);
        //$response = $this->getResponse();
        $config = $serviceLocator->get('Config');
        $dir_image = $config['constantes']['dir_image'];
        $sep_path  = $config['constantes']['sep_path'];
        
        $directorio = $dir_image.$sep_path."..".$sep_path."..".$sep_path."data".$sep_path."contratos".$sep_path;
        
        if( !empty($json)) {
        
            $auxiliar = new Variados($this->serviceLocator);

            $data = $auxiliar->_sigJsonToImage($json);
            
            ob_start();
            imagepng($data);
            $imagedata = ob_get_contents();
            ob_end_clean();
            $img_firma = 'data:image/png;base64,'.base64_encode($imagedata);
            
        } else {
            $img_firma = '';
        }
        
        foreach( $contrato as $cont ) {
            
            $empresaTable = $serviceLocator->get('Dashboard\Model\GenempresaTable');
            $campanaTable = $serviceLocator->get('Dashboard\Model\CupcampanaTable');
            
            $datosEmpresa = $empresaTable->getEmpresa($cont['id_empresa']);
            $datosCampana   = $campanaTable->getCampanaId($id_campana);
            $opcionesCampana = $campanaTable->getCampanaOpciones($id_campana);
            
            $variables = array(
                'nombre_mes' => $this->_obtenerNombreMes(date('m')),
                'datos_campana' => $datosCampana,
                'opciones_campana' => $opcionesCampana,
                'datos_empresa' => $datosEmpresa,
                'nombre_firmante' => $nombre_firmante,
                'img_firma' => $img_firma 
            );
        
            $documentoPdf = new PdfModel();
            $documentoPdf->setOption('filename', $cont["nombre_documento"].'.pdf');
            $documentoPdf->setOption('paperOrientation', 'portrait');
            $documentoPdf->setVariables($variables);

            $documentoPdf->setTerminal(true);
            $documentoPdf->setTemplate('dashboard/empresa/anexo-contrato-pdf.phtml');
            $htmlPdf = $serviceLocator->get('viewPdfrenderer')->getHtmlRenderer()->render($documentoPdf);
            $engine = $serviceLocator->get('viewPdfrenderer')->getEngine();
            // Cargamos el HTML en DOMPDF
            $engine->load_html($htmlPdf);
            $engine->render();
            // Obtenemos el PDF en memoria
            $pdfCode = $engine->output();
            
            $nombre_documento = $cont["nombre_documento"];
            file_put_contents($directorio.$nombre_documento.'.pdf', $pdfCode);
            
        }
        
        $set = array('firma' => $nombre_firmante,
                     'fecha_firma' => date('Y-m-d H:i:s'),
                     'id_estado' => '2');
        
        $where = array('id_contrato' => $id_contrato,
                       'id_campana' => $id_campana);
        
        $campanaTable = $serviceLocator->get('Dashboard\Model\ConcontratoanexoTable');
        $campanaTable->editAnexoContrato($set,$where);
        
        $pais = $config['id_pais'];
        $capital = $config['id_capital'];
        
        $departamentoTable = $serviceLocator->get('Dashboard\Model\UbidepartamentoTable');
        $departamentos = $departamentoTable->getDepartamentosxPaisFavoritos($pais);
        
        $provinciaTable = $serviceLocator->get('Dashboard\Model\UbiprovinciaTable');
        $provincias = $provinciaTable->getProvinciasxDepartamento($pais, $capital);
        
        $this->layout()->pais = $pais;
        $this->layout()->capital = $capital;
        $this->layout()->departamentos = $departamentos;
        $this->layout()->provincias = $provincias;
        
        $telefono_empresa = $config['empresa']['telefono'];
        $this->layout()->telefono_empresa = $telefono_empresa;
        
        return new ViewModel(array('nombre_documento' => $nombre_documento));
        
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
}
