<?php
namespace BqUser\Event\Listener;

use Zend\EventManager\EventManagerInterface;
use BqCore\Event\Listener\AbstractListener;
use BqCore\Event\EntityEvent;

class User extends AbstractListener
{
    public function attach(EventManagerInterface $events) {
        $this->listeners[] = $events->attach(
            EntityEvent::EVENT_ADD_RELYON_ENTITY,
            array($this, 'onAddRelyonEntity')
        );
    }

    public function onAddRelyonEntity($event) {
        $target = $event->getTarget();
        $relyonEntity = $event->getRelyonEntity();
        if($target instanceof UserInterface 
            && $relyonEntity instanceof AccountInterface) {

            $accountManager = $this->getServiceLocator()->get('BqUser\User')
                ->getAccountManager($target);
            $accountManager->bindAccount($relyonEntity);
        }
    }
}
