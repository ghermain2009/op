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

class InteresController extends AbstractActionController {
    //put your code here
    public function indexAction(){
        $serviceLocator = $this->getServiceLocator();
        $config = $serviceLocator->get('config');
        $empresa = $config['empresa'];
        
        $variados = new Variados($serviceLocator);
        $variados->datosLayout($this->layout(), $config, '2');
        
        return new ViewModel(array('empresa' => $empresa));
    }
    
    public function comofuncionaAction(){
        $serviceLocator = $this->getServiceLocator();
        $config = $serviceLocator->get('config');
        $empresa = $config['empresa'];
        
        $variados = new Variados($serviceLocator);
        $variados->datosLayout($this->layout(), $config, '2');
        
        return new ViewModel(array('empresa' => $empresa));
    }
    
    public function preguntasfrecuentesAction(){
        $serviceLocator = $this->getServiceLocator();
        $config = $serviceLocator->get('config');
        $empresa = $config['empresa'];
        
        $variados = new Variados($serviceLocator);
        $variados->datosLayout($this->layout(), $config, '2');
        
        return new ViewModel(array('empresa' => $empresa));
    }
    
    public function terminosycondicionesAction(){
        $serviceLocator = $this->getServiceLocator();
        $config = $serviceLocator->get('config');
        
        $variados = new Variados($serviceLocator);
        $variados->datosLayout($this->layout(), $config, '2');
        
        return new ViewModel();
    }
    
    public function contactanosAction(){
        $serviceLocator = $this->getServiceLocator();
        $config = $serviceLocator->get('config');
        $empresa = $config['empresa'];
        
        $variados = new Variados($serviceLocator);
        $variados->datosLayout($this->layout(), $config, '2');
        
        return new ViewModel(array('empresa' => $empresa));
    }
    
    public function politicasdeprivacidadAction(){
        $serviceLocator = $this->getServiceLocator();
        $config = $serviceLocator->get('config');
        $empresa = $config['empresa'];
        
        $variados = new Variados($serviceLocator);
        $variados->datosLayout($this->layout(), $config, '2');
        
        return new ViewModel(array('empresa' => $empresa));
    }
    
    public function mapadesitioAction(){
        $serviceLocator = $this->getServiceLocator();
        $categoriaTable = $serviceLocator->get('Dashboard\Model\GencategoriaTable');
        
        $config = $serviceLocator->get('config');
        $empresa = $config['empresa'];
        $categorias = $categoriaTable->fetchAll();
        
        $variados = new Variados($serviceLocator);
        $variados->datosLayout($this->layout(), $config, '2');
        
        return new ViewModel(array('categorias' => $categorias,
                                   'empresa' => $empresa));
    }
    
}
