<?php
session_start();
require 'classes.php';
if(isset($_POST['residentID']) && isset($_POST['residentPass'])){
    #NEEDS SANITIZATION
    $residentID = $_POST['residentID'];
    $residentPass = $_POST['residentPass'];

    $residentControll = new ResidentController($data_store);
    
    #$_SESSION['resident'] = $residentControll->getResident($residentID);
    if($_SESSION['resident'] === FALSE){
        return FALSE;
    } else {
        $login = new Login($data_store);
        $_SESSION['residentID'] = $residentID;
        $_SESSION['isLogged'] = $login->signIN($residentID, $residentPass);
        #echo "<script>console.log('" . $_SESSION['isLogged'] ."')</script>";
    }
    /*$login = new Login($data_store);
    $_SESSION['isLogged'] = $login->signIN($residentID, $residentPass);*/
}

/*if($_SESSION['isLogged'] === TRUE){
    header('Location: ../old-home.html');
}*/
