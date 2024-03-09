<?php
 /**
 * Author and Affiliation class
 * 
 * Handles the author-and-affiliation endpoint and returns results such as autor, name, content etc..
 * 
 * @author Ines Rita
 * @package App\EndpointController
 */
 namespace App\EndpointController;

 use App\Request as Request;
 use App\Database as Database;
 use App\Response as Response;
 use App\ClientError as ClientError;
 
class AuthorAndAffiliation extends Endpoint
{
    protected $allowedParams = ["author", "name", "content", "content.title", "country","city","instituition"];
    private $sql = "SELECT author.id AS author_id, author.name AS author_name,  affiliation.content AS content_id,  content.title AS content_title, affiliation.country, affiliation.city,  affiliation.institution FROM   author JOIN   affiliation ON author.id = affiliation.author JOIN   content ON affiliation.content = content.id";
    private $sqlParams = [];
 
 
    public function __construct()
    {
        switch(Request::method()) 
        {
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
 
    // allows to set parameter to return results by content id, and country specified
    private function buildSQL()
    {
        // Set a flag
        $where = false;
 
 
        if (isset(Request::params()['content'])) 
        {
            if (!is_numeric(REQUEST::params()['content'])) {
                throw new ClientError(422);
            }
            if (count(Request::params()) > 1) {
                throw new ClientError(422);
            } 
            $this->sql .= " WHERE content.id = :content";
            $this->sqlParams[":content"] = Request::params()['content'];
        }
 
 
        if (isset(REQUEST::params()['country']))
        {
            // Use the flag to determine if we need AND or WHERE
            $this->sql .= ($where) ? " AND" : " WHERE";
            $where = true;
            $this->sql .= " LOWER(affiliation.country) LIKE LOWER(:country)";
            $this->sqlParams[':country'] = REQUEST::params()['country'];
        }
 
    }
}