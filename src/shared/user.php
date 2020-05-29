<?php

class User extends Rest
{
    public $logic;
    public function __construct()
    {
        parent::__construct();
        $this->logic = new UserLogic;
    }
    public function getAll()
    {
        try {
            $criteria = $this->validateParameter('criteria', $this->param['criteria'], STRING,false);
            $users = $this->logic->getAll($criteria);
            $this->returnResponse(SUCCESS_RESPONSE, $users);
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
            $this->logic->add($user);
            $this->returnResponse(SUCCESS_RESPONSE, "");
        } catch (Exception $e) {
            $this->throwError(ERROR_RESPONSE, $e->getMessage());
        }
    }
    public function getCurrentUser()
    {
        try {
            $id = $this->user_id;
            $user = $this->logic->getByUserID($id);
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
            $user = $this->logic->getByUserID($id);
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
            $users = $this->logic->edit($id, $user);
            $this->returnResponse(SUCCESS_RESPONSE, "");
        } catch (Exception $e) {
            $this->throwError(ERROR_RESPONSE, $e->getMessage());
        }
    }
    public function delete()
    {
        try {
            $id = $this->validateParameter('id', $this->param['id'], INTEGER);
            $users = $this->logic->delete($id);
            $this->returnResponse(SUCCESS_RESPONSE, "");
        } catch (Exception $e) {
            $this->throwError(ERROR_RESPONSE, $e->getMessage());
        }
    }
    public function resetFinger()
    {
        try {
            $id = $this->validateParameter('id', $this->param['id'], INTEGER);
            $users = $this->logic->resetFinger($id);
            $this->returnResponse(SUCCESS_RESPONSE, "");
        } catch (Exception $e) {
            $this->throwError(ERROR_RESPONSE, $e->getMessage());
        }
    }
    public function editFingerPrint()
    {
        try {
            $fingerprint = $this->validateParameter('fingerprint', $this->param['fingerprint'], INTEGER);
            $this->logic->editFingerPrint($fingerprint);
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
            $user = $this->logic->getByFingerprintid($fingerprint);
            $this->returnResponse(SUCCESS_RESPONSE, $user);
        } catch (Exception $e) {
            $this->throwError(ERROR_RESPONSE, $e->getMessage());
        }
    }
}
?>
