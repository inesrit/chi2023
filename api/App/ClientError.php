<?php 
 
 /**
 * Client Error class
 * 
 * Class to streamline all responses thrown by errors in the scripts with http resonse code
 *
 * @author Ines Rita
 * @package App
 */
 namespace App;
 
class ClientError extends \Exception
{
    public function __construct($code)
    {
        parent::__construct($this->errorResponses($code));
    }
 
    public function errorResponses($code)
    {
        switch ($code) {
            case 400:
                $message = 'Bad Request';
                http_response_code(400);
                break;
            case 401:
                $message = 'Unauthorized';
                http_response_code(401);
                break;
            case 403:
                $message = 'Forbidden';
                http_response_code(403);
                break;
            case 404:
                $message = 'Endpoint Not Found';
                http_response_code(404);
                break;
            case 405:
                $message = 'Method Not Allowed';
                http_response_code(405);
                break;
            case 422:
                $message = 'Unprocessable Entity';
                http_response_code(422);
                break;
            default:
                throw new \Exception('Internal Server Error');
        }
        return $message;
    }
}