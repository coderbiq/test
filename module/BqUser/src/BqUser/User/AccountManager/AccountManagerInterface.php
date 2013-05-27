<?php
namespace BqUser\User\AccountManager;

use Zend\Config;
use Zend\ServiceManager\ServiceLocatorInterface;
use BqUsre\Entity\UserInterface;
use BqUser\Entity\AccountInterface;

interface AccountManagerInterface
{
    public function __construct(UserInterface $user,
                                ServiceLocatorInterface $serviceLocator,
                                Config $options);
    public function bindAccount(AccountInterface $account);
    public function getAccounts();
}
