<?php
class DeviceActionLogic{

    private $data;
    public function __construct()
    {
        $this->data = new DeviceActionData;
    }
    public function getAll(){
        return $this->data->getAll();
        $this->data->close();
    }
    
    public function updateActiveStatus($id)
    {
        $this->data->setDevicesInActive();
        $this->data->updateActiveStatus($id);
        $this->data->close();
    }
    public function setDevicesInActive(){
        $this->data->setDevicesInActive();
        $this->data->close();
    }
    public function getActiveDeviceAction()
    {
        return $this->data->getActiveDeviceAction();
        $this->data->close();
    }
    public function editActiveStatus($actionname)
    {
        return $this->data->editActiveStatus($actionname);
        $this->data->close();
    }
}
?>