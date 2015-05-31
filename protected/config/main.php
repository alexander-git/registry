<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Электронная регистратура',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
            'application.models.*',
            'application.components.*',
            'application.exceptions.*',
            'ext.widgets.*',
            'ext.utils.*',
	),
   
        'aliases' => array(
            'constant' => realpath(dirname(__FILE__).'/../constant'), 
            'helpers' => realpath(dirname(__FILE__).'/../helpers'),
            'utils' => realpath(dirname(__FILE__).'/../utils'),
            'managers' => realpath(dirname(__FILE__).'/../managers'),      
        ),
   
        'defaultController'=>'visitor/record',
    
        'homeUrl' => array('/'),
        
	'modules' => array(
		// uncomment the following to enable the Gii tool
                /*
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'pass',
			'ipFilters'=>array('127.0.0.1','::1'),
		), 
                */
	),
  
	'components' => array(
            'user' => array(
                // enable cookie-based authentication
                'allowAutoLogin' => false,
                // Если для выполнения действия надо аунтефицироваться, 
                // то пользователь будет перенаправлен на эту страницу.
                'loginUrl' => array('login/login'),
            ),
            
            'urlManager'=>array(
                'urlFormat'=>'path',
                'rules' => array (
                    '/' => 'visitor/record/index', 
                ),
            ),
            
            'db' => array(
                'connectionString' => 'mysql:host=localhost;dbname=reception',
                'emulatePrepare' => true,
                'username' => 'root',
                'password' => 'pass',
                'charset' => 'utf8',
                'tablePrefix'=>'rcptn_',
                'nullConversion' => PDO::NULL_NATURAL,
            ),
    
            'errorHandler' => array(
            ),
            
            'log'=>array(
                'class' => 'CLogRouter',
                'routes' => array(
                    array(
                        'class'=>'CFileLogRoute',
                        'levels'=>'error, warning',
                    ),
                ),
            ),
            'authManager' => array(
                'class' => 'CPhpAuthManager',
                'defaultRoles' => array('guest'), 
            ),
            'statePersister' => array(
                'class' => 'CStatePersister'
            ),
            'widgetFactory' => array(
                'enableSkin' => true
            ),
            'session' => array(
                'autoStart' => true,
                'cookieMode' => 'only',
                'useTransparentSessionID' => false,
                'sessionName' => 'session',
                'timeout' => 28800
            ),
	),

	'params'=>array(
            
	),
);