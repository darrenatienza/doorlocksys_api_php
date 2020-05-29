<?php

use Ahc\Jwt\JWT;

class API extends Rest{

    public function __construct()
    {
        parent::__construct(); 
       
    }
    /*--------------Generate Token--------------------*/
    public function generateToken(){
        $username = $this->validateParameter('username',$this->param['username'],STRING);
        $pass= $this->validateParameter('password',$this->param['password'],STRING);
        try{
        $query = "SELECT * FROM users where user_name =  :username  AND password = :pass";
        // prepare query statement
        $stmt = $this->dbConn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':pass', $pass);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!is_array($user)){

            $this->throwError(INVALID_USER_PASS,"Email or Password is incorrect.");
        }
        /*if($user['is_active'] == 0){
            $this->throwError(USER_NOT_ACTIVE,"User is not activated. Please contact administrator.");
        }*/
        $payload = [
            'iat' => time(),
            'iss' => 'localhost',
            'exp' => time() +(60*60*5),
            'user_id' => $user['user_id']
        ];
        $token = JWT::encode($payload, SECRETE_KEY);
        
        $data = ['token' => $token];
        $this->returnResponse(SUCCESS_RESPONSE,$data);
        }catch(Exception $e){
            $this->throwError(JWT_PROCESSING_ERROR,$e->getMessage());
        }
        
    }
}
?>