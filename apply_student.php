<?php

require_once "config.php";

$userid = $_REQUEST['userid'];
$projectid = $_REQUEST['projectid'];
$isresume = $_REQUEST['resume'];
$message = $_REQUEST['message'];


//INSERT INTO applied_users
$insert = "INSERT INTO applied_users (user_id,project_id,resume,message) VALUES ('$userid',$projectid,$isresume,'$message')";
$result = mysqli_query($con,$insert);


//OBTAIN REQUIRED Fields

$sql = "SELECT creator FROM projects WHERE id=$projectid";
$resultsql = mysqli_query($con,$sql);
$row = mysqli_fetch_assoc($resultsql);
$creator = $row['creator'];
$project_type = 'applied_student';

//INSERT INTO notifications

$time = time();
$insert_into_notifications =  "INSERT INTO notifications (owner_id,project_id,user_id,type,time) VALUES ('$creator',$projectid,'$userid','$project_type',$time)";
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