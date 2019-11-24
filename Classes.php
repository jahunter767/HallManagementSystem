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

    public function changeStatus($status){
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
}

class HallMember {
    private $IDnum;
    
    public function __construct($IDnum){
        $this->IDnum = $IDnum;
    }

    public function getIDnum(){
        return $this->IDnum;
    }
}

class Resident extends HallMember{
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
    }

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
    }
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
    }

    public function addLogin($username, $password){

    }
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

$test3 = new Login($data_store);

$test3->signIN('62011767', 'passwor');

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
