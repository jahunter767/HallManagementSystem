<?php
class Appointment {
    private $time, $date, $issueID;

    function __construct($time, $date, $issueID){
        $this->time = $time;
        $this->date = $date;
        $this->issueID;
    }

    public function getTime(){
        return $this->time;
    }

    public function getDate(){
        return $this->date;
    }

    public function getIssueID(){
        return $this->issueID;
    }
} #class complete


?>