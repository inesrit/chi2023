<?php
 /**
 * Endpoint class
 * 
 * Class that shows handles endpoint and parameters
 * 
 * @author Ines Rita
 * @package App\EndpointController
 */
 namespace App\EndpointController;

 use App\Request as Request;
 use App\Database as Database;
 use App\Response as Response;
 use App\ClientError as ClientError;
 
class Endpoint 
{
    private $data;
    /** 
     * $allowedParams 
     * 
     */
    protected $allowedParams = [];
 
    public function __construct($data = ["message" => []])
    {
        $this->setData($data);
    }
 
    public function setData($data)
    {
        $this->data = $data;
    }
 
    public function getData()
    {
        return $this->data;
    }
 
 
    /**
     * checkAllowedParams
     * 
     * This method will check if the parameters input are allowed
     */
    protected function checkAllowedParams()
    {
        foreach (REQUEST::params() as $key => $value) 
        {
            if (!in_array($key, $this->allowedParams))
            {
                throw new ClientError(422);
            }
        }
    }
}