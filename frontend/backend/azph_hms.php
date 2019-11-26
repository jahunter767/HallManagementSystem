<?php
require 'classes.php';
session_start();
if(isset($_POST['residentID']) && isset($_POST['residentPass'])){
    #NEEDS SANITIZATION
    $residentID = $_POST['residentID'];
    $residentPass = $_POST['residentPass'];

    $residentControll = new ResidentController($data_store);
    
    $_SESSION['resident'] = $residentControll->getResident($residentID);
    if($_SESSION['resident'] === FALSE){
        return FALSE;
    } else {
        $login = new Login($data_store);
        $login->signIN($residentID, $residentPass);
    }
    /*$login = new Login($data_store);
    $_SESSION['isLogged'] = $login->signIN($residentID, $residentPass);*/
}
/*if($_SESSION['isLogged'] === TRUE){
    header('Location: ../old-home.html');
}*/
