<?php
 
 namespace App;
 
 /**
 * Database class
 * 
 * Uses PDO to connect to a SQLite database and execute SQL statements
 *
 * @author Ines Rita
 * @package App
 */

class Database 
{
    private $dbConnection;
  
    public function __construct($dbName) 
    {
        $this->setDbConnection($dbName);  
    }
 
    private function setDbConnection($dbName) 
    {
        $this->dbConnection = new \PDO('sqlite:'.$dbName);
        $this->dbConnection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }
    
    public function executeSQL($sql, $params=[])
    { 
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}