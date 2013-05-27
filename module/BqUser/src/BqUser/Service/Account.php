<?php
namespace BqUser\Service;

use BqCore\Service\AbstractTableService;
use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Result;
use Zend\Db\RowGateway\RowGateway;
use BqUser\Entity\Account as AccountEntity;
use BqUser\Form\Register as RegisterForm;
use BqUser\Form\Login as LoginForm;

class Account extends AbstractTableService implements AdapterInterface
{
    protected $authAccount;

    public function register(RegisterForm $registerForm) {
        if(!$registerForm->isValid()) 
            return false;

        $email    = $registerForm->get('email')->getValue();
        $nickname = $registerForm->get('nickname')->getValue();
        $password = $registerForm->get('password')->getValue();

        $user = $this->getServiceLocator()->get('BqUser\User')
            ->createEntity();
        if($form->has('username'))
            $user->setUsername($registerForm->get('username')->getValue());
        $user->setNickname($nickname)
            ->setEmail($email)
            ->save();

        $this->authAccount = $this->createEntity();
        $this->AuthAccount->setEmail($email)
            ->setPassword($password)
            ->setUser($user)
            ->save();

        $authService = $this->getServiceLocator()->get('BqUser\Auth');
        $authService->authenticate($this);

        return $user;
    }

    public function login(LoginForm $loginForm) {
        if(!$loginForm->isValid())
            return false;

        $email    = $loginForm->get('email')->getValue();
        $password = $loginForm->get('password')->getValue();

        $account = $this->search(array('email'=>$email))->current();
        if($account->password != md5($password))
            return false;

        $this->authAccount = $account;
        $authService = $this->getServiceLocator()->get('BqUser\Auth');
        $authService->authenticate($this);

        return $this->authAccount->getUser();
    }

    public function authenticate() {
        if(empty($this->authAccount))
            return new Result(Result::FAILURE_IDENTITY_NOT_FOUND);

        return new Result(Result::SUCCESS, 
            $this->authAccount->getUser()->getId());
    }

    public function createEntity() {
        $account = new AccountEntity('id', $this->getTable(), 
            $this->getAdapter());
        $account->setUserEntityName($this->getServiceLocator()
            ->get('BqUser\User')->getEntityName());
        $account = $this->prepareEntity($account);
        return $account;
    }

    public function getEntityName() { return 'bquser\account'; }
    public static function getTableName() { return 'bquser_account'; }
    public static function getAdapterServiceName() { return 'User\Db\Adapter'; }
}
