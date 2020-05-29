<?php

class DeviceAction extends Rest
{
    public $logic;
    public function __construct()
    {
        parent::__construct();
        $this->logic = new DeviceActionLogic;
    }
    public function getAll()
    {
        try {
            $deviceactions = $this->logic->getAll();
            $this->returnResponse(SUCCESS_RESPONSE, $deviceactions);
        } catch (Exception $e) {
            $this->throwError(ERROR_RESPONSE, $e->getMessage());
        }
    }
    public function getActiveDeviceAction()
    {
        try {
            $deviceaction = $this->logic->getActiveDeviceAction();
            $this->returnResponse(SUCCESS_RESPONSE, $deviceaction);
        } catch (Exception $e) {
            $this->throwError(ERROR_RESPONSE, $e->getMessage());
        }
    }
    public function setDevicesInActive(){
        try {
            $this->logic->setDevicesInActive();
            $this->returnResponse(SUCCESS_RESPONSE, "");
        } catch (Exception $e) {
            $this->throwError(ERROR_RESPONSE, $e->getMessage());
        }
    }
    public function updateActiveStatus()
    {
        try {
            $id = $this->validateParameter('id', $this->param['id'], INTEGER);
            $this->logic->updateActiveStatus($id);
            $this->returnResponse(SUCCESS_RESPONSE, "");
        } catch (Exception $e) {
            $this->throwError(ERROR_RESPONSE, $e->getMessage());
        }
    }
    public function editActiveStatus()
    {
        try {
            $actioname = $this->validateParameter('actionname', $this->param['actionname'], STRING);
            $this->logic->editActiveStatus($actioname);
            $this->returnResponse(SUCCESS_RESPONSE, "");
        } catch (Exception $e) {
            $this->throwError(ERROR_RESPONSE, $e->getMessage());
        }
    }
}
