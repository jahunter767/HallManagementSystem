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
        #echo '<p>This is the rest of the test</p>';
        foreach($resident as $r){
            $this->resident = new Resident($r['IDnum'], $r['cluster_name'], $r['household'], $r['room_num']);
        }
        #$this->resident = $statement->fetch();
        #echo $this->resident->getClusterName();
        return $this->resident;
    } #Completed function, returns a resident object when the resident is found in the database given the resident's id number
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

    public function addLogin($username, $password){

    }
}

class Machine{
    private $status; //to state whether Machine is working or not, 1 being working 0 not
    
    public function changeStatus(){
        if ($status == 1){
            $status = 0;
        }   
        else {
            $status = 1;
        }     
    }

    public function MachineStatus(){
        return $this->status;
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
        $statement = $this->database->prepare('SELECT date, classification, status, description, cluster_name, room_num, household FROM issues WHERE HMemberIDnum = :HMemberIDnum');
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
    
}

$data_store = '';

try {
    $data_store = new DataManager(getenv('IP'), 'cargill', 'qw$:8Kz%', 'azprestonhall');
} catch(Exception $e) {
    die($e->getMessages());
    echo "<script> alert('Cannot connect to database');</script>";
}

###################################################
##                                               ##
##                  TEST SITE                    ##
##                                               ##
###################################################

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
