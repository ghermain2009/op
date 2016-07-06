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
/**
 * Description of ReporteController
 *
 * @author gtapia
 */
class ReporteController extends AbstractActionController {
    //put your code here
    public function controlDocumentosCampanaAction() {

        $serviceLocator = $this->getServiceLocator();
        $campanaTable = $serviceLocator->get('Dashboard\Model\CupcampanaTable');
        $datosReporte = $campanaTable->getCampanaEstadoDocumentos();
        
        return new ViewModel(array('datos' => $datosReporte));
    }
    
    public function controlDatosEmpresaAction() {

        $serviceLocator = $this->getServiceLocator();
        $campanaTable = $serviceLocator->get('Dashboard\Model\GenempresaTable');
        $datosReporte = $campanaTable->getEmpresaList();
        
        return new ViewModel(array('datos' => $datosReporte));
    }
    
    public function controlDatosPagoAction() {

        $serviceLocator = $this->getServiceLocator();
        $campanaTable = $serviceLocator->get('Dashboard\Model\GenempresaTable');
        $datosReporte = $campanaTable->getEmpresaList();
        
        return new ViewModel(array('datos' => $datosReporte));
    }
   
}
