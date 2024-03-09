<?php
/**
 * Country class
 * 
 * Handles country endpoint, returns all countries and can be sued with parameters
 * 
 * @author Ines Rita
 * @package App\EndpointController
 */
namespace App\EndpointController;

 use App\Request as Request;
 use App\Database as Database;
 use App\Response as Response;
 use App\ClientError as ClientError;

class Country extends Endpoint
{
    protected $allowedParams = ["country", "city"];
    private $sql = "SELECT DISTINCT country, city FROM affiliation";
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
 
    // when using the country parameter it will return the specified param
    private function buildSQL()
    {
        $where = false;
        if (isset(REQUEST::params()['country']))
        {
            $this->sql .= ($where) ? " AND" : " WHERE";
            $where = true;
            $this->sql .= " country LIKE :country";
            $this->sqlParams[':country'] = REQUEST::params()['country'] . "%";
        }
 
    }
 
}