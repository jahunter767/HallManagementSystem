<?php
class Slot {
    private $slotID;
    private $date;
    private $startTime;
    private $endTime;
    private $residentID;

    public function getSlotID(){
        return $this->slotID;
    }

    public function getDate(){
        return $this->date;
    }

    public function getStart(){
        return $this->startTime;
    }

    public function getEnd(){
        return $this->endTime;
    }

    public function setSlotID($slotID){
        $this->slotID = $slotID;
    }

    public function setStart($time){
        $this->$startTime = $time;
    }

    public function setEnd($time){
        $this->$endTime = $time;
    }

    public function setDate($date){
        $this->$date = $date;
    }

    public function setResidentID($id){
        $this->$residentID = $id;
    }

    public function getResidentID(){
        return $this->$residentID;
    }
    
}

?>