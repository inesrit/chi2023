<?php
 
namespace App\EndpointController;
 
/**
 * Note class
 * 
 * Page that returns note endpoint results
 * 
 * @author Ines Rita
 * @package App\EndpointController
 */

class Note extends Endpoint 
{
    public function __construct()
    {
        $id = $this->validateToken();
        
        $this->checkUserExists($id);
 
        switch(\App\Request::method()) 
        {
            case 'GET':
                $data = $this->getNote($id);
                break;
            case 'POST':
                $data = $this->postNote($id);
                break;
            case 'DELETE':
                $data = $this->deleteNote($id);
                break;
            default:
                throw new \App\ClientError(405);
                break;
        }
        parent::__construct($data);
    }
 
    /**
     * method to validate the token generated from token endpoint
     */
    private function validateToken()
    {
        $secretkey = '5BQ4w$V-~{)OE5&';
                
        $jwt = \App\REQUEST::getBearerToken();
 
        try {
            $decodedJWT = \Firebase\JWT\JWT::decode($jwt, new \Firebase\JWT\Key($secretkey, 'HS256'));
        } catch (\Exception $e) {
            throw new \App\ClientError(401);
        }
 
        if (!isset($decodedJWT->exp) || !isset($decodedJWT->id)) { 
            throw new \App\ClientError(401);
        }
 
        return $decodedJWT->id;
    }
 
    /**
     * Checks the note exists and do some basic validation
     */
    private function note() 
    {
        if (!isset(\App\REQUEST::params()['note']))
        {
            throw new \App\ClientError(422);
        }
 
        if (mb_strlen(\App\REQUEST::params()['note']) > 255)
        {
            throw new \App\ClientError(422);
        }
 
       $note = \App\REQUEST::params()['note'];
       return htmlspecialchars($note);
    }
 
    /**
     * Get all notes for a user unless a content_id is specified, in which case
     * it returns the note for that specific content.
     */
    private function getNote($id)
    {
        // If a content_id is specified, return the note for that content
        // otherwise return all notes for the user.
        if (isset(\App\REQUEST::params()['content_id']))
        {
            $content_id = \App\REQUEST::params()['content_id'];
 
            if (!is_numeric($content_id))
            {
                throw new \App\ClientError(422);
            }
 
            $sql = "SELECT * FROM notes WHERE user_id = :id AND content_id = :content_id";
            $sqlParams = [':id' => $id, 'content_id' => $content_id];
        } else {
            $sql = "SELECT * FROM notes WHERE user_id = :id";
            $sqlParams = [':id' => $id];
        }
 
        $dbConn = new \App\Database("db/users.sqlite");
        
        $data = $dbConn->executeSQL($sql, $sqlParams);
        return $data;
    }
 
    /**
     * This handles both posting a new note and updating an existing note
     * for a content. There can only be one note per content per user.
     */
    private function postNote($id)
    {
        if (!isset(\App\REQUEST::params()['content_id']))
        {
            throw new \App\ClientError(422);
        }
 
        $content_id = \App\REQUEST::params()['content_id'];
        
        if (!is_numeric($content_id))
        {
            throw new \App\ClientError(422);
        }
 
        $note = $this->note(); 
 
        $dbConn = new \App\Database("db/users.sqlite");
 
        $sqlParams = [':id' => $id, 'content_id' => $content_id];
        $sql = "SELECT * FROM notes WHERE user_id = :id AND content_id = :content_id";
        $data = $dbConn->executeSQL($sql, $sqlParams);
 
        // If there is no note for this content, create one. 
        // Otherwise update the existing note.
        if (count($data) === 0) {
            $sql = "INSERT INTO notes (user_id, content_id, note) VALUES (:id, :content_id, :note)";
        } else {
            $sql = "UPDATE notes SET note = :note WHERE user_id = :id AND content_id = :content_id";
        }
 
        $sqlParams = [':id' => $id, 'content_id' => $content_id, 'note' => $note];
        $data = $dbConn->executeSQL($sql, $sqlParams);
     
        return [];
    }
 
 
    /**
     * Delete a note for a content
     */
    private function deleteNote($id)
    {
        if (!isset(\App\REQUEST::params()['content_id']))
        {
            throw new \App\ClientError(422);
        }
 
        $content_id = \App\REQUEST::params()['content_id'];
        
        if (!is_numeric($content_id))
        {
            throw new \App\ClientError(422);
        }
 
        $dbConn = new \App\Database("db/users.sqlite");
        $sql = "DELETE FROM notes WHERE user_id = :id AND content_id = :content_id";
        $sqlParams = [':id' => $id, 'content_id' => $content_id];
        $data = $dbConn->executeSQL($sql, $sqlParams);
        return $data;
    }
 
    private function checkUserExists($id)
    {
        $dbConn = new \App\Database("db/users.sqlite");
        $sql = "SELECT id FROM account WHERE id = :id";
        $sqlParams = [':id' => $id];
        $data = $dbConn->executeSQL($sql, $sqlParams);
        if (count($data) != 1) {
            throw new \App\ClientError(401);
        }
    }
}