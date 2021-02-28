<?php
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
?>