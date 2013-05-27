<?php
return array(
    'BqUser' => array(
        'account_manager' => array(
            'adapter' => 'BqUser\User\AccountManager\Mysql',
            'options' => array(
                'table_name' => 'bquser_user_bind_account',
            ),
        ),
        'account_table'  => 'bquser_account',
        'email_field'    => 'email',
        'user_table'     => 'bquser_user',
        'username_field' => 'username',
        'nickname_field' => 'nickname',
    ),

    'service_manager' => array(
        'aliases' => array(
            'BqUser\Db\Adapter' => 'Zend\Db\Adapter\Adapter',
        ),
        'factories' => array(
            'BqUser\User'    => 'BqUser\Service\User',
            'BqUser\Auth'    => 'BqUser\Service\Auth',
            'BqUser\Account' => 'BqUser\Service\Account',
            'BqUser\Config'  => 'BqUser\Service\Config',
        ),
    ),

    'entities' => array(
        'bquser\user' => array(
            'service' => 'BqUser\User'
        ),
    ),

    'controllers' => array(
        'invokables' => array(
            'BqUser\Controller\Index' => 'BqUser\Controller\IndexController'
        ),
    ),

    'router' => array(
        'routes' => array(
            'user' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/user',
                    'defaults' => array(
                        '__NAMESPACE__' => 'BqUser\Controller',
                        'controller' => 'Index',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'register' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/register.html',
                            'defaults' => array(
                                'action' => 'register'
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'BqUser' => __DIR__ . '/../view',
        ),
    ),

);
