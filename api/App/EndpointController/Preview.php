<?php
/**
 * Preview class
 * 
 * Class that returns a preview page, with a random content title and youtube video link
 * 
 * @author Ines Rita
 * @package App\EndpointController
 */
namespace App\EndpointController;

 use App\Request as Request;
 use App\Database as Database;
 use App\Response as Response;
 use App\ClientError as ClientError;

class Preview extends Endpoint
{
    protected $allowedParams = ["title", "preview_video","limit"];
    private $sql = "SELECT title, preview_video FROM content WHERE preview_video IS NOT NULL ORDER BY RANDOM()";
    private $sqlParams = [];
 
    public function __construct()
    {
        switch(Request::method()) {
            case 'GET':
                $this->checkAllowedParams();
                $this->buildSQL();
                $dbConn = new Database("db/chi2023.sqlite");
                $data = $dbConn->executeSQL($this->sql, $this->sqlParams); 
                break;
            default:
                throw new ClientError(405);
        }
 
        parent::__construct($data);
    }
 
    //method to limit amount of results returned by specifying a number
    private function buildSQL()
    {
        if (isset(REQUEST::params()['limit']))
        {
            $this->sql .= " LIMIT :limit";
            $this->sqlParams[":limit"] = Request::params()['limit'];
        }
    }
 
}