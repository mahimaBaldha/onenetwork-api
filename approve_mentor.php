<?php

require_once "config.php";

$userid = $_REQUEST['userid'];
$projectid = $_REQUEST['projectid'];
$message = "You are mentor now";

//  UPDATE INTO applied_users

//$update_query = "UPDATE applied_users SET approved=1 WHERE user_id = '".$userid."' AND project_id = ".$projectid;
//$result = mysqli_query($con,$update_query);

//update project's mentor field from null to mentor id

 $mentor_id = $userid;

$query = "UPDATE projects SET mentor = '".$mentor_id."' WHERE id = ".$projectid;
$result2 = mysqli_query($con,$query);

    if($result2){
        $response = array('error' => 'false' , 'message' => 'success' , 'description' => 'successfully sent');    
    }
    else{
        $response = array('error' => 'true' , 'message' => 'not success' , 'description' => 'Notification not sent' , 'error' => mysqli_error($con));
    }

header('content-type: application/json');
echo json_encode($response);
?>