<?php
/**
 * Content class
 * 
 * Handles content endpoint and returns content and other details
 * 
 * @author Ines Rita
 * @package App\EndpointController
 */
 namespace App\EndpointController;

 use App\Request as Request;
 use App\Database as Database;
 use App\Response as Response;
 use App\ClientError as ClientError;
 
class Content extends Endpoint
{
    protected $allowedParams = ["id","page","title", "abstract", "type"];
    private $sql = "SELECT  content.id,  title,   abstract,   type.name AS content_type,   author.name AS author_name,   affiliation.country AS author_affiliation_country,  affiliation.city AS author_affiliation_city, affiliation.institution AS author_affiliation_institution,CASE WHEN content_has_award.content IS NOT NULL THEN 'Yes' ELSE 'No' END AS has_award FROM    content JOIN   type ON content.type = type.id JOIN   affiliation ON content.id = affiliation.content JOIN   author ON affiliation.author = author.id LEFT JOIN   content_has_award ON content.id = content_has_award.content";
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
 
    // will return results based on the type of content parameter and/or the page number parameter
    private function buildSQL() 
    {
        // Set a flag
        $where = false;
 
        
        if (isset(REQUEST::params()['type']))
        {
            // Use the flag to determine if we need AND or WHERE
            $this->sql .= ($where) ? " AND" : " WHERE";
            $where = true;
            $this->sql .= " LOWER(type.name) LIKE LOWER(:type)";
            $this->sqlParams[':type'] = REQUEST::params()['type'];
        } 
        
        if (isset(REQUEST::params()['page']))
        {
            $this->sql .= " LIMIT 20 OFFSET (:page-1) * 20";
            $this->sqlParams[":page"] = Request::params()['page'];
        }
 
    }
}