<?php
class Feedback {
    private $feedbackID;
    private $date;
    private $issueID;
    private $comment;
    private $read;
    private $sender;

    public function __construct($comment, $issueID){
        $this->comment = $comment;
        $this->issueID = $issueID;
        $this->read = FALSE;
        $this->date = date("m d Y"); #in format "m d Y", ie: "11 24 2019"
    }

    public function getFeedbackID(){
        return $this->feedbackID;
    }
    
    public function getSender(){
        return $this->sender;
    }

    public function setDate($date){
        $this->date = $date;
    }

    public function setFeedbackID($feedbackID){
        $this->feedbackID = $feedbackID;
    }

    public function setSender($sender){
        $this->sender = $sender;
    }

    public function setRead($read){
        $this->read = $read;
    }

    public function getDate(){
        return $this->date;
    } 

    public function getIssueID(){
        return $this->issueID;
    }

    public function markAsRead(){
        $this->read = !$this->read;
    }

    public function isRead(){
        $r = ($this->read === 1)?  TRUE: FALSE;
        return $r;
    }

    public function getComment(){
        return $this->comment;
    }
}
?>