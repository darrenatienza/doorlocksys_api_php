<?php

class DeviceActionData{

    protected $dbConn;
    public function __construct()
    {
        $db = new Database;
	    $this->dbConn = $db->getConnection();
    }
    public function getAll(){
        $query = "
        SELECT 
            deviceactionID, 
            actionname, 
            isactive
        FROM 
            deviceactions;";
        // prepare query statement
        $stmt = $this->dbConn->prepare($query);
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $users;
        
    }
    

    public function setDevicesInActive(){
        $query = "
        UPDATE 
            deviceactions
        SET 
            IsActive = 0;";
        // prepare query statement
        $stmt = $this->dbConn->prepare($query);
        $stmt->execute();
 
    }
    public function updateActiveStatus($id)
    {
        $query = "
        UPDATE 
            deviceactions
        SET 
            IsActive = 1
        WHERE
            DeviceActionID = :id;";
        // prepare query statement
        $stmt = $this->dbConn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
    public function getActiveDeviceAction()
    {
        $query = "
        SELECT 
            deviceactionID, 
            actionname, 
            isactive
        FROM 
            deviceactions
        WHERE
            isactive > 0;";
        // prepare query statement
        $stmt = $this->dbConn->prepare($query);
        $stmt->execute();
        return $obj = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function editActiveStatus($actionname)
    {
        $query = "
        UPDATE 
            deviceactions
        SET 
            IsActive = 1
        WHERE
            actionname = :actionname;";
        // prepare query statement
        $stmt = $this->dbConn->prepare($query);
        $stmt->bindParam(':actionname', $actionname);
        $stmt->execute();
    }
    public function close()
    {
        $this->dbConn = null;
    }
}
?>