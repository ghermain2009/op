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
use Zend\Json\Json;
use Zend\Session\Container;
use Zend\Mail\Message;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;
use Zend\Mail\Transport\SmtpOptions;
use Zend\View\Renderer\PhpRenderer;
use Zend\View\Resolver\TemplateMapResolver;

class ClienteController extends AbstractActionController {

    //put your code here
    public function emailclaveAction() {

        $email = $this->params()->fromPost("email", null);

        $serviceLocator = $this->getServiceLocator();
        $clienteTable = $serviceLocator->get('Dashboard\Model\CupclienteTable');
        $datos = $clienteTable->getUsuarioByUser($email);
        
        $config = $serviceLocator->get('Config');
        
        $activo   = $config['correo']['activo'];
        $name     = $config['correo']['name'];
        $host     = $config['correo']['host'];
        $port     = $config['correo']['port'];
        $tls      = $config['correo']['tls'];
        $username = $config['correo']['username'];
        $password = $config['correo']['password'];
        $cuenta   = $config['correo']['cuenta-recuperar-clave'];
        $localhost = $config['constantes']['localhost'];
        $telefono = $config['empresa']['telefono'];

        $data = array();
        foreach ($datos as $dato) {
            $data[] = $dato;
        }

        if (count($data) == 0) {
            $data[0]['validar'] = '2';
        } else {

            $nombre = $data[0]['nombres'];
            $token = base64_encode($email);
            
            if( $activo == '1' ) {

                $message = new Message();
                $message->addTo($email)
                        ->addFrom($cuenta)
                        ->setSubject('Nueva contraseña para Rebueno!‏');
                
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
                    'mailLayout' => __DIR__ . '/../../../../Application/view/application/cliente/emailclave.phtml'
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
            }

            $data[0]['validar'] = '1';
        }

        return $this->getResponse()->setContent(Json::encode($data));
    }

    public function recuperarclaveAction() {

        $token = $this->params()->fromQuery("token", null);

        $email = base64_decode($token);

        $serviceLocator = $this->getServiceLocator();
        $config = $serviceLocator->get('config');
        $clienteTable = $serviceLocator->get('Dashboard\Model\CupclienteTable');
        $datos = $clienteTable->getUsuarioByUser($email);

        $data = array();
        foreach ($datos as $dato) {
            $data[] = $dato;
        }
        //var_dump($data);
        if(count($data) == 0) {
            $email = '';
        } else {
            $email = $data[0]['email_cliente'];
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
        
        return new ViewModel(array('email' => $email) );
    }
    
    public function cambiarpasswordAction(){
        $email = $this->params()->fromPost('email',null);
        $clave = $this->params()->fromPost('clave',null);
        
        $datos = array('email' => $email,
                       'clave' => $clave);
        
        $serviceLocator = $this->getServiceLocator();
        $clienteTable = $serviceLocator->get('Dashboard\Model\CupclienteTable');
        $clienteTable->setPassword($datos);
        
        $data[0]['validar'] = '1';
        
        return $this->getResponse()->setContent(Json::encode($data));
        
    }
    
    public function verificaagenteAction() {

        $usuario = $this->params()->fromPost("usuario", null);
        $password = $this->params()->fromPost("password", null);

        $serviceLocator = $this->getServiceLocator();
        $usuarioTable = $serviceLocator->get('Dashboard\Model\UserTable');
        $datos = $usuarioTable->getUserAgente($usuario);

        $data = array();
        foreach ($datos as $dato) {
            $data[] = $dato;
        }
        
        $user_session = new Container('user');

        if (count($data) == 0) {
            $data[0]['validar'] = '3';
            $user_session->getManager()->getStorage()->clear('user');
        } else {
            if ($password == null) {
                $data[0]['validar'] = '0';
                $user_session->getManager()->getStorage()->clear('user');
            } else {
                if ($data[0]['password'] == sha1($password)) {
                    $data[0]['validar'] = '1';
                    $data[0]['email'] = base64_encode($data[0]['email']);
                    /* Guardamos los datos de la session del usuario */
                    $user_session->username = $usuario;
                    $user_session->nombre = $data[0]['full_name'];
                    $user_session->apellido = '';
                    $user_session->tipdoc = '';
                    $user_session->numdoc = '';
                    $user_session->telefono = '';
                    $user_session->celular = '';
                    $user_session->genero = '';
                    $user_session->facebook['login'] = 'N';
                    $user_session->agente = 'S';
                } else {
                    $data[0]['validar'] = '2';
                    $user_session->getManager()->getStorage()->clear('user');
                }
            }
        }

        return $this->getResponse()->setContent(Json::encode($data));
    }

}
