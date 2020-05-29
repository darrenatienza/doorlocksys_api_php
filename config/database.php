<?php
class Database{
 
    // specify your own database credentials
    private $host = "localhost";
    private $production = false;
    private $db_name;
    private $username;
    private $password;
    public $conn;
 
    // get the database connection
    public function getConnection(){
 
        $this->conn = null;
        $this->getCredentials();
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . "; port=3306; dbname=" . $this->db_name, $this->username, $this->password, [ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ] );
            //$this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
            //$this->conn = new mysqli($this->host, $this->username, $this->password);
            //$this->conn = pg_connect("host=localhost port=5432 dbname=studentidsys user=postgres password=postgres$");
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
 
        return $this->conn; 
    }

    /** Specify credentials to use */
    private function getCredentials(){
        if($this->production){
             /** 000 Web Host */
            $this->db_name = "id12769266_doorlocksys";
            $this->username = "id12769266_root";
            $this->password = "root$";
        }else{
            /** Local Xampp Server */
            $this->db_name = "doorlocksys";
            $this->username = "root";
            $this->password = "";
        }
    }
}
?>