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

    public function getFullNameDescription(){
        $full_n_des = array($this->full_name, $this->description);
        return $full_n_des; #This should be imploded to access the values
    }
}

class DataManager {
    private $conn;

    public function __construct($host, $username, $password, $db_name){
        $this->conn = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8mb4", $username, $password);
    }

    public function retrieveResidents(){

    }

    public function retrieveIssues(){

    }

    public function dataBank(){
        return $this->conn;
    }
} #partially completed

class PrestonHallMember {
    private $IDnum;
    
    public function __construct($IDnum){
        $this->IDnum = $IDnum;
    }

    public function getIDnum(){
        return $this->IDnum;
    }
} #completed class

class Admin extends PrestonHallMember{
    private $cluster_name;
    private $room_num;
    private $position;
    private $full_name;
    

    public function __construct($IDnum, $cluster_name, $room_num, $position, $full_name){
        parent::__construct($IDnum);
        $this->cluster_name = $cluster_name;
        $this->room_num = $room_num;
        $this->position = $position;
        $this->full_name = $full_name;
    }

    public function getPosition(){
        return $this->position;
    }

    public function getFullName(){
        return $this->full_name;
    }

    public function getClusterName(){
        return $this->cluster_name;
    }

    public function getRoomNum(){
        return $this->room_num;
    }
}

class Resident extends PrestonHallMember{
    private $cluster_name;
    private $household;
    private $room_num;

    public function __construct($IDnum, $cluster_name, $household, $room_num){
        parent::__construct($IDnum);
        $this->cluster_name = $cluster_name;
        $this->household = $household;
        $this->room_num = $room_num;
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
} #completed class

class AdminController {
    private $admin;
    private $database;

    public function __construct($database){
        $this->database = $database->dataBank();
    }

    public function addAdmin($id_num, $position, $full_name){
        $statement = $this->database->prepare('INSERT INTO admin (id_num, position, full_name) VALUES (:id_num, :position, :full_name);');
        $statement->bindParam(':id_num', $id_num, PDO::PARAM_STR, strlen($id_num));
        $statement->bindParam(':position', $position, PDO::PARAM_STR, strlen($position));
        $statement->bindParam(':full_name', $full_name, PDO::PARAM_STR, strlen($full_name));
        $statement->execute();
    }
    
    public function deleteAdmin(){

    }

    public function getAdmin($id_num){
        $statement = $this->database->prepare('SELECT * FROM admin WHERE id_num = :id_num');
        $statement->bindParam(':id_num', $id_num, PDO::PARAM_STR, strlen($id_num));
        $statement->execute();
        $admin = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach($admin as $a){
            $this->admin = new Admin($a['id_num'], $a['cluster_name'], $a['room_num'], $a['position'], $a['full_name']);
        }
        return $this->admin;
    } #Completed function, returns a admin object when the admin is found in the database given the admin's id number
}

class ResidentController {
    private $resident;
    private $database;

    public function __construct($database){
        $this->database = $database->dataBank();
    }

    public function addResident($IDnum, $cluster_name, $household, $room_num){
        #$resident = new Resident($IDnum, $cluster_name, $household, $room_num);
        $statement = $this->database->prepare('INSERT INTO resident (IDnum, cluster_name, household, room_num) VALUES (:IDnum, :cluster_name, :household, :room_num);');
        $statement->bindParam(':IDnum', $IDnum, PDO::PARAM_STR, strlen($IDnum));
        $statement->bindParam(':cluster_name', $cluster_name, PDO::PARAM_STR, strlen($cluster_name));
        $statement->bindParam(':household', $household, PDO::PARAM_STR, strlen($household));
        $statement->bindParam(':room_num', $room_num, PDO::PARAM_STR, strlen($room_num));
        $statement->execute();
    } #Completed function, adds a resident to the database given the required parameters

    public function getResident($IDnum){
        $statement = $this->database->prepare('SELECT * FROM resident WHERE IDnum = :IDnum');
        $statement->bindParam(':IDnum', $IDnum, PDO::PARAM_STR, strlen($IDnum));
        $statement->execute();
        #$statement = $this->database->query("SELECT * FROM resident WHERE IDnum = $IDnum");
        #$statement->setFetchMode(PDO::FETCH_CLASS, 'Resident');

        $resident = $statement->fetchAll(PDO::FETCH_ASSOC);
        #print_r($resident);

        if($resident === []){
            echo "<script> alert('User not found');</script>";
            return FALSE;
        } else {
            foreach($resident as $r){
                $this->resident = new Resident($r['IDnum'], $r['cluster_name'], $r['household'], $r['room_num']);
            }
        }
        #echo '<p>This is the rest of the test</p>';
        #$this->resident = $statement->fetch();
        #echo $this->resident->getClusterName();
        return $this->resident;
    } #Completed function, returns a resident object when the resident is found in the database given the resident's id number or FALSE if the resident is not found
}

class Login {
    private $username;
    private $password;

    public function __construct($database){
        $this->database = $database->dataBank();
    }

