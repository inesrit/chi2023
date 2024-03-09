<?php
/**
 * Token class
 * 
 * This class will issue Token to Authenticated Users by checking username and password against ones in database
 * and returns a JWT token
 * 
 * @author Ines Rita
 * @package App\EndpointController
 */
namespace App\EndpointController;

 use App\Request as Request;
 use App\Database as Database;
 use App\Response as Response;
 use App\ClientError as ClientError;

class Token extends Endpoint
{

    private $sql = "SELECT id, password FROM account WHERE email = :email";
    private $sqlParams = [];
   
     /**
     * Constructor
     *
     */ 
    public function __construct() {

    //check the request method is GET or POST, checks email and password against database and calls method to generate token
    switch(Request::method()) 
    {
        case 'GET':
            case 'POST':
                $this->checkAllowedParams();
                $dbConn = new Database("db/users.sqlite");
         
                if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])) {
                    throw new ClientError(401);
                }
         
                if (empty(trim($_SERVER['PHP_AUTH_USER'])) || empty(trim($_SERVER['PHP_AUTH_PW']))) {
                    throw new ClientError(401);
                }
         
                $this->sqlParams[":email"] = $_SERVER['PHP_AUTH_USER'];
                $data = $dbConn->executeSQL($this->sql, $this->sqlParams);
         
                if (count($data) != 1) {
                    throw new ClientError(401);
                }
         
                if (!password_verify($_SERVER['PHP_AUTH_PW'], $data[0]['password'])) {
                    throw new ClientError(401);
                }
         
                $token = $this->generateJWT($data[0]['id']);        
                $data = ['token' => $token];
         
                parent::__construct($data);
                break;
            default:
                throw new ClientError(405);
                break;
    }

    }

    //method that will generate the token
    private function generateJWT($id) { 
 
        // 1. Uses the secret key defined, sets token payload to include, time, expiration limit and issuer
        $secretKey = '5BQ4w$V-~{)OE5&';
        $iat = time();
        $exp = strtotime('+30 minutes', $iat);
        $iss = $_SERVER['HTTP_HOST'];
       
        // 2. Specifies what to add to the token payload. 
        $payload = [
          'id' => $id,
          'iat'=> $iat,
          'exp'=> $exp,
          'iss'=> $iss,
        ];
            
        // 3. Uses the JWT class to encode the token  
        $jwt = \Firebase\JWT\JWT::encode($payload, $secretKey, 'HS256');
        
        return $jwt;
      }
 
}