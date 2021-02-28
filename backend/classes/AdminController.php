<?php
require 'Admin.php';

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

        /*foreach($admin as $a){
            $this->admin = new Admin($a['id_num'], $a['cluster_name'], $a['room_num'], $a['position'], $a['full_name']);
        }*/

        if($admin === []){
            echo "<script> alert('User not found');</script>";
            return FALSE;
        } else {
            foreach($admin as $a){
                $this->admin = new Admin($a['id_num'], $a['cluster_name'], $a['room_num'], $a['position'], $a['full_name']);
            }
        }
        return $this->admin;
    } #Completed function, returns a admin object when the admin is found in the database given the admin's id number
}
?>