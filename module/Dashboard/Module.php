<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Dashboard;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Dashboard\Model\Privilege;
use Dashboard\Model\PrivilegeTable;
use Dashboard\Model\Role;
use Dashboard\Model\RoleTable;
use Dashboard\Model\Hostipohospedaje;
use Dashboard\Model\HostipohospedajeTable;
use Dashboard\Model\Hosadicionales;
use Dashboard\Model\HosadicionalesTable;
use Dashboard\Model\Hostipoadicional;
use Dashboard\Model\HostipoadicionalTable;
use Dashboard\Model\Hoscategoriahabitacion;
use Dashboard\Model\HoscategoriahabitacionTable;
use Dashboard\Model\Hoshospedaje;
use Dashboard\Model\HoshospedajeTable;
use Dashboard\Model\Hoshospedajecategoria;
use Dashboard\Model\HoshospedajecategoriaTable;
use Dashboard\Model\Hoshabitacionadicionales;
use Dashboard\Model\HoshabitacionadicionalesTable;
use Dashboard\Model\Hosvoucher;
use Dashboard\Model\HosvoucherTable;
use Dashboard\Model\User;
use Dashboard\Model\UserTable;


use Dashboard\Model\Ubipais;
use Dashboard\Model\UbipaisTable;
use Dashboard\Model\Ubidepartamento;
use Dashboard\Model\UbidepartamentoTable;
use Dashboard\Model\Ubiprovincia;
use Dashboard\Model\UbiprovinciaTable;

use Dashboard\Model\Cupcampana;
use Dashboard\Model\CupcampanaTable;
use Dashboard\Model\Cupcampanacategoria;
use Dashboard\Model\CupcampanacategoriaTable;
use Dashboard\Model\Cupcampanaopcion;
use Dashboard\Model\CupcampanaopcionTable;
use Dashboard\Model\Cupcliente;
use Dashboard\Model\CupclienteTable;
use Dashboard\Model\Cupcupon;
use Dashboard\Model\CupcuponTable;
use Dashboard\Model\Cupliquidacion;
use Dashboard\Model\CupliquidacionTable;
use Dashboard\Model\Cupliquidacioncupon;
use Dashboard\Model\CupliquidacioncuponTable;
use Dashboard\Model\Genempresa;
use Dashboard\Model\GenempresaTable;

use Dashboard\Model\Gentipodocumento;
use Dashboard\Model\GentipodocumentoTable;
use Dashboard\Model\Gencategoria;
use Dashboard\Model\GencategoriaTable;
use Dashboard\Model\Cupclientepreferencias;
use Dashboard\Model\CupclientepreferenciasTable;

use Dashboard\Model\Concontrato;
use Dashboard\Model\ConcontratoTable;
use Dashboard\Model\Concontratoanexo;
use Dashboard\Model\ConcontratoanexoTable;
use Dashboard\Model\Conestadocontrato;
use Dashboard\Model\ConestadocontratoTable;
use Dashboard\Model\Contipoobservacion;
use Dashboard\Model\ContipoobservacionTable;

use Dashboard\Model\Cupclientepayme;
use Dashboard\Model\CupclientepaymeTable;
use Dashboard\Model\Cupopcionseleccion;
use Dashboard\Model\CupopcionseleccionTable;
use Dashboard\Model\Cupopcionselecciondetalle;
use Dashboard\Model\CupopcionselecciondetalleTable;

