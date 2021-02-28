<?php
class DataManager {
    private $conn;

    public function __construct($host, $username, $password, $db_name){
        #$this->conn = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8mb4", $username, $password);
        $this->conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
        

    }

    public function retrieveResidents(){

    }

    public function retrieveIssues(){

    }

    public function dataBank(){
        return $this->conn;
    }
} #partially completed
?>