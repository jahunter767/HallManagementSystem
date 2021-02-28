<?php
class Machine{
    private $machineID;
    private $machineType;
    public $schedule;

    public function getMachineID(){
        return $this->$machineID;
    }

    public function getType(){
        return $this->$machineType;
    }

    public function scheduleSlot(){

    }

    public function setMachineID($id){
        $this->$machineID = $id;
    }

    public function liberateSlot($date, $residentID){

    }     

}
?>