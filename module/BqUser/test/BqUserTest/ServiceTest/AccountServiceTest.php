<?php

namespace BqCoreTest\ServiceTest;

use PHPUnit_Framework_TestCase;
use Zend\Mvc\Application;
use BqUser\Form\Register as RegisterForm;

class AbstractServiceTest extends PHPUnit_Framework_TestCase
{
    protected $app;

    public function testRegister() {
#        $registerForm = new RegisterForm();
#        $registerForm->setData(array(
#            'email'    => 'test@test.com',
#            'nickname' => 'test',
#            'password' => '123qwe'
#        ));
#
#        $accountService = $this->getServiceLocator()->get('BqUser\Account');
#        $accountService->register($registerForm);
    }

    protected function getServiceLocator() {
        $serviceManager = $this->app->getServiceManager();
        $serviceManager->setAllowOverride(true);
        return $serviceManager;
    }

    protected function setUp() {
        $this->app = Application::init(include 'config/application.config.php');
    }
}
