<?php
require 'ResidentController.php';
require 'AdminController.php';
require 'Feedback.php';

class FeedbackController {
    private $database;
    private $raw_database;
    private $feedback;

    public function __construct($database){
        $this->database = $database->dataBank();
        $this->raw_database = $database;
        $this->feedback = [];
    }

    public function addFeedback($issueID, $comment, $HMemberIDnum){
        $statement = $this->database->prepare('INSERT INTO feedback (issueID) VALUES (:issueID);');
        $statement->bindParam(':issueID', $issueID, PDO::PARAM_INT);
        $statement->execute();

        $statement = $this->database->query('SELECT * FROM feedback ORDER BY feedbackID DESC LIMIT 1;');
        $feedback = $statement->fetchAll(PDO::FETCH_ASSOC);


        $feedback_id = 0;

        foreach($feedback as $f){
            $feedback_id = $f['feedbackID'];
        }
        
        $statement = $this->database->prepare('INSERT INTO feedback_comments (issueID, feedbackID, comment, sender) VALUES (:issueID, :feedback_id, :comment, :feedback_sender)');
        $statement->bindParam(':issueID', $issueID, PDO::PARAM_INT);
        $statement->bindParam(':feedback_id', $feedback_id, PDO::PARAM_INT);
        $statement->bindParam(':comment', $comment, PDO::PARAM_STR, strlen($comment));
        

        $feedback_sender = "NOT FOUND";

        try{
            $PHallMember = new ResidentController($this->raw_database);
            if($PHallMember->getResident($HMemberIDnum)=== NULL){
                throw new Exception("Not a resident");
            } else {
                $PHallMember = $PHallMember->getResident($HMemberIDnum);
                $feedback_sender = $PHallMember->getIDnum();
            }
        } catch(Exception $e) {
            $PHallMember = new AdminController($this->raw_database);
            $PHallMember = $PHallMember->getAdmin($HMemberIDnum);
            $feedback_sender = $PHallMember->getFullName();
        } /*finally {
            echo "Sender: " . $feedback_sender;
        }*/

        $statement->bindParam(':feedback_sender', $feedback_sender, PDO::PARAM_STR, strlen($feedback_sender));
        $statement->execute();

        $statement = $this->database->prepare('INSERT INTO feedback_date (issueID, feedbackID, date) VALUES (:issueID, :feedback_id, :date)');
        $date = date("m d Y"); #in format "m d Y", ie: "11 24 2019"
        $statement->bindParam(':issueID', $issueID, PDO::PARAM_INT);
        $statement->bindParam(':feedback_id', $feedback_id, PDO::PARAM_INT);
        $statement->bindParam(':date', $date, PDO::PARAM_STR, strlen($date));
        $statement->execute();
        echo "<script> alert('Feedback saved!');</script>";
    }

    public function loadFeedbackFromIssue($issueID){
        $issueID = filter_var($issueID, FILTER_SANITIZE_NUMBER_INT);

        $statement = $this->database->query('SELECT feedback_date.date AS date, feedback_comments.comment AS comment, feedback_comments.sender AS sender, feedback_comments.isRead AS isRead, feedback_comments.feedbackID AS feedbackID FROM feedback_date JOIN feedback_comments ON (feedback_date.feedbackID = feedback_comments.feedbackID AND feedback_comments.issueID = ' . $issueID . ')');
        $feedbacks = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach($feedbacks as $f){
            $feedbackObj = new Feedback($f['comment'], $issueID);
            $feedbackObj->setDate($f['date']);
            $feedbackObj->setFeedbackID($f['feedbackID']);
            $feedbackObj->setSender($f['sender']);
            $feedbackObj->setRead($f['isRead']);
            
            $this->feedback[] = $feedbackObj;
        }
    }

    public function sendFeedback(){
        return $this->feedback;
    }

    public function clearFeedback(){
        $this->feedback = [];
    }
}
?>