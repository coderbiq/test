<?php
namespace BqUser\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class Login extends Base
{
    public function __construct($name = null, $options = array()) {
        parent::__construct($name, $options);

        $this->remove('nickname');
        $this->add(array(
            'name'       => 'login',
            'type'       => 'Zend\Form\Element\Submit',
            'attributes' => array('value' => 'Submit'),
            'options'    => array('primary'=> true),
        ));
    }
}
