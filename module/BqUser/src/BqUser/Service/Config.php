<?php
namespace BqUser\Service;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;

class Config 
{
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $config = $this->getServiceLocator()->get('Configuration');
        return $config->get('BqUser');
    }
}
