<?php
//use Ahc\Jwt\JWT;
class Token extends Rest{

    private $logic;
    public function __construct()
    {
        
        parent::__construct();
        $this->logic = new UserLogic;
       
    }
    public function generateToken(){
        $exp_token_admin = 32140800; // 1 year
        $exp_token_normal = 86400; // 1 day
        $exp_token = 10; //seconds
        $username = $this->validateParameter('username',$this->param['username'],STRING);
        $pass= $this->validateParameter('password',$this->param['password'],STRING);
        try{
        
        $user = $this->logic->getBy($username,$pass);
        if(!is_array($user)){
            $this->throwError(INVALID_USER_PASS,"Email or Password is incorrect.");
        }
        /*if($user['is_active'] == 0){
            $this->throwError(USER_NOT_ACTIVE,"User is not activated. Please contact administrator.");
        }*/

        $payload = [
            'iat' => time(),
            'iss' => 'localhost',
            'exp' => time() + $exp_token,
            'userid' => $user['UserID']
        ];
        $jwt = new JWT(SECRETE_KEY);
        $token = $jwt->encode($payload);
        $data = ['token' => $token];
        $this->returnResponse(SUCCESS_RESPONSE,$data);
        }catch(Exception $e){
            $this->throwError(JWT_PROCESSING_ERROR,$e->getMessage());
        }
        
    }
}
?>