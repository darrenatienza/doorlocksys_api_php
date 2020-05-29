<?php
//use Ahc\Jwt\JWT;
require_once('./config/constants.php');
class Rest{
    protected $request;
    protected $serviceName;
    protected $src;
    protected $param;
    private $logic;
    protected $user_id;
    public function __construct()
    {
        
        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
           $this->throwError(REQUEST_METHOD_NOT_VALID,'Request Method is not valid.');
        }
        $handle = fopen('php://input','r');
        $this->request = stream_get_contents($handle);
        $this->validateRequest($this->request);
        $this->logic = new UserLogic;
        $accessType = $this->getAccessType();
		if( 'generatetoken' != strtolower( $this->serviceName) && 'device' != $accessType) {
			$this->validateToken();
        }
        
    }
    public function validateRequest($request)
    {
        if($_SERVER['CONTENT_TYPE'] !== 'application/json')
        {
            $this->throwError(REQUEST_CONTENTTYPE_NOT_VALID,'Request content type not valid.');
        }
        $data = json_decode($this->request,true);
        
        if(!isset($data['src']) || $data['src'] == ""){
            $this->throwError(API_NAME_REQUIRED,"API class is required.");
        }
        $this->src =$data['src'];

        if(!isset($data['name']) || $data['name'] == ""){
            $this->throwError(API_NAME_REQUIRED,"API name is required.");
        }
        $this->serviceName =$data['name'];

        if(!is_array($data['param'])){
            $this->throwError(API_PARAM_REQUIRED,"API parameter is required.");
        }
        $this->param = $data['param'];
    }
    public function processApi() {
        try {
            $api = new $this->src;
            $rMethod = new reflectionMethod($this->src, $this->serviceName);
            if(!method_exists($api, $this->serviceName)) {
                $this->throwError(API_DOST_NOT_EXIST, "API does not exist.");
            }
            $rMethod->invoke($api);

        } catch (Exception $e) {
            $this->throwError(API_DOST_NOT_EXIST, "API does not exist.");
        }
        
    }
     public function validateParameter($fieldName, $value, $dataType, $required = true){
         if($required == true && empty($value)== true){
             $this->throwError(VALIDATE_PARAMETER_REQUIRED, $fieldName . " parameter is required");
         }
         switch ($dataType) {
            case BOOLEAN:
                if (!is_bool($value)) {
                    $this->throwError(VALIDATE_PARAMETER_REQUIRED,"DataType is not valid for " . $fieldName . '.It should be boolean');
                }
                 break;
            case INTEGER:
                if (!is_numeric($value)) {
                    $this->throwError(VALIDATE_PARAMETER_REQUIRED,"DataType is not valid for " 
                    . $fieldName . '.It should be integer');
                }
                 break;
            case STRING:
                if (!is_string($value)) {
                    $this->throwError(VALIDATE_PARAMETER_REQUIRED,"DataType is not valid for " 
                    . $fieldName . '.It should be string');
                }
                 break;
             default:
                $this->throwError(VALIDATE_PARAMETER_REQUIRED,"DataType is not valid for " 
                    . $fieldName);
                 break;
         }
         return $value;
     }
     public function validateToken() {
        try {
            $token = $this->getBearerToken();
            $payload = (new JWT(SECRETE_KEY, 'HS256', 1800))->decode($token);
            $userid = $payload['userid'];
            $user =  $this->logic->getByUserID($userid);
            
            if(!is_array($user)) {
                header('http/1.1 401 UnAuthorized');
                $this->throwError(INVALID_USER_PASS, "This user is not found in our database.");
            }
            /*if( $user['is_active'] == 0 ) {
                $this->returnResponse(USER_NOT_ACTIVE, "This user may be decactived. Please contact to admin.");
            }*/
            $this->user_id = $userid;
            
        } catch (Exception $e) {
            header('http/1.1 401 UnAuthorized');
            $this->throwError(ACCESS_TOKEN_ERRORS, $e->getMessage());
        }
    }
    public function throwError($code, $message) 
    {        
        //header("content-type: application/json");
       $errorMsg = json_encode(['error'=>['status'=>$code,'message'=>$message]]);
        echo $errorMsg;
        exit; //exit the operation
    }
    public function returnResponse($code,$data){
        //header('http/1.1'.$code);
        $response = json_encode(['response' => ['status'=> $code, "result" => $data]]);
        echo $response; exit;
    }
    /**
	    * Get hearder Authorization
	    * */
	    public function getAuthorizationHeader(){
	        $headers = null;
	        if (isset($_SERVER['Authorization'])) {
	            $headers = trim($_SERVER["Authorization"]);
	        }
	        else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
	            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
	        } elseif (function_exists('apache_request_headers')) {
	            $requestHeaders = apache_request_headers();
	            // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
	            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
	            if (isset($requestHeaders['Authorization'])) {
	                $headers = trim($requestHeaders['Authorization']);
	            }
	        }
	        return $headers;
	    }
	    /**
	     * get access token from header
	     * */
	    public function getBearerToken() {
	        $headers = $this->getAuthorizationHeader();
	        // HEADER: Get the access token from the header
	        if (!empty($headers)) {
	            if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
	                return $matches[1];
	            }
	        }
	        $this->throwError( ATHORIZATION_HEADER_NOT_FOUND, 'Access Token Not found');
        }
    /** Get Access Type */
    public function getAccessType(){
        $headers = null;
        if (isset($_SERVER['HTTP_ACCESSTYPE'])) {
            $headers = trim($_SERVER["HTTP_ACCESSTYPE"]);
        }
        else if (isset($_SERVER['HTTP_ACCESS_TYPE'])) { //Nginx or fast CGI
            $headers = trim($_SERVER["HTTP_ACCESS_TYPE"]);
        }
        return $headers;
    }
}
?>