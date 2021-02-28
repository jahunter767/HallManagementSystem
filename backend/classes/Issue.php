<?php
class Issue {
    private $HMemberIDnum, $date, $classification, $status, $description, $cluster_name, $room_num, $household;
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

    public function setStatus($status){
        $this->status = $status;
    }

    public function getDate(){
        return $this->date;
    }

    public function changeClassification($classification){
        $this->classification = $classification;
    }

    public function getHMemberIDnum(){
        return $this->HMemberIDnum;
    }

    public function getDescription(){
        return $this->description;
    }

    public function changeDescription($description){
        $this->description = $description;
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

    public function setDate($date){ #in format "m d Y", ie: "11 24 2019"
        $this->date = $date;
    }

    public function setClusterName($cluster_name){
        $this->cluster_name = $cluster_name;
    }

    public function setRoomNumber($room_num){
        $this->room_num = $room_num;
    }

    public function setHousehold($household){
        $this->household = $household;
    }
} #class complete
?>