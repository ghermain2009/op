<?php
/**
 * Description of LoginForm
 * @autor Francis Gonzales <fgonzalestello91@gmail.com>
 */
namespace Dashboard\Form;

use Zend\Form\Form;

class LoginForm extends Form
{
    public function __construct($name = null) {
        parent::__construct('login');
        $this->setAttribute('method', 'post');
        $this->setAttribute('role', 'form');
        $this->add(array(
            'name' => 'username',
            'attributes' => array(
                'type'  => 'text',
                'class'  => 'form-control',
                'placeholder'  => 'Ingrese Usuario',
            ),
        ));
        $this->add(array(
            'name' => 'password',
            'attributes' => array(
                'type'  => 'password',
                'class'  => 'form-control',
                'placeholder'  => 'Ingrese Password',
            )
        ));
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Ingresar',
                'id' => 'submitbutton',
                'class'  => 'btn btn-default',
            ),
        ));
    }
}
