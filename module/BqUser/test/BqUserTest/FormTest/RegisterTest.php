<?php
namespace BqUseTest\FormTest;

use PHPUnit_Framework_TestCase;
use Zend\Mvc\Application;
use BqUser\Form\Register as RegisterForm;
use Zend\Validator\Db\NoRecordExists;

class RegisterTest extends PHPUnit_Framework_TestCase
{
    public function testInput() {    
        $registerForm = new RegisterForm();
        $registerForm->setData(array(
            'nickname' => 'test1',
            'email'    => 'test@test.com',
            'password' => '123qwe'
            ));
            
        $this->assertTrue($registerForm->isValid());
    }
    
    /**
     * @dataProvider inputErrorData
     **/
    public function testInputError($data) {
        $registerForm = new RegisterForm();
        $registerForm->setData($data);
        $this->assertFalse($registerForm->isValid());
    }

    /**
     * @dataProvider usernameData
     */
    public function testUsernameInput($username, $isValid) {
        $data = array(
            'nickname' => 'test1', 
            'email'=>'test@test.com', 
            'password'=>'123qew');

        $registerForm = new RegisterForm('register', 
            array('enable_username'=>true));
        $registerForm->setData($data);
        $this->assertFalse($registerForm->isValid());

        $data['username'] = $username;
        $registerForm->setData($data);
        $this->assertEquals($isValid, $registerForm->isValid());
    }

    /**
     * @dataProvider noRecordExistsData
     */
    public function testNicknameNoRecordExists($element, $table, $field) {
        $registerForm = new RegisterForm('regiter', array(
            'user_table'     => 'test_user_table',
            'account_table'  => 'test_account_table',
            'nickname_field' => 'test_nickname_filed',
            'email_field'    => 'test_email_filed',
            'username_field' => 'test_username_filed',
            'enable_username'=>true
        ));
        $validators = $registerForm->getInputFilter()->get($element)
            ->getValidatorChain()->getValidators();

        foreach($validators as $validator) {
            if($validator['instance'] instanceof NoRecordExists) {
                $dbValidator = $validator['instance'];
            }
        }
        if(!isset($dbValidator))
            $this->fail();
        $this->assertEquals($table, $dbValidator->getTable());
        $this->assertEquals($field, $dbValidator->getField());
    }

    public function noRecordExistsData() {
        return array(
            array('nickname', 'test_user_table', 'test_nickname_filed'),
            array('email', 'test_account_table', 'test_email_filed'),
            array('username', 'test_user_table', 'test_username_filed'),
        );
    }

    public function usernameData() {
        $longName = '';
        for($loop=0; $loop<30; $loop++)
            $longName .= 'a';

        return array(
            array('test1'   , true),
            array('test-1'  , true),
            array('1-test'  , false),
            array('test 1'  , false),
            array('t'       , false),
            array($longName , false),
        );
    }
    
    public function inputErrorData() {
        $trueData = array(
            'nickname' => 'test1', 
            'email'=>'test@test.com', 
            'password'=>'123qew');
        $errorDatas = array();

        $errorData = $trueData;
        unset($errorData['nickname']);
        $errorDatas[] = array($errorData);

        $errorData = $trueData;
        $errorData['nickname'] = 'abc';
        $errorDatas[] = array($errorData);

        $errorData = $trueData;
        for($loop=0; $loop<=30; $loop++)
            $errorData['nickname'] .= 'a';
        $errorDatas[] = array($errorData);

        $errorData = $trueData;
        unset($errorData['email']);
        $errorDatas[] = array($errorData);

        $errorData = $trueData;
        $errorData['email'] = 'abc';
        $errorDatas[] = array($errorData);

        $errorData = $trueData;
        unset($errorData['password']);
        $errorDatas[] = array($errorData);

        $errorData = $trueData;
        $errorData['password'] = 'a';
        $errorDatas[] = array($errorData);

        return $errorDatas;
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
