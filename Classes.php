<?php

class Issue {
    private $HMemberIDnum, $classification, $status, $description, $cluster_name, $room_num, $household;
    private $statuses = array();
    private $issueID;

    function __construct($HMemberIDnum, $classification, $description){
        $this->HMemberIDnum = $HMemberIDnum;
        $this->classification = $classification;
        $this->description = $description;
    }

    public function getIssueID(){
        return $this->issueID;
    }

    public function getClassification(){
        return $this->classification;
    }

    public function getStatuses(){
        return $this->statuses;
    }

    public function changeStatus($index, $status){

    }

    public function changeClassification($index, $classification){

    }

    public function getHMemberIDnum(){
        return $this->HMemberIDnum;
    }

    public function getDescription(){
        return $this->description;
    }

    public function changeDescription($index, $description){

    }

    public function getClusterName(){
        return $this->cluster_name;
    }

    public function getRoomNum(){
        return $this->room_num;
    }

    public function getHousehold(){
        return $this->household;
    }
}

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

class MaintenancePersonnel {
    private $full_name, $description;

    function __construct($full_name, $description){
        $this->full_name = $full_name;
        $this->description = $description;
    }

    public function getFullName(){
        return $this->full_name;
    }

    public function getDescription(){
        return $this->description;
    }
}

#$test = new Issue("1234567890", "PLUMBING", "The kitchen pipe is not working");
#echo $test->getClassification();