    public function signIN($username, $password){
        $statement = $this->database->prepare('SELECT username FROM login WHERE username = :username AND password = :password');
        $statement->bindParam(':username', $username, PDO::PARAM_STR, strlen($username));
        $statement->bindParam(':password', $password, PDO::PARAM_STR, strlen($password));
        $statement->execute();
        $usernames = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        $state = FALSE;
        
        foreach($usernames as $username){
            if(isset($username['username'])){
                $this->username = $username['username'];
                echo "<script>alert('Logged in successfully!');</script>";
                $state = TRUE;
                break;
            }
        }

        if(!$state){
            echo "<script>alert('Username or password incorrect!');</script>";
            return FALSE;
        } else {
            return TRUE;
        }
    } #Complete function, returns TRUE if the username and password matches from the database or FALSE if they do not

    public function addLogin($username, $password){ #Use admin or resident controller to retrieve the admin or resident object then return the ID number of the object. A resident or admin has to be in the system before registering with a password
        $statement = $this->database->prepare('INSERT INTO login (username, password) VALUES (:username, :password)');
        $statement->bindParam(':username', $username, PDO::PARAM_STR, strlen($username));
        $statement->bindParam(':password', $password, PDO::PARAM_STR, strlen($password));
        $statement->execute();
        echo "<script>alert('Username and password saved!');</script>";
    }
}

class WashroomScheduleController {
    private $washroom_schedule;

    public function addWashroomSchedule($washroom_schedule){

    }

    public function deleteWashroomSchedule($washroom_schedule){
        
    }

}

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
        $residents = $statement->fetchAll(PDO::FETCH_ASSOC);

        /*foreach($residents as $resident){
            echo $resident['date'] . " " . $resident['classification'] . " " . $resident['status'] . " " . $resident['description'] . " " . $resident[cluster_name] . " " . $resident['room_num'] . " " . $resident['household'];
        }*/
        return $residents;
    } #returns an associative list of issues reported by a hall member using the hall member's ID number 

    public function viewIssuesByCluster($cluster_name){
        
    }

    public function viewIssuesByStatus($status){

    }

    public function viewIssuesByStatusANDHallMemberID($status, $HMemberIDnum){

    }

    public function viewIssuesByClassification($classification){

    }
}

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

class FeedbackController {
    private $database;
    private $raw_database;
    private $feedback;

    public function __construct($database){
        $this->database = $database->dataBank();
        $this->raw_database = $database;
        $this->$feedback = [];
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

class Report {
    private $startDate;
    private $endDate;
    private $issues;
    private $residents;
    private $admin;
    private $feedback_list;
    private $maintenance_schedule; //not finished :MaintenanceScheduler
    
    public function viewStartDate(){
        return $startDate;
    }

    public function viewEndDate(){
        return $startDate;
    }

    public function issuesAndFeedback(){

       /* while (count($array2) < 10 ) {
            $array2[] = '$issues' . '$feedback_list' . '\n';
        }*/

    }

    public function issuesAndCluster(){

    }
    
    public function issuesAndMSchedule(){
        
    }

    public function feedbackAndResidents(){
        
    }

}



$data_store = '';

try {
    $data_store = new DataManager(getenv('IP'), 'cargill', 'qw$:8Kz%', 'azprestonhall');
} catch(Exception $e) {
    die($e->getMessages());
    echo "<script> alert('Cannot connect to database');</script>";
}

#$residentControll = new ResidentController($data_store);
    
#$test_out = $residentControll->getResident('720117676');

###################################################
##                                               ##
##                  TEST SITE                    ##
##                                               ##
###################################################


#$test8 = new FeedbackController($data_store);
#$test8->addFeedback(3, 'I have received no response about the leaking pipe in my household kitchen', '620117676');
#$test8->addFeedback(3, 'Apologies, we will send a plumber in 3 days', '500004432');

#$test8->showFeedbackFromIssue(3);

#$test7 = new Login($data_store);
#$test7->addLogin('500004432', 'admin');

#$test6 = new AdminController($data_store);
#$test6->addAdmin('500004432', 'Resident Advisor', 'John Doe');

#$admin = $test6->getAdmin('500004432');

#echo $admin->getPosition() . " " . $admin->getFullName();
#$test5 = new ResidentController($data_store);
#$resident = $test5->getResident('620117676');

#echo $resident->getIDnum();

#$test4 = new IssueController($data_store);

#$test4->viewIssuesByHallMemberID('620117676');
#$test4->addIssueBasic('The water fountain is not pushing water at reasonable pressure', 'INFRASTRUCTURE');
#$test4->addIssue('620117676', 'PLUMBING', 'The pipe in the kitch keeps running even though it is turned off');


/*$test3 = new Login($data_store);

$test3->signIN('62011767', 'passwor');*/

#$resident_controller->addResident('620125555', 'Shamrock', 'D', '50D4'); #THIS WORKS

#$test = new Issue("1234567890", "PLUMBING", "The kitchen pipe is not working");
#echo $test->getClassification();
#$test1 = new MaintenancePersonnel("John Brown", "Plumber");
#$test1->getFullNameDescription();

#$test2 = new Resident('620115555', 'Los Matadores', 'C', '10C4');

#echo $test2->getIDnum();
#echo $test2->getClusterName();
#echo $test2->getRoomNum();
#echo $test2->getHousehold();

/*$data_store = $data_store->dataBank();
$statement = $data_store->query('SELECT * FROM resident');
$residents = $statement->fetchAll(PDO::FETCH_ASSOC);

foreach($residents as $person){
    echo $person['IDnum'] . '\n';
}*/


/*$resident_controller = new ResidentController($data_store); #THIS WORKS
$person = $resident_controller->getResident('620117676');
echo $person->getIDnum();*/

#$chckRes = new AdminController($data_store);
