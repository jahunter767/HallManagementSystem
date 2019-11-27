<?php
session_start();
require 'classes.php';
if(isset($_POST['adminID']) && isset($_POST['adminPass'])){
    #NEEDS SANITIZATION
    $adminID = $_POST['adminID'];
    $adminPass = $_POST['adminPass'];

    
    $login = new Login($data_store);
    $_SESSION['adminID'] = $adminID;
    $_SESSION['isLogged'] = $login->signInA($adminID, $adminPass);
}