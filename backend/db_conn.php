<?php
require 'classes/DataManager.php';

$data_store = '';
#($host, $username, $password, $db_name)
$host='localhost';
$username='malik';
$password='abc123';
$db_name='azprestonhall';

try {
    $data_store = new DataManager($host, $username, $password, $db_name);
    #$data_store = new DataManager(getenv('IP'), 'cargill', 'qw$:8Kz%', 'azprestonhall');
} catch(Exception $e) {
    die($e->getMessage());
    echo "<script> alert('Cannot connect to database');</script>";
}


#$residentControll = new ResidentController($data_store);
    
#$test_out = $residentControll->getResident('720117676');

###################################################
##                                               ##
##                  TEST SITE                    ##
##                                               ##
###################################################


#$test8 = new FeedbackController($data_store);
#$test8->addFeedback(3, 'I have received no response about the leaking pipe in my household kitchen', '620117676');
#$test8->addFeedback(3, 'Apologies, we will send a plumber in 3 days', '500004432');

#$test8->showFeedbackFromIssue(3);

#$test7 = new Login($data_store);
#$test7->addLogin('500004432', 'admin');

#$test6 = new AdminController($data_store);
#$test6->addAdmin('500004432', 'Resident Advisor', 'John Doe');

#$admin = $test6->getAdmin('500004432');

#echo $admin->getPosition() . " " . $admin->getFullName();
#$test5 = new ResidentController($data_store);
#$resident = $test5->getResident('620117676');

#echo $resident->getIDnum();

#$test4 = new IssueController($data_store);

#$test4->viewIssuesByHallMemberID('620117676');
#$test4->addIssueBasic('The water fountain is not pushing water at reasonable pressure', 'INFRASTRUCTURE');
#$test4->addIssue('620117676', 'PLUMBING', 'The pipe in the kitch keeps running even though it is turned off');


/*$test3 = new Login($data_store);

$test3->signIN('62011767', 'passwor');*/

#$resident_controller->addResident('620125555', 'Shamrock', 'D', '50D4'); #THIS WORKS

#$test = new Issue("1234567890", "PLUMBING", "The kitchen pipe is not working");
#echo $test->getClassification();
#$test1 = new MaintenancePersonnel("John Brown", "Plumber");
#$test1->getFullNameDescription();

#$test2 = new Resident('620115555', 'Los Matadores', 'C', '10C4');

#echo $test2->getIDnum();
#echo $test2->getClusterName();
#echo $test2->getRoomNum();
#echo $test2->getHousehold();

/*$data_store = $data_store->dataBank();
$statement = $data_store->query('SELECT * FROM resident');
$residents = $statement->fetchAll(PDO::FETCH_ASSOC);

foreach($residents as $person){
    echo $person['IDnum'] . '\n';
}*/


/*$resident_controller = new ResidentController($data_store); #THIS WORKS
$person = $resident_controller->getResident('620117676');
echo $person->getIDnum();*/

#$chckRes = new AdminController($data_store);

/*$viewIssues = new IssueController($data_store);
    #SANITATION IF TIME SPARES
$issues = $viewIssues->viewIssuesByHallMemberID('620117676');
?>
    <?php foreach($issues as $issue): ?>
        <div class="form-card"> <!---->
          <h1>Track Issue#: <?= $issue['issueID'];?></h1>
          <h5>Description: <?= $issue['description'];?></h5>
          <div class="viewissue">
            <!--<h6>Issue Number:</h6>-->
            <h6>Date Logged: <?= $issue['date'];?></h6>
            <h6>Status: <?= $issue['status'];?></h6>
            <p id="feedback-id" style="display: hidden"></p>
          </div>
        </div> <!---->
      <?php endforeach; ?>

<php
*/

/*$load_feedback = new FeedbackController($data_store);
$load_feedback->loadFeedbackFromIssue(7);
$feedback_list = $load_feedback->sendFeedback();
?>
<!---->
<?php foreach($feedback_list as $feedbackI): ?>
    <div class="form-card"> <!---->
    <h1>From: <?= $feedbackI->getSender();?></h1>
    <h5>Comment: <?= $feedbackI->getComment();?></h5>
    <div class="viewissue">
        <!--<h6>Issue Number:</h6>-->
        <h6>Date Logged: <?= $feedbackI->getDate();?></h6>
        <h6>Status: <?= $feedbackI->isRead();?></h6>
        <p id="feedback-id" style="display: hidden"></p>
        <a href="give-feedback.php">Add feedback</a>
    </div>
    </div> <!---->
<?php endforeach; ?>*/

?>