<?php
require 'PrestonHallMember.php';

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
?>