<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;
use Zend\Stdlib\ArrayUtils;
use Zend\Json\Json;
use Application\Services\Variados;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        
        $serviceLocator = $this->getServiceLocator();
        $config = $serviceLocator->get('config');
        $en_produccion = $config['en_produccion'];
        $empresa_promocion = $config['empresa']['cod_empresa_promocion'];
        $portada = $config['portada'];
        
        $dir_image = $config['constantes']['dir_image'];
        $sep_path = $config['constantes']['sep_path'];
        $dir_imagenes = $config['rutas']['dir_principal'] .
                        $sep_path .
                        $config['rutas']['dir_imgcampanas'];
        
        $ruta_int = $dir_image . 
                    $sep_path . 
                    ".." .
                    $sep_path .
                    ".." .
                    $sep_path .
                    $dir_imagenes .
                    $sep_path;
        
        $constantes = $config['constantes'];
        $moneda = $config['moneda'];

        $user_session = new Container('user');
        
        if( !isset($user_session->facebook['id'])) {
            $user_session->facebook = array('id' => $constantes["id_facebook"],
                                        've' => $constantes["ve_facebook"]);
        }
        
        if( !isset($user_session->agente) ) {
            $tipo_usuario = '1';
        } else {
            $tipo_usuario = '2';
        }
        
        $variados = new Variados($serviceLocator);
        $variados->datosLayout($this->layout(), $config, '1');
        
        $campanaTable = $serviceLocator->get('Dashboard\Model\CupcampanaTable');

        $data = $campanaTable->getCampanasAll($empresa_promocion,$tipo_usuario);
        $dataG = $campanaTable->getCampanaGrupo($tipo_usuario);

        return new ViewModel(array('data' => $data, 
                                   'dataG' => $dataG,
                                   'user_session' => $user_session,
                                   'moneda' => $moneda,
                                   'directorio' => $ruta_int,
                                   'sep_path' => $sep_path,
                                   'portada' => $portada
                                   ));
    }
    
    public function phpinfoAction()
    {
        return new ViewModel();
    }
    
//    public function indexAction()
//    {
//        $this->layout('layout/layout_afiliacion');
//        
//        $serviceLocator = $this->getServiceLocator();
//        $config = $serviceLocator->get('config');
//        $constantes = $config['constantes'];
//
//        $user_session = new Container('user');
//        $user_session->facebook = array('id' => $constantes["id_facebook"],
//                                        've' => $constantes["ve_facebook"]);
//        
//        $pais = $config['id_pais'];
//        $capital = $config['id_capital'];
//        $existepromocion = false; 
//        
//        $departamentoTable = $serviceLocator->get('Dashboard\Model\UbidepartamentoTable');
//        $departamentos = $departamentoTable->getDepartamentosxPaisFavoritos($pais);
//        
//        $provinciaTable = $serviceLocator->get('Dashboard\Model\UbiprovinciaTable');
//        $provincias = $provinciaTable->getProvinciasxDepartamento($pais, $capital);
//        
//        $tipodocumentoTable = $serviceLocator->get('Dashboard\Model\GentipodocumentoTable');
//        $tipodocumentos = $tipodocumentoTable->fetchAll();
//        
//        $categoriaTable = $serviceLocator->get('Dashboard\Model\GencategoriaTable');
//        $categorias = $categoriaTable->fetchAll();
//        
//        
//        return new ViewModel(array('departamentos' => $departamentos, 
//                                   'provincias' => $provincias,
//                                   'tipodocumentos' => $tipodocumentos, 
//                                   'categorias' => $categorias,
//                                   'pais' => $pais, 
//                                   'capital' => $capital, 
//                                   'user_session' => $user_session,
//                                   'existepromocion' => $existepromocion));
//    }
    
    public function suscribirmeAction() {
        $datos = $this->params()->fromPost();
        
        $serviceLocator = $this->getServiceLocator();
        $clienteTable = $serviceLocator->get('Dashboard\Model\CupclienteTable');
        $preferenciasTable = $serviceLocator->get('Dashboard\Model\CupclientepreferenciasTable');
        
        $clienteTable->addCliente($datos);
        if(isset($datos["preferencia"])) {
            $preferenciasTable->addPreferencias($datos);
        }
        
        $datosCliente = ArrayUtils::iteratorToArray($clienteTable->getUsuarioByUser($datos["email"]));
        $datosPreferencia = ArrayUtils::iteratorToArray($preferenciasTable->getPreferenciasByUser($datos["email"]));
        
        $datosRespuesta = array('0' => $datosCliente,'1' => $datosPreferencia);
        
        $viewmodel = new ViewModel();
        $viewmodel->setTerminal(true);

        return $this->getResponse()->setContent(Json::encode($datosRespuesta));
        
    }
    
    public function departamentosAction()  {
        
        $pais   = $this->params()->fromPost("pais", null);
        
        $serviceLocator = $this->getServiceLocator();
   
        $departamentoTable = $serviceLocator->get('Dashboard\Model\UbidepartamentoTable');
        $departamentos = $departamentoTable->getDepartamentosxPais($pais);
        
        $viewmodel = new ViewModel(array('departamentos' => $departamentos));
        $viewmodel->setTerminal(true);
        
        return $viewmodel;
    }
    
    public function zonificacionAction()  {
        
        $pais   = $this->params()->fromPost("pais", null);
        $ciudad = $this->params()->fromPost("ciudad", null);
        
        $serviceLocator = $this->getServiceLocator();
   
        $provinciaTable = $serviceLocator->get('Dashboard\Model\UbiprovinciaTable');
        $provincias = $provinciaTable->getProvinciasxDepartamento($pais, $ciudad);
        
        $viewmodel = new ViewModel(array('provincias' => $provincias));
        $viewmodel->setTerminal(true);
        
        return $viewmodel;
    }
   
}
