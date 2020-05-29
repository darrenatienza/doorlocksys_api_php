<?php
class DashboardLogic{

    private $data;
    private $data2;
    public function __construct()
    {
        $this->data = new DeviceActionData;
        $this->data2 = new UserData;
    }
    public function getDashboardData(){
        $dashboardModel = new DashboardModel;
        $accessLogs = $this->data->getAll();
        $dashboardModel->accessLogCount = $accessLogs->count();
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