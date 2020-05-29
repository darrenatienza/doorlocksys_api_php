<?php
class AccessLog extends Rest
{
    public $logic;
    public function __construct()
    {
        parent::__construct();
        
    }
   
    public function getAll()
    {
        try {
            $logic = new AccessLogLogic;
            $date = $this->validateParameter('date', $this->param['date'], STRING);
            $criteria = $this->validateParameter('criteria', $this->param['criteria'], STRING, false);
            $objs = $logic->getAll($date, $criteria);
            $this->returnResponse(SUCCESS_RESPONSE, $objs);
        } catch (Exception $e) {
            $this->throwError(ERROR_RESPONSE, $e->getMessage());
        }
        
    }
    public function getAllRecords()
    {
        try {
            $logic = new AccessLogLogic;
            $objs = $logic->getAllRecords();
            $this->returnResponse(SUCCESS_RESPONSE, $objs);
        } catch (Exception $e) {
            $this->throwError(ERROR_RESPONSE, $e->getMessage());
        }
        
    }
    public function add()
    {
        try {
            $logic = new AccessLogLogic;
            $userid = $this->validateParameter('userid', $this->param['userid'], INTEGER);
            $logs = $this->validateParameter('logs', $this->param['logs'], STRING, false);
            $objs = $logic->add($userid, $logs);
            $this->returnResponse(SUCCESS_RESPONSE, $objs);
        } catch (Exception $e) {
            $this->throwError(ERROR_RESPONSE, $e->getMessage());
        }
        
    }
}
?>
