<?php
 /**
 * Exception Handler Class
 *
 * This class will handle all excpetions
 *
 * @author Ines Rita
 */
function exceptionHandler($e) {
   http_response_code(500);
   $output['message'] = "Internal Server Error";
   $output['details']['exception'] = $e->getMessage();
   $output['details']['file'] = $e->getFile();
   $output['details']['line'] = $e->getLine();
   echo json_encode($output);
   exit();
}