<?php
class UserLogic{

    private $data;
    public function __construct()
    {
        $this->data = new UserData;
    }
    public function getAll($criteria){
        $users = $this->data->getAll($criteria);
        $this->data->close();
        return $users;
    }
    public function getBy($username,$password){
        $user = $this->data->getBy($username,$password);
        $this->data->close();
        return $user;
    }
    public function getByUserID($userid){
        $obj = $this->data->getByUserID($userid);
        $this->data->close();
        return $obj;
    }
    public function add(UserModel $user)
    {
        $this->data->add($user);
        $this->data->close();
    }
    public function edit($id, $user)
    {
        $this->data->edit($id, $user);
        $this->data->close();
    }
    public function delete($id)
    {
        $this->data->delete($id);
        $this->data->close();
    }
    public function resetFinger($id)
    {
        $this->data->resetFinger($id);
        $this->data->close();
    }
    public function editFingerPrint($fingerprint)
    {
        $this->data->editFingerPrint($fingerprint);
        $this->data->close();
    }
    public function getByFingerprintid($fingerprint){
        $obj = $this->data->getByFingerprintid($fingerprint);
        $this->data->close();
        return $obj;
    }
}
?>