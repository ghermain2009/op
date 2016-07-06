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
use Application\Services\Variados;


class MicuentaController extends AbstractActionController {

    public function misPedidosAction() {
        
        $serviceLocator = $this->getServiceLocator();
        $config = $serviceLocator->get('Config');
        
        $variados = new Variados($serviceLocator);
        $variados->datosLayout($this->layout(), $config, '2');

        return new ViewModel();
    }
    
}
