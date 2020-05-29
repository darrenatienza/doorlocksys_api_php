<?php
class AccessLogLogic{

    public function __construct()
    {
        
    }

    public function getAll($date,$criteria){
        $data = new AccessLogData();
        $objs = $data->getAll($date,$criteria);
        $data->close();
        return $objs;
        //return $date . $criteria;
    }
    public function getAllRecords()
    {
        $data = new AccessLogData();
        $objs = $data->getAllRecords();
        $data->close();
        return $objs;
    }
    public function add($userid,$logs)
    {
        $data = new AccessLogData();
        $objs = $data->add($userid,$logs);
        $data->close();
        return $objs;
    }
}
?>