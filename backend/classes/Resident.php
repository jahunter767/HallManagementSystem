<?php
require 'PrestonHallMember.php';

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

?>