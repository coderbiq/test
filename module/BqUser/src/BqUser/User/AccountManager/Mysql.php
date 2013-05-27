<?php
namespace BqUser\User\AccountManager;

use Zend\Config;
use Zend\ServiceManager\ServiceLocatorInterface;
use BqUsre\Entity\UserInterface;
use BqUser\Entity\AccountInterface;

class Mysql implements AccountManagerInterface
{
    protected $options;
    protected $serviceLocator;
    protected $user;

    public function __construct(UserInterface $user, 
                                ServiceLocatorInterface $serviceLocator, 
                                Config $options) {
        $this->user = $user;
        $this->serviceLocator = $serviceLocator;
        $this->options = $options;
    }

    public function bindAccount(AccountInterface $account) {
        $row = new RowGateway('id', $this->getBindTable()->getTable(), 
            $this->getBindTable()->getAdapter());
        $row->userId = $this->user->getId();
        $row->accountId = $account->getId();
        $row->accountEntityName = $account->getEntityName();
        $row->created = time();
        $row->save();
    }

    public function getAccounts() {
        $bindAccounts = $this->getBindTable()
            ->select(array('userId'=>$this->user->getId()));
        $entityManagerAware = $this->serviceLocator
            ->get('BqCore\EntityManagerAware');
        $accounts = array();
        foreach($bindAccounts as $bindAccount) {
            $account = $entityManagerAware
                ->getEntityManager($bindAccount->accountEntityName)
                ->getEntities($bindAccount->accountId)->current();
            if($account instanceof AccountInterface)
                $accounts[] = $account;
        }
        return $accounts;
    }

    protected function getBindTable() {
        return new TableGateway($this->options->get('table_name'), 
            $this->serviceLocator->get('BqUser\Db\Adapter'));
    }

}
