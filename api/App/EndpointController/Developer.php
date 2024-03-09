<?php
 /**
 * Developer class
 * 
 * Returns my id and name
 * 
 * @author Ines Rita
 * @package App\EndpointController
 */
 namespace App\EndpointController;

 use App\Request as Request;
 use App\Database as Database;
 use App\Response as Response;
 use App\ClientError as ClientError;
 
class Developer extends Endpoint
{
    public function __construct()
    {
        switch(Request::method()) {
            case 'GET':
                $this->checkAllowedParams();
                $data['id'] = "w20022261";
                $data['name'] = "Ines Rita";
                break;
            default:
                throw new ClientError(405);
        }
        parent::__construct($data);
    }
}