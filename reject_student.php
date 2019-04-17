<?php

require_once "config.php";

$userid = $_REQUEST['userid'];
$projectid = $_REQUEST['projectid'];

//INSERT INTO applied_users
$delete = "DELETE FROM applied_users WHERE user_id = $userid AND project_id = $projectid";
$result = mysqli_query($con,$delete);

//OBTAIN REQUIRED Fields

$sql = "SELECT creator FROM projects WHERE id=$projectid";
$resultsql = mysqli_query($con,$sql);
$row = mysqli_fetch_assoc($resultsql);
$creator = $row['creator'];
$project_type = 'student_rejected';

//INSERT INTO notifications

$time = time();
$insert_into_notifications =  "INSERT INTO notifications (owner_id,project_id,user_id,type,time) VALUES ('$userid',$projectid,'$creator','$project_type',$time)";
$result2 = mysqli_query($con,$insert_into_notifications);

if($result){
    if($result2){
        $response = array('error' => 'false' , 'message' => 'success' , 'description' => "successfully sent");    
    }
    else{
        $response = array('error' => 'true' , 'message' => 'not success' , 'description' => "Notification not sent");
    }
}
else{
    $response = array('error' => 'true' , 'message' => 'not success' , 'description' => "Not applied for project");
}

header('content-type: application/json');
echo json_encode($response);
?>