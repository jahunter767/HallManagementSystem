<?php
require 'Resident.php';

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
?>