<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Price Parser',

	// preloading 'log' component
	'preload'=>array('log'),


	'import'=>array(
		'application.models.*',
		'application.components.*',
	),
	// application components
	'components'=>array(

		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=yii_PriceParser',
			'emulatePrepare' => true,
			'username' => 'yii_PriceParser',
			'password' => 'yii_PriceParser',
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
	),
);