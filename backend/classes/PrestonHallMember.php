<?php
class PrestonHallMember {
    private $IDnum;
    
    public function __construct($IDnum){
        $this->IDnum = $IDnum;
    }

    public function getIDnum(){
        return $this->IDnum;
    }
} #completed class
?>