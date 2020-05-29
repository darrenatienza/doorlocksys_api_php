<?php

class UserData{

    protected $dbConn;
    public function __construct()
    {
        $db = new Database;
	    $this->dbConn = $db->getConnection();
    }
    public function getAll($criteria){
        $query = "
        SELECT 
            userid, 
            username, 
            fullname, 
            fingerprints, 
            createtimestamp  
        FROM 
            users
        WHERE
            UserName LIKE :criteria OR
            FullName LIKE :criteria
        ORDER BY
            userid DESC";
        $criteria = '%'. $criteria . '%';
        // prepare query statement
        $stmt = $this->dbConn->prepare($query);
        $stmt->bindParam(':criteria', $criteria);
        $stmt->execute();
        $objs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $objs;
        
    }
    public function getBy($username,$password){
        
        $query = "
        SELECT 
            UserID, 
            UserName,
            Password, 
            FullName, 
            Fingerprints, 
            CreateTimeStamp      
        FROM 
            users
        WHERE 
            UserName = :username
        AND 
            Password = :password;";
        // prepare query statement
        $stmt = $this->dbConn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user;
        
    }
    public function getByUserID($userid){
        
        $query = "SELECT username,fullname,userid FROM users WHERE userid = :userid";
        // prepare query statement
        $stmt = $this->dbConn->prepare($query);
        $stmt->bindParam(':userid', $userid);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user;
    }
    public function add(UserModel $user){
        $query = "
        INSERT INTO 
            users
            (
                UserName, 
                Password, 
                FullName,
                FingerPrints
            )VALUES(
                :username,
                :password, 
                :fullname,
                0
            );";
        // prepare query statement
        $stmt = $this->dbConn->prepare($query);
        $stmt->bindParam(':username', $user->username);
        $stmt->bindParam(':password', $user->password);
        $stmt->bindParam(':fullname', $user->fullname);
        $stmt->execute();
    }
    public function edit($id,UserModel $user){
        $query = "
        UPDATE 
            users
        SET 
            Password= :password, 
            FullName= :fullname
        WHERE 
            UserID= :id;";
        // prepare query statement
        $stmt = $this->dbConn->prepare($query);
        $stmt->bindParam(':password', $user->password);
        $stmt->bindParam(':fullname', $user->fullname);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
    public function delete($id){
        $query = "
        DELETE FROM 
            users
        WHERE 
            UserID=:id;
        ";
        // prepare query statement
        $stmt = $this->dbConn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
    public function resetFinger($id){
        $query = "
        UPDATE 
        users
    SET 
        Fingerprints = 0
    WHERE 
        UserID= :id;";
        // prepare query statement
        $stmt = $this->dbConn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
    public function editFingerPrint($fingerprint){
        $query = "
        UPDATE users SET Fingerprints = :fingerprint WHERE Fingerprints = 0;";
        // prepare query statement
        $stmt = $this->dbConn->prepare($query);
        $stmt->bindParam(':fingerprint', $fingerprint);
        $stmt->execute();
    }
    public function getByFingerprintid($fingerprint){
        $query = "SELECT userID, userName, Password, fullName, fingerprints, createTimeStamp FROM users WHERE fingerprints = :fingerprint";
        // prepare query statement
        $stmt = $this->dbConn->prepare($query);
        $stmt->bindParam(':fingerprint', $fingerprint);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user;
    }
    public function close()
    {
        $this->dbConn = null;
    }
}
?>