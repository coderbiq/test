<?php
namespace BqUser\Form;

class Register extends Base
{
    public function __construct($name = null, $options = array()) {
        parent::__construct($name, $options);

        $this->add(array(
            'name'       => 'register',
            'attributes' => array(
                'type'   => 'submit',
                'class'  => 'btn btn-primary'
            ),
            'options' => array('label' => '注册')
        ));
    }
}
