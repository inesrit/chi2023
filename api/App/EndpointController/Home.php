<?php
 /**
 * Home class
 * 
 * Class that returns a random content title and youtube video link
 * 
 * @author Ines Rita
 * @package App\EndpointController
 */
 namespace App\EndpointController;

 use App\Request as Request;
 use App\Database as Database;
 use App\Response as Response;
 use App\ClientError as ClientError;
 
class Home extends Endpoint
{
    public function __construct()
    {
        switch(Request::method()) {
            case 'GET':
                $this->checkAllowedParams();
                $data['heading'] = "CHI 2023";
                $data['title'] = "Producer Conflict Management Approaches in Online Peer Production Communities – Case Study of OpenStreetMap";
                $data['link'] = "https://www.youtube.com/watch?v=BPSptKAEUEs";
                break;
            default:
                throw new ClientError(405);
        }
        parent::__construct($data);
    }
}