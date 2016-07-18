<?php

/**
 * Description of DashboardMenu
 *
 * @author fragote
 */
namespace Application\Navigation;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Navigation\Service\DefaultNavigationFactory;
use Zend\Authentication\AuthenticationService;
use Zend\Session\Container;
use Application\Helper\RouteHelper;

class ApplicationMenu extends DefaultNavigationFactory
{
    protected function getPages(ServiceLocatorInterface $serviceLocator) 
    {
        $menu = array();
        if (null == $this->pages) {
 
            $mvcEvent = $serviceLocator->get('Application')->getMvcEvent();
            $listMenu = $serviceLocator->get('Dashboard\Model\CupcampanaTable');
            
            $user_session = new Container('user');
            if(empty($user_session->agente)) {
                $tipo_acceso = '1';
            } else {
                $tipo_acceso = '2';
            }
            $dataMenu = $listMenu->getMenu($tipo_acceso);
            
            $menu = $this->menuFormat($dataMenu);
            
            $routeMatch = $mvcEvent->getRouteMatch();
            $router = $mvcEvent->getRouter();
            $pages = $this->getPagesFromConfig($menu);
            $this->pages = $this->injectComponents($pages, $routeMatch, $router);
        }
        
        return $this->pages;
    }
    
    public function menuFormat($dataMenu) 
    {
        $menu = array();
        $routHelper = new RouteHelper();
        
        $padre = '';
        
        $order_padre = 0;
        foreach ($dataMenu as $opt) {
            
            if( $opt['categoria'] != $padre ) {
                $order_padre++;
                $order_hijo = 0;
                $menu[$opt['id_categoria']] = array(
                    'label' => $opt['categoria'],
                    'uri' => "",
                    'order' => $order_padre,
                    'title' => $opt['cantidad']
                );
            }
            $order_hijo++;
            if($opt['sub_categoria_hija'] == '1') {
                $menu[$opt['id_categoria']]['pages'][] = array(
                    'label' => $opt['subcategoria'],
                    //'uri' => "javascript:postfunction('/campana','categoria','".base64_encode($opt['id_categoria'])."','".base64_encode($opt['id_sub_categoria'])."');",
                    'uri' => "/campana/categoria/".base64_encode($opt['id_categoria'])."/".base64_encode($opt['id_sub_categoria']),
                    'order' => $order_hijo,
                    'title' => $opt['cantidad']
                );
            } else {
                $menu[$opt['id_categoria']] = array(
                    'label' => $opt['categoria'],
                    'uri' => "/campana/categoria/".base64_encode($opt['id_categoria'])."/".base64_encode($opt['id_sub_categoria']),
                    'order' => $order_padre,
                    'title' => $opt['cantidad']
                );
            }
            
            $padre = $opt['categoria'];
        }
        
        return $menu;
    }
}
