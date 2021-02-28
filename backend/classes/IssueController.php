<?php
require 'ResidentController.php'

class IssueController {
    private $database;
    private $raw_database;

    public function __construct($database){
        $this->database = $database->dataBank();
        $this->raw_database = $database;
    }

    public function addIssue($HMemberIDnum, $classification, $description){
        $statement = $this->database->prepare('INSERT INTO issues (HMemberIDnum, classification, date, description, cluster_name, room_num, household) VALUES (:HMemberIDnum, :classification, :date, :description, :cluster_name, :room_num, :household);');
        $resident_controller = new ResidentController($this->raw_database);

        $resident = $resident_controller->getResident($HMemberIDnum);


        $statement->bindParam(':HMemberIDnum', $HMemberIDnum, PDO::PARAM_STR, strlen($HMemberIDnum));
        $statement->bindParam(':classification', $classification, PDO::PARAM_STR, strlen($classification));
        $date = date("m d Y"); #in format "m d Y", ie: "11 24 2019"
        $statement->bindParam(':date', $date, PDO::PARAM_STR, strlen($date));
        $statement->bindParam(':description', $description, PDO::PARAM_STR, strlen($description));

        $cluster_name = $resident->getClusterName();
        $room_num = $resident->getRoomNum();
        $household = $resident->getHousehold();

        $statement->bindParam(':cluster_name', $cluster_name, PDO::PARAM_STR, strlen($cluster_name));
        $statement->bindParam(':room_num', $room_num, PDO::PARAM_STR, strlen($room_num));
        $statement->bindParam(':household', $household, PDO::PARAM_STR, strlen($household));
        $statement->execute();
        echo "<script> alert('Issue should be stored');</script>";
    }

    public function addIssueBasic($description, $classification){
        $statement = $this->database->prepare('INSERT INTO issues (description, classification, date) VALUES (:description, :classification, :date);');
        $date = date("m d Y"); #in format "m d Y", ie: "11 24 2019"
        $statement->bindParam(':date', $date, PDO::PARAM_STR, strlen($date));
        $statement->bindParam(':description', $description, PDO::PARAM_STR, strlen($description));
        $statement->bindParam(':classification', $classification, PDO::PARAM_STR, strlen($classification));
        $statement->execute();
    }

    public function viewIssuesByHallMemberID($HMemberIDnum){
        $statement = $this->database->prepare('SELECT issueID, date, classification, status, description, cluster_name, room_num, household FROM issues WHERE HMemberIDnum = :HMemberIDnum');
        $statement->bindParam(':HMemberIDnum', $HMemberIDnum, PDO::PARAM_STR, strlen($HMemberIDnum));
        $statement->execute();
        $issues = $statement->fetchAll(PDO::FETCH_ASSOC);

        // foreach($residents as $resident){
        //     echo $issues['date'] . " " . $issues['classification'] . " " . $issues['status'] . " " . $issues['description'] . " " . $issues[cluster_name] . " " . $issues['room_num'] . " " . $issues['household'];
        // }
        return $issues;
    } #returns an associative list of issues reported by a hall member using the hall member's ID number 

    public function updateIssue($issueID, $status){
        $statement = $this->database->prepare('UPDATE issues SET status = :status WHERE issueID = :issueID;');
        $statement->bindParam(':status', $status, PDO::PARAM_STR, strlen($status));
        $statement->bindParam(':issueID', $issueID, PDO::PARAM_STR, strlen($issueID));
        $statement->execute();
    }

    public function viewIssuesByCluster($cluster_name){
        
    }

    public function viewIssuesByStatus($status){

    }

    public function viewIssuesByStatusANDHallMemberID($status, $HMemberIDnum){

    }

    public function viewIssuesByClassification($classification){

    }

    public function viewAllIssues(){
        $statement = $this->database->query('SELECT * FROM issues;');
        $issues = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach($issues as $issue){
            echo "<div class=\"hero-card\">";
            echo "<h3>Issue ID: ". $issue['issueID'] ."</h3>";
            echo "<h6>Date: ". $issue['date'] ."</h6>";
            echo "<h6>Hall Memeber ID number: ". $issue['HMemberIDnum'] ."</h6>";
            echo "<h6>Classification: ". $issue['classification'] ."</h6>";
            echo "<h6>Status: ". $issue['status'] ."</h6>";
            echo "<h6>Description: ". $issue['description'] ."</h6>";
            echo "<h6>Cluster name: ". $issue['cluster_name'] ."</h6>";
            echo "<h6>Room number: ". $issue['room_num'] ."</h6>";
            echo "<h6>Household: ". $issue['household'] ."</h6>";
            echo "</div>";
        }
    }
}

?>