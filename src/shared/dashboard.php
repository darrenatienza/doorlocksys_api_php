<?php

class Dashboard extends Rest
{
    public $userLogic;
    public function __construct()
    {
        parent::__construct();
        $this->userLogic = new UserLogic;
        $this->accessLogLogic = new AccessLogLogic;

    }
    public function get()
    {
        try {
            // update dashboard model
            $model = new DashboardModel;
            $model->accessLogCount = count($this->accessLogLogic->getAllRecords());
            $this->returnResponse(SUCCESS_RESPONSE, $model);
        } catch (Exception $e) {
            $this->throwError(ERROR_RESPONSE, $e->getMessage());
        }
    }
    
    
    public function add()
    {
        try {
            $user = new UserModel;
            $user->username = $this->validateParameter('username', $this->param['username'], STRING);
            $user->password = $this->validateParameter('password', $this->param['password'], STRING);
            $user->fullname = $this->validateParameter('fullname', $this->param['fullname'], STRING);
            $this->userLogic->add($user);
            $this->returnResponse(SUCCESS_RESPONSE, "");
        } catch (Exception $e) {
            $this->throwError(ERROR_RESPONSE, $e->getMessage());
        }
    }
    public function getCurrentUser()
    {
        try {
            $id = $this->user_id;
            $user = $this->userLogic->getByUserID($id);
            $this->returnResponse(SUCCESS_RESPONSE, $user);
        } catch (Exception $e) {
            $this->throwError(ERROR_RESPONSE, $e->getMessage());
        }
    }
    public function getByUserID()
    {
        try {
            $user = new UserModel;
            $id = $this->validateParameter('id', $this->param['id'], INTEGER);
            $user = $this->userLogic->getByUserID($id);
            $this->returnResponse(SUCCESS_RESPONSE, $user);
        } catch (Exception $e) {
            $this->throwError(ERROR_RESPONSE, $e->getMessage());
        }
    }
    public function edit()
    {
        try {
            $user = new UserModel;
            $id = $this->validateParameter('id', $this->param['id'], INTEGER);
            $user->password = $this->validateParameter('password', $this->param['password'], STRING);
            $user->fullname = $this->validateParameter('fullname', $this->param['fullname'], STRING);
            $users = $this->userLogic->edit($id, $user);
            $this->returnResponse(SUCCESS_RESPONSE, "");
        } catch (Exception $e) {
            $this->throwError(ERROR_RESPONSE, $e->getMessage());
        }
    }
    public function delete()
    {
        try {
            $id = $this->validateParameter('id', $this->param['id'], INTEGER);
            $users = $this->userLogic->delete($id);
            $this->returnResponse(SUCCESS_RESPONSE, "");
        } catch (Exception $e) {
            $this->throwError(ERROR_RESPONSE, $e->getMessage());
        }
    }
    public function resetFinger()
    {
        try {
            $id = $this->validateParameter('id', $this->param['id'], INTEGER);
            $users = $this->userLogic->resetFinger($id);
            $this->returnResponse(SUCCESS_RESPONSE, "");
        } catch (Exception $e) {
            $this->throwError(ERROR_RESPONSE, $e->getMessage());
        }
    }
    public function editFingerPrint()
    {
        try {
            $fingerprint = $this->validateParameter('fingerprint', $this->param['fingerprint'], INTEGER);
            $this->userLogic->editFingerPrint($fingerprint);
            $this->returnResponse(SUCCESS_RESPONSE, "");
        } catch (Exception $e) {
            $this->throwError(ERROR_RESPONSE, $e->getMessage());
        }
    }
    public function getByFingerprintid()
    {
        try {
            $user = new UserModel;
            $fingerprint = $this->validateParameter('fingerprint', $this->param['fingerprint'], INTEGER);
            $user = $this->userLogic->getByFingerprintid($fingerprint);
            $this->returnResponse(SUCCESS_RESPONSE, $user);
        } catch (Exception $e) {
            $this->throwError(ERROR_RESPONSE, $e->getMessage());
        }
    }
}
?>
