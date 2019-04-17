<?php

require_once "config.php";

$userid = $_REQUEST['userid'];
$projectid = $_REQUEST['projectid'];
$message = "Your request accepted";

//  UPDATE INTO applied_users

$update_query = "UPDATE applied_users SET approved=1 WHERE user_id = '".$userid."' AND project_id = ".$projectid;
$result = mysqli_query($con,$update_query);

// INSERT INTO project_members

$members = "INSERT INTO project_members (project_id,user_id) VALUES ($projectid , $userid)";
$mem_exec = mysqli_query($con,$members);

if($mem_exec){
    $response = array('error' => 'false' , 'message' => 'success' , 'description' => 'successfully added to project_members');    
}
else
{
     $response = array('error' => 'true' , 'message' => 'not success' , 'description' => 'not added to project_members' , 'error' => mysqli_error($con));
}

// //OBTAIN REQUIRED Fields

$sql = "SELECT creator FROM projects WHERE id=$projectid";
$resultsql = mysqli_query($con,$sql);
$row = mysqli_fetch_assoc($resultsql);
$creator = $row['creator'];
$project_type = 'approved_student';

//INSERT INTO notifications

$time = time();
$insert_into_notifications =  "INSERT INTO notifications (owner_id,project_id,user_id,type,time) VALUES ('$creator',$projectid,'$userid','$project_type',$time)";
$result2 = mysqli_query($con,$insert_into_notifications);
    if($result2){
        $response = array('error' => 'false' , 'message' => 'success' , 'description' => 'successfully sent');    
    }
    else{
        $response = array('error' => 'true' , 'message' => 'not success' , 'description' => 'Notification not sent' , 'error' => mysqli_error($con));
    }

header('content-type: application/json');
echo json_encode($response);
?>