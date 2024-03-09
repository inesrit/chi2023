<?php
/**
 * Front door script
 *
 * This class is the S=single'front door' script to handle requests
 *
 * @author Ines Rita
 */
 
 ini_set('display_errors', 1);
 ini_set('display_startup_errors', 1);
 error_reporting(E_ALL);
  
 include 'config/ExceptionHandler.php';
 set_exception_handler('exceptionHandler');
  
 include("config/autoloader.php");
 spl_autoload_register("autoloader");
  
 $response = new App\Response();
 $endpoint = App\Router::routeRequest();
 $data = $endpoint->getData();
 $response->outputJSON($data);