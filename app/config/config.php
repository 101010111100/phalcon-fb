<?php
$config = new Phalcon_Config(array(
	'phalcon' => array(
        'controllersDir' => '../app/controllers/',
        'modelsDir' => '../app/models/',
        'viewsDir' => '../app/views/',
        'baseUri' => '/blahblah/',        
    ),
    'facebook' => array(
    	'appId' => '',
    	'secret' => '',
    	'fanPageId' => '',
    	'fanPageUri' => '',
    	'appScope' => '',
    	'appUrl' => '',
    ),
    'site' => array(
    	'domain' => 'puntopy.com',
    	'name' => '',
    	'facebook_connect' => false,
    )
    'db' => array(
    	'name' => 'facebook_apps',
    ),
));