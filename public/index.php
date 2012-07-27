<?php

try {

    require __DIR__ . '/../app/config/config.php';
    require __DIR__ . '/../app/config/routes.php';

 $front = Phalcon_Controller_Front::getInstance();
 
  $front->setConfig($config);
  $front->setRouter($router);

 //Printing view output
 echo $front->dispatchLoop()->getContent();

} catch(Phalcon_Exception $e) {
 echo "PhalconException: ", $e->getMessage();
}
