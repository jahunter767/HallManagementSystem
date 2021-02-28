<?php
session_start();
require 'db_conn.php';
require 'classes/IssueController.php';

if($_SESSION['isLogged'] === FALSE){
  header('Location: index.php');
}


if(!empty($_POST['description'])){
  $issueControll = new IssueController($data_store);
  #echo "Huh?" . $_SESSION['isLogged'] . "Huhhh? " . $_SERVER['test'] . $sTest;
  $issueControll->addIssue($_POST['residentID'], $_POST['classification'], $_POST['description']);
  exit('PASSED');
} else {
    exit('FAILED');
}
?>