<?php

namespace App;

/**
 * This class will get information about the http request.
 * 
 * @author Ines Rita
 * @package App
 */
abstract class Request 
{
    public static function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }
 
    /**
     * Endpoint
     * 
     * Return the name of the requested endpoint. 
     */
    public static function endpointName()
    {
        $url = $_SERVER["REQUEST_URI"];
        $path = parse_url($url)['path'];
        return str_replace("/kf6012/assessment/api", "", $path);
    }
 
    public static function params()
    {
        return $_REQUEST;
    }

    public static function getBearerToken()
    {
        $allHeaders = getallheaders();
        $authorizationHeader = "";
                
        if (array_key_exists('Authorization', $allHeaders)) {
            $authorizationHeader = $allHeaders['Authorization'];
        } elseif (array_key_exists('authorization', $allHeaders)) {
            $authorizationHeader = $allHeaders['authorization'];
        }
                
        if (substr($authorizationHeader, 0, 7) != 'Bearer ') {
            throw new ClientError(401);
        }
        
        return trim(substr($authorizationHeader, 7));  
    }
    
}