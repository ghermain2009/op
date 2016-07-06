<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Application\Form;
/**
 * Description of EnviopaymeForm
 *
 * @author Administrador
 */
use Zend\Form\Form;

class EnviopaymeForm extends Form {
    //put your code here
    public function __construct($datos) {
        
        parent::__construct('enviopayme');
        
        $this->setAttributes(array('method' => 'post',
                                   'class'  => 'form-horizontal',
                                   'role'   => 'form',
                                   'name'   => 'frmPayme',
                                   'action' => $datos['url_vpos']));
        
        $this->add(array(
            'name' => 'acquirerId',
            'attributes' => array(
                'type'  => 'hidden',
                'class' => 'form-control input-sm',
                'value' => $datos['acquirerId']
            ),
        ));
        
        $this->add(array(
            'name' => 'idCommerce',
            'attributes' => array(
                'type'  => 'hidden',
                'class' => 'form-control input-sm',
                'value' => $datos['idCommerce']
            ),
        ));
        
        $this->add(array(
            'name' => 'purchaseOperationNumber',
            'attributes' => array(
                'type'  => 'hidden',
                'class' => 'form-control input-sm',
                'value' => $datos['purchaseOperationNumber']
            ),
        ));
        
        $this->add(array(
            'name' => 'purchaseAmount',
            'attributes' => array(
                'type'  => 'hidden',
                'class' => 'form-control input-sm',
                'value' => $datos['purchaseAmount']
            ),
        ));
        
        $this->add(array(
            'name' => 'purchaseCurrencyCode',
            'attributes' => array(
                'type'  => 'hidden',
                'class' => 'form-control input-sm',
                'value' => $datos['purchaseCurrencyCode']
            ),
        ));
        
        $this->add(array(
            'name' => 'language',
            'attributes' => array(
                'type'  => 'hidden',
                'class' => 'form-control input-sm',
                'value' => $datos['language']
            ),
        ));
        
        $this->add(array(
            'name' => 'shippingFirstName',
            'attributes' => array(
                'type'  => 'hidden',
                'class' => 'form-control input-sm',
                'value' => $datos['shippingFirstName']
            ),
        ));
        
        $this->add(array(
            'name' => 'shippingLastName',
            'attributes' => array(
                'type'  => 'hidden',
                'class' => 'form-control input-sm',
                'value' => $datos['shippingLastName']
            ),
        ));
        
        $this->add(array(
            'name' => 'shippingEmail',
            'attributes' => array(
                'type'  => 'hidden',
                'class' => 'form-control input-sm',
                'value' => $datos['shippingEmail']
            ),
        ));
        
        $this->add(array(
            'name' => 'shippingAddress',
            'attributes' => array(
                'type'  => 'hidden',
                'class' => 'form-control input-sm',
                'value' => $datos['shippingAddress']
            ),
        ));
        
        $this->add(array(
            'name' => 'shippingZIP',
            'attributes' => array(
                'type'  => 'hidden',
                'class' => 'form-control input-sm',
                'value' => $datos['shippingZIP']
            ),
        ));
        
        $this->add(array(
            'name' => 'shippingCity',
            'attributes' => array(
                'type'  => 'hidden',
                'class' => 'form-control input-sm',
                'value' => $datos['shippingCity']
            ),
        ));
        
        $this->add(array(
            'name' => 'shippingState',
            'attributes' => array(
                'type'  => 'hidden',
                'class' => 'form-control input-sm',
                'value' => $datos['shippingState']
            ),
        ));
        
        $this->add(array(
            'name' => 'shippingCountry',
            'attributes' => array(
                'type'  => 'hidden',
                'class' => 'form-control input-sm',
                'value' => $datos['shippingCountry']
            ),
        ));
        
        $this->add(array(
            'name' => 'userCommerce',
            'attributes' => array(
                'type'  => 'hidden',
                'class' => 'form-control input-sm',
                'value' => $datos['userCommerce']
            ),
        ));
        
        $this->add(array(
            'name' => 'userCodePayme',
            'attributes' => array(
                'type'  => 'hidden',
                'class' => 'form-control input-sm',
                'value' => $datos['userCodePayme']
            ),
        ));
        
        $this->add(array(
            'name' => 'descriptionProducts',
            'attributes' => array(
                'type'  => 'hidden',
                'class' => 'form-control input-sm',
                'value' => $datos['descriptionProducts']
            ),
        ));
        
        $this->add(array(
            'name' => 'programmingLanguage',
            'attributes' => array(
                'type'  => 'hidden',
                'class' => 'form-control input-sm',
                'value' => $datos['programmingLanguage']
            ),
        ));
        
        $this->add(array(
            'name' => 'reserved1',
            'attributes' => array(
                'type'  => 'hidden',
                'class' => 'form-control input-sm',
                'value' => $datos['reserved1']
            ),
        ));
        
        $this->add(array(
            'name' => 'purchaseVerification',
            'attributes' => array(
                'type'  => 'hidden',
                'class' => 'form-control input-sm',
                'value' => $datos['purchaseVerification']
            ),
        ));
        
//        $this->add(array(
//            'name' => 'submitbutton',
//            'attributes' => array(
//                'type'  => 'submit',
//                'value' => 'Enviar',
//                'id' => 'submitbutton',
//                'class'  => 'btn btn-default',
//            ),
//        ));

    }
}
