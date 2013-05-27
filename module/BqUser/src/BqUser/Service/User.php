<?php
namespace BqUser\Service;

use BqCore\Service\AbstractTableService;
use BqUser\Entity\User as UserEntity;

class User extends AbstractTableService
{
    public function getAccountManager(UserInterface $user=null) {
        if($user === null) 
            $user = $this->getServiceLocator()->get('BqUser\Auth')->getUser();

        $config = $this->getServiceLocator()->get('BqUser\Config')
            ->get('account_manager');
        $adapterName = $config->get('adapter');
        $option = $config->get('options');

        $accountManager = new $adapterName($user, 
            $this->getServiceLocator(), $options);

        return $accountManager;
    }

    public function createEntity() {
        $user = new UserEntity('id', $this->getTable(), 
            $this->getAdapter());
        $user = $this->prepareEntity($user);
        return $userEntity;
    }

    public function getEntityName() { return 'bquser\user'; }
    public static function getTableName() { return 'bquser_user'; }
    public static function getAdapterServiceName() { return 'User\Db\Adapter'; }
}
