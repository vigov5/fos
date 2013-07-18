<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Console Application',

	// preloading 'log' component
	'preload'=>array('log'),
    'import' => array(
        'application.models.*',
        'application.components.*',
        'application.extensions.yii-mail.*',
    ),
	// application components
	'components'=>array(
        /*
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
         */
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=fos_dev',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => 'root',
			'charset' => 'utf8',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
			),
		),
        'mail' => array(
            'class' => 'application.extensions.yii-mail.YiiMail',
            'transportType'=>'smtp',
            'transportOptions'=>array(
                'host'=>'smtp.gmail.com',
                'username'=>'framgia.email.tester@gmail.com',
                'password'=>'framgia345',
                'port'=>'465',
                'encryption'=>'ssl',
                ),
            'viewPath' => 'application.views.mail',
            'logging' => true,
            'dryRun' => false,
        ),
	),
    'params' => array(
        // this is used in contact page
        'adminEmail' => 'webmaster@example.com',
        'base_url' => 'http://localhost/fos',
    ),
);