class Module implements AutoloaderProviderInterface, ConfigProviderInterface
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        
        $application = $e->getApplication();
        $sm = $application->getServiceManager();
        $sharedManager = $eventManager->getSharedManager();
        //Setting layouts
        $sharedManager->attach('Zend\Mvc\Controller\AbstractController', 'dispatch', function($e) {
            $controller      = $e->getTarget();
            $controllerClass = get_class($controller);
            $moduleNamespace = substr($controllerClass, 0, strpos($controllerClass, '\\'));
            $config          = $e->getApplication()->getServiceManager()->get('config');

            if (isset($config['module_layouts'][$moduleNamespace])) {
                $controller->layout($config['module_layouts'][$moduleNamespace]);
            }
        }, 100);
        
        $router = $sm->get('router');
        $request = $sm->get('request');
        $matchedRoute = $router->match($request);
        if (null !== $matchedRoute) {
            //Check the Authentication in every controller different with Login
            //If there is no identity this will redirect to Login
            $sharedManager->attach('Zend\Mvc\Controller\AbstractActionController', 'dispatch', function() use ($sm) {
                $sm->get('ControllerPluginManager')->get('Authentication')->isAuthtenticated();    
            }, 2);
            // @todo implement ACL
            //Check ACL and show the menu
            //$sharedManager->attach('Zend\Mvc\Controller\AbstractActionController', 'dispatch', function() use ($sm) {
            //    $sm->get('ControllerPluginManager')->get('Privileges')->doAuthorization();
            //}, 2);
        }
        
        $e->getApplication()->getServiceManager()->get('translator');
        $e->getApplication()->getServiceManager()->get('viewhelpermanager')->setFactory('controllerName', function($sm) use ($e) {
            $viewHelper = new \Dashboard\Helper\ControllerNameHelper($e->getRouteMatch());
            
            return $viewHelper;
        });
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                    'NavigationHome'  => 'Application\Navigation\ApplicationMenuFactory',
                    'Navigation'  => 'Dashboard\Navigation\DashboardMenuFactory',
                    //Registrando Modelos
                    'Dashboard\Model\PrivilegeTable' => function($sl){
                        $gateway = $sl->get('PrivilegeTableGateway');
                        $table = new PrivilegeTable($gateway);
                        return $table;
                    },
                    'PrivilegeTableGateway' => function($sl) {
                        $adapter = $sl->get('Zend\Db\Adapter\Adapter');
                        $rsPrototype = new ResultSet();
                        $rsPrototype->setArrayObjectPrototype(new Privilege());
                        $tableGateway = new TableGateway('privilege', $adapter, null, $rsPrototype);
                        return $tableGateway;
                    },
                    'Dashboard\Model\UserTable' => function($sl){
                        $gateway = $sl->get('UserTableGateway');
                        $table = new UserTable($gateway);
                        return $table;
                    },
                    'UserTableGateway' => function($sl) {
                        $adapter = $sl->get('Zend\Db\Adapter\Adapter');
                        $rsPrototype = new ResultSet();
                        $rsPrototype->setArrayObjectPrototype(new User());
                        $tableGateway = new TableGateway('user', $adapter, null, $rsPrototype);
                        return $tableGateway;
                    },
                    'Dashboard\Model\RoleTable' => function($sl){
                        $gateway = $sl->get('RoleTableGateway');
                        $table = new RoleTable($gateway);
                        return $table;
                    },
                    'RoleTableGateway' => function($sl) {
                        $adapter = $sl->get('Zend\Db\Adapter\Adapter');
                        $rsPrototype = new ResultSet();
                        $rsPrototype->setArrayObjectPrototype(new Role());
                        $tableGateway = new TableGateway('role', $adapter, null, $rsPrototype);
                        return $tableGateway;
                    },
                    'Dashboard\Model\HostipohospedajeTable' => function($sl){
                        $gateway = $sl->get('HostipohospedajeTableGateway');
                        $table = new HostipohospedajeTable($gateway);
                        return $table;
                    },
                    'HostipohospedajeTableGateway' => function($sl) {
                        $adapter = $sl->get('Zend\Db\Adapter\Adapter');
                        $rsPrototype = new ResultSet();
                        $rsPrototype->setArrayObjectPrototype(new Hostipohospedaje());
                        $tableGateway = new TableGateway('hos_tipo_hospedaje', $adapter, null, $rsPrototype);
                        return $tableGateway;
                    },
                            
                    'Dashboard\Model\HosadicionalesTable' => function($sl){
                        $gateway = $sl->get('HosadicionalesTableGateway');
                        $table = new HosadicionalesTable($gateway);
                        return $table;
                    },
                    'HosadicionalesTableGateway' => function($sl) {
                        $adapter = $sl->get('Zend\Db\Adapter\Adapter');
                        $rsPrototype = new ResultSet();
                        $rsPrototype->setArrayObjectPrototype(new Hosadicionales());
                        $tableGateway = new TableGateway('hos_adicionales', $adapter, null, $rsPrototype);
                        return $tableGateway;
                    },
                    'Dashboard\Model\HostipoadicionalTable' => function($sl){
                        $gateway = $sl->get('HostipoadicionalTableGateway');
                        $table = new HostipoadicionalTable($gateway);
                        return $table;
                    },
                    'HostipoadicionalTableGateway' => function($sl) {
                        $adapter = $sl->get('Zend\Db\Adapter\Adapter');
                        $rsPrototype = new ResultSet();
                        $rsPrototype->setArrayObjectPrototype(new Hostipoadicional());
                        $tableGateway = new TableGateway('hos_tipo_adicional', $adapter, null, $rsPrototype);
                        return $tableGateway;
                    },
                    'Dashboard\Model\HoscategoriahabitacionTable' => function($sl){
                        $gateway = $sl->get('HoscategoriahabitacionTableGateway');
                        $table = new HoscategoriahabitacionTable($gateway);
                        return $table;
                    },
                    'HoscategoriahabitacionTableGateway' => function($sl) {
                        $adapter = $sl->get('Zend\Db\Adapter\Adapter');
                        $rsPrototype = new ResultSet();
                        $rsPrototype->setArrayObjectPrototype(new Hoscategoriahabitacion());
                        $tableGateway = new TableGateway('hos_categoria_habitacion', $adapter, null, $rsPrototype);
                        return $tableGateway;
                    },
                            
                    'Dashboard\Model\HoshospedajeTable' => function($sl){
                        $gateway = $sl->get('HoshospedajeTableGateway');
                        $table = new HoshospedajeTable($gateway);
                        return $table;
                    },
                    'HoshospedajeTableGateway' => function($sl) {
                        $adapter = $sl->get('Zend\Db\Adapter\Adapter');
                        $rsPrototype = new ResultSet();
                        $rsPrototype->setArrayObjectPrototype(new Hoshospedaje());
                        $tableGateway = new TableGateway('hos_hospedaje', $adapter, null, $rsPrototype);
                        return $tableGateway;
                    },
                    
                    'Dashboard\Model\HoshospedajecategoriaTable' => function($sl){
                        $gateway = $sl->get('HoshospedajecategoriaTableGateway');
                        $table = new HoshospedajecategoriaTable($gateway);
                        return $table;
                    },
                    'HoshospedajecategoriaTableGateway' => function($sl) {
                        $adapter = $sl->get('Zend\Db\Adapter\Adapter');
                        $rsPrototype = new ResultSet();
                        $rsPrototype->setArrayObjectPrototype(new Hoshospedajecategoria());
                        $tableGateway = new TableGateway('hos_hospedaje_categoria', $adapter, null, $rsPrototype);
                        return $tableGateway;
                    },
                    'Dashboard\Model\HoshabitacionadicionalesTable' => function($sl){
                        $gateway = $sl->get('HoshabitacionadicionalesTableGateway');
                        $table = new HoshabitacionadicionalesTable($gateway);
                        return $table;
                    },
                    'HoshabitacionadicionalesTableGateway' => function($sl) {
                        $adapter = $sl->get('Zend\Db\Adapter\Adapter');
                        $rsPrototype = new ResultSet();
                        $rsPrototype->setArrayObjectPrototype(new Hoshabitacionadicionales());
                        $tableGateway = new TableGateway('hos_habitacion_adicionales', $adapter, null, $rsPrototype);
                        return $tableGateway;
                    },
                    
                    'Dashboard\Model\HosvoucherTable' => function($sl){
                        $gateway = $sl->get('HosvoucherTableGateway');
                        $table = new HosvoucherTable($gateway);
                        return $table;
                    },
                    'HosvoucherTableGateway' => function($sl) {
                        $adapter = $sl->get('Zend\Db\Adapter\Adapter');
                        $rsPrototype = new ResultSet();
                        $rsPrototype->setArrayObjectPrototype(new Hosvoucher());
                        $tableGateway = new TableGateway('hos_voucher', $adapter, null, $rsPrototype);
                        return $tableGateway;
                    },
                            
                    'Dashboard\Model\CupcampanaTable' => function($sl){
                        $gateway = $sl->get('CupcampanaTableGateway');
                        $table = new CupcampanaTable($gateway);
                        return $table;
                    },
                    'CupcampanaTableGateway' => function($sl) {
                        $adapter = $sl->get('Zend\Db\Adapter\Adapter');
                        $rsPrototype = new ResultSet();
                        $rsPrototype->setArrayObjectPrototype(new Cupcampana());
                        $tableGateway = new TableGateway('cup_campana', $adapter, null, $rsPrototype);
                        return $tableGateway;
                    },
                    'Dashboard\Model\CupcampanacategoriaTable' => function($sl){
                        $gateway = $sl->get('CupcampanacategoriaTableGateway');
                        $table = new CupcampanacategoriaTable($gateway);
                        return $table;
                    },
                    'CupcampanacategoriaTableGateway' => function($sl) {
                        $adapter = $sl->get('Zend\Db\Adapter\Adapter');
                        $rsPrototype = new ResultSet();
                        $rsPrototype->setArrayObjectPrototype(new Cupcampanacategoria());
                        $tableGateway = new TableGateway('cup_campana_categoria', $adapter, null, $rsPrototype);
                        return $tableGateway;
                    },
                    'Dashboard\Model\CupcampanaopcionTable' => function($sl){
                        $gateway = $sl->get('CupcampanaopcionTableGateway');
                        $table = new CupcampanaopcionTable($gateway);
                        return $table;
                    },
                    'CupcampanaopcionTableGateway' => function($sl) {
                        $adapter = $sl->get('Zend\Db\Adapter\Adapter');
                        $rsPrototype = new ResultSet();
                        $rsPrototype->setArrayObjectPrototype(new Cupcampanaopcion());
                        $tableGateway = new TableGateway('cup_campana_opcion', $adapter, null, $rsPrototype);
                        return $tableGateway;
                    },
                    'Dashboard\Model\CupcuponTable' => function($sl){
                        $gateway = $sl->get('CupcuponTableGateway');
                        $table = new CupcuponTable($gateway);
                        return $table;
                    },
                    'CupcuponTableGateway' => function($sl) {
                        $adapter = $sl->get('Zend\Db\Adapter\Adapter');
                        $rsPrototype = new ResultSet();
                        $rsPrototype->setArrayObjectPrototype(new Cupcupon());
                        $tableGateway = new TableGateway('cup_cupon', $adapter, null, $rsPrototype);
                        return $tableGateway;
                    },
                            
                    'Dashboard\Model\CupliquidacionTable' => function($sl){
                        $gateway = $sl->get('CupliquidacionTableGateway');
                        $table = new CupliquidacionTable($gateway);
                        return $table;
                    },
                    'CupliquidacionTableGateway' => function($sl) {
                        $adapter = $sl->get('Zend\Db\Adapter\Adapter');
                        $rsPrototype = new ResultSet();
                        $rsPrototype->setArrayObjectPrototype(new Cupliquidacion());
                        $tableGateway = new TableGateway('cup_liquidacion', $adapter, null, $rsPrototype);
                        return $tableGateway;
                    },
                            
                    'Dashboard\Model\CupliquidacioncuponTable' => function($sl){
                        $gateway = $sl->get('CupliquidacioncuponTableGateway');
                        $table = new CupliquidacioncuponTable($gateway);
                        return $table;
                    },
                    'CupliquidacioncuponTableGateway' => function($sl) {
                        $adapter = $sl->get('Zend\Db\Adapter\Adapter');
                        $rsPrototype = new ResultSet();
                        $rsPrototype->setArrayObjectPrototype(new Cupliquidacioncupon());
                        $tableGateway = new TableGateway('cup_liquidacion_cupon', $adapter, null, $rsPrototype);
                        return $tableGateway;
                    },
                            
                    'Dashboard\Model\CupclienteTable' => function($sl){
                        $gateway = $sl->get('CupclienteTableGateway');
                        $table = new CupclienteTable($gateway);
                        return $table;
                    },
                    'CupclienteTableGateway' => function($sl) {
                        $adapter = $sl->get('Zend\Db\Adapter\Adapter');
                        $rsPrototype = new ResultSet();
                        $rsPrototype->setArrayObjectPrototype(new Cupcliente());
                        $tableGateway = new TableGateway('cup_cliente', $adapter, null, $rsPrototype);
                        return $tableGateway;
                    },
                    'Dashboard\Model\GenempresaTable' => function($sl){
                        $gateway = $sl->get('GenempresaTableGateway');
                        $table = new GenempresaTable($gateway);
                        return $table;
                    },
                    'GenempresaTableGateway' => function($sl) {
                        $adapter = $sl->get('Zend\Db\Adapter\Adapter');
                        $rsPrototype = new ResultSet();
                        $rsPrototype->setArrayObjectPrototype(new Genempresa());
                        $tableGateway = new TableGateway('gen_empresa', $adapter, null, $rsPrototype);
                        return $tableGateway;
                    },
                    'Dashboard\Model\GentipodocumentoTable' => function($sl){
                        $gateway = $sl->get('GentipodocumentoTableGateway');
                        $table = new GentipodocumentoTable($gateway);
                        return $table;
                    },
                    'GentipodocumentoTableGateway' => function($sl) {
                        $adapter = $sl->get('Zend\Db\Adapter\Adapter');
                        $rsPrototype = new ResultSet();
                        $rsPrototype->setArrayObjectPrototype(new Gentipodocumento());
                        $tableGateway = new TableGateway('gen_tipo_documento', $adapter, null, $rsPrototype);
                        return $tableGateway;
                    },
                    'Dashboard\Model\GencategoriaTable' => function($sl){
                        $gateway = $sl->get('GencategoriaTableGateway');
                        $table = new GencategoriaTable($gateway);
                        return $table;
                    },
                    'GencategoriaTableGateway' => function($sl) {
                        $adapter = $sl->get('Zend\Db\Adapter\Adapter');
                        $rsPrototype = new ResultSet();
                        $rsPrototype->setArrayObjectPrototype(new Gencategoria());
                        $tableGateway = new TableGateway('gen_categoria', $adapter, null, $rsPrototype);
                        return $tableGateway;
                    },
                    'Dashboard\Model\CupclientepreferenciasTable' => function($sl){
                        $gateway = $sl->get('CupclientepreferenciasTableGateway');
                        $table = new CupclientepreferenciasTable($gateway);
                        return $table;
                    },
                    'CupclientepreferenciasTableGateway' => function($sl) {
                        $adapter = $sl->get('Zend\Db\Adapter\Adapter');
                        $rsPrototype = new ResultSet();
                        $rsPrototype->setArrayObjectPrototype(new Cupclientepreferencias());
                        $tableGateway = new TableGateway('cup_cliente_preferencias', $adapter, null, $rsPrototype);
                        return $tableGateway;
                    },
                    'Dashboard\Model\UbipaisTable' => function($sl){
                        $gateway = $sl->get('UbipaisTableGateway');
                        $table = new UbipaisTable($gateway);
                        return $table;
                    },
                    'UbipaisTableGateway' => function($sl) {
                        $adapter = $sl->get('Zend\Db\Adapter\Adapter');
                        $rsPrototype = new ResultSet();
                        $rsPrototype->setArrayObjectPrototype(new Ubipais());
                        $tableGateway = new TableGateway('ubi_pais', $adapter, null, $rsPrototype);
                        return $tableGateway;
                    },
                    'Dashboard\Model\UbidepartamentoTable' => function($sl){
                        $gateway = $sl->get('UbidepartamentoTableGateway');
                        $table = new UbidepartamentoTable($gateway);
                        return $table;
                    },
                    'UbidepartamentoTableGateway' => function($sl) {
                        $adapter = $sl->get('Zend\Db\Adapter\Adapter');
                        $rsPrototype = new ResultSet();
                        $rsPrototype->setArrayObjectPrototype(new Ubidepartamento());
                        $tableGateway = new TableGateway('ubi_departamento', $adapter, null, $rsPrototype);
                        return $tableGateway;
                    },
                            
                    'Dashboard\Model\UbiprovinciaTable' => function($sl){
                        $gateway = $sl->get('UbiprovinciaTableGateway');
                        $table = new UbiprovinciaTable($gateway);
                        return $table;
                    },
                    'UbiprovinciaTableGateway' => function($sl) {
                        $adapter = $sl->get('Zend\Db\Adapter\Adapter');
                        $rsPrototype = new ResultSet();
                        $rsPrototype->setArrayObjectPrototype(new Ubiprovincia());
                        $tableGateway = new TableGateway('ubi_provincia', $adapter, null, $rsPrototype);
                        return $tableGateway;
                    },
                            
                    'Dashboard\Model\ConcontratoTable' => function($sl){
                        $gateway = $sl->get('ConcontratoTableGateway');
                        $table = new ConcontratoTable($gateway);
                        return $table;
                    },
                    'ConcontratoTableGateway' => function($sl) {
                        $adapter = $sl->get('Zend\Db\Adapter\Adapter');
                        $rsPrototype = new ResultSet();
                        $rsPrototype->setArrayObjectPrototype(new Concontrato());
                        $tableGateway = new TableGateway('con_contrato', $adapter, null, $rsPrototype);
                        return $tableGateway;
                    },
                    'Dashboard\Model\ConcontratoanexoTable' => function($sl){
                        $gateway = $sl->get('ConcontratoanexoTableGateway');
                        $table = new ConcontratoanexoTable($gateway);
                        return $table;
                    },
                    'ConcontratoanexoTableGateway' => function($sl) {
                        $adapter = $sl->get('Zend\Db\Adapter\Adapter');
                        $rsPrototype = new ResultSet();
                        $rsPrototype->setArrayObjectPrototype(new Concontratoanexo());
                        $tableGateway = new TableGateway('con_contrato_anexo', $adapter, null, $rsPrototype);
                        return $tableGateway;
                    },
                    'Dashboard\Model\ConestadocontratoTable' => function($sl){
                        $gateway = $sl->get('ConestadocontratoTableGateway');
                        $table = new ConestadocontratoTable($gateway);
                        return $table;
                    },
                    'ConestadocontratoTableGateway' => function($sl) {
                        $adapter = $sl->get('Zend\Db\Adapter\Adapter');
                        $rsPrototype = new ResultSet();
                        $rsPrototype->setArrayObjectPrototype(new Conestadocontrato());
                        $tableGateway = new TableGateway('con_estado_contrato', $adapter, null, $rsPrototype);
                        return $tableGateway;
                    },
                    'Dashboard\Model\ContipoobservacionTable' => function($sl){
                        $gateway = $sl->get('ContipoobservacionTableGateway');
                        $table = new ContipoobservacionTable($gateway);
                        return $table;
                    },
                    'ContipoobservacionTableGateway' => function($sl) {
                        $adapter = $sl->get('Zend\Db\Adapter\Adapter');
                        $rsPrototype = new ResultSet();
                        $rsPrototype->setArrayObjectPrototype(new Contipoobservacion());
                        $tableGateway = new TableGateway('con_tipo_observacion', $adapter, null, $rsPrototype);
                        return $tableGateway;
                    },
                    'Dashboard\Model\CupclientepaymeTable' => function($sl){
                        $gateway = $sl->get('CupclientepaymeTableGateway');
                        $table = new CupclientepaymeTable($gateway);
                        return $table;
                    },
                    'CupclientepaymeTableGateway' => function($sl) {
                        $adapter = $sl->get('Zend\Db\Adapter\Adapter');
                        $rsPrototype = new ResultSet();
                        $rsPrototype->setArrayObjectPrototype(new Cupclientepayme());
                        $tableGateway = new TableGateway('cup_cliente_payme', $adapter, null, $rsPrototype);
                        return $tableGateway;
                    },
                    'Dashboard\Model\CupopcionseleccionTable' => function($sl){
                        $gateway = $sl->get('CupopcionseleccionTableGateway');
                        $table = new CupopcionseleccionTable($gateway);
                        return $table;
                    },
                    'CupopcionseleccionTableGateway' => function($sl) {
                        $adapter = $sl->get('Zend\Db\Adapter\Adapter');
                        $rsPrototype = new ResultSet();
                        $rsPrototype->setArrayObjectPrototype(new Cupopcionseleccion());
                        $tableGateway = new TableGateway('cup_opcion_seleccion', $adapter, null, $rsPrototype);
                        return $tableGateway;
                    },
                    'Dashboard\Model\CupopcionselecciondetalleTable' => function($sl){
                        $gateway = $sl->get('CupopcionselecciondetalleTableGateway');
                        $table = new CupopcionselecciondetalleTable($gateway);
                        return $table;
                    },
                    'CupopcionselecciondetalleTableGateway' => function($sl) {
                        $adapter = $sl->get('Zend\Db\Adapter\Adapter');
                        $rsPrototype = new ResultSet();
                        $rsPrototype->setArrayObjectPrototype(new Cupopcionselecciondetalle());
                        $tableGateway = new TableGateway('cup_opcion_seleccion_detalle', $adapter, null, $rsPrototype);
                        return $tableGateway;
                    },
                )
            );
            
    }
}
