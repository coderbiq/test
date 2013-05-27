<?php
namespace BqUser\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use BqUser\Form\Register as RegisterForm;

class IndexController extends AbstractActionController
{
    public function registerAction() {
        $form = new RegisterForm();

        return array('form'=>$form);
    }
}
