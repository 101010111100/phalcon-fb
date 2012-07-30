<?php

try {

    require __DIR__ . '/../app/config/config.php';
    require __DIR__ . '/../app/config/routes.php';
    require __DIR__ . '/../vendor/facebook/class.fb.php';
    require __DIR__ . '/../vendor/mongo_record/lib/BaseMongoRecord.php';

    // require all files in mongo_models
    foreach (glob(__DIR__ . "/../app/mongo_models/*.php") as $filename)
    	include $filename;

    // Facebook object
    if ($config->site->facebook_connect){
	    $fb = new FB(array(
	    	'cookie' => 1
		));
	}

	$front = Phalcon_Controller_Front::getInstance();
 
	$front->setConfig($config);
	$front->setRouter($router);

	//Mongo Database config
	BaseMongoRecord::$connection = new Mongo();
	BaseMongoRecord::$database = $config->db->name;

	//Printing view output
	echo $front->dispatchLoop()->getContent();

} catch(Phalcon_Exception $e) {
	echo "PhalconException: ", $e->getMessage();
}
