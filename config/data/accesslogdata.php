<?php

class AccessLogData
{
    protected $dbConn;
    public function __construct()
    {
       
    }
    public function getAll($date, $criteria)
    {
        $db = new Database;
        $this->dbConn = $db->getConnection();
        $criteria = '%'.$criteria.'%';
        $query = "
        SELECT 
            DooraccessLogId, 
            dooraccesslogs.createtimestamp,
            users.fullname as userfullname, 
            log
        FROM 
            dooraccesslogs 
        inner join 
            users
        on 
        dooraccesslogs.userid = users.userid
        WHERE
            DATE(dooraccesslogs.createtimestamp) = DATE(:date)
        AND
            users.fullname LIKE :criteria";
            $criteria = '%'. $criteria . '%';
            // prepare query statement
            $stmt = $this->dbConn->prepare($query);
            $stmt->bindParam(':date', $date);
            $stmt->bindParam(':criteria', $criteria);
            $stmt->execute();
            $objs = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $objs;
    }
    public function getAllRecords()
    {
        $db = new Database;
        $this->dbConn = $db->getConnection();
        $query = "
        SELECT 
            *
        FROM 
            dooraccesslogs
       ";
            // prepare query statement
            $stmt = $this->dbConn->prepare($query);
            $stmt->execute();
            $objs = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $objs;
    }
    public function add($userid, $logs)
    {
        $db = new Database;
        $this->dbConn = $db->getConnection();
        $query = "
        INSERT INTO 
            dooraccesslogs
            (
                userid, 
                log
               
            )VALUES(
                :userid,
                :log
            );";
            // prepare query statement
            $stmt = $this->dbConn->prepare($query);
            $stmt->bindParam(':userid', $userid);
            $stmt->bindParam(':log', $logs);
            $stmt->execute();  
    }
    public function close()
    {
        $this->dbConn = null;
    }
}
