<?php
    require_once "config.php";
    $userid = $_REQUEST['userid'];
    $projectid = $_REQUEST['projectid'];
    
    if(empty($userid) || empty($projectid)){
        $response = array("error" => "true", "message" => "not success", "description" => "user id or projectid cannot be empty");
    }
    else{
        $approve = "UPDATE applied_users SET approved = 1 WHERE user_id = $userid AND project_id = $projectid";
        $result = mysqli_query($con,$approve);
        if($result){
            $response = array("error" => "false", "message" => "success", "description" => "approved successfully");
        }
        else{
            $response = array("error" => "true", "message" => "not success", "description" => "could not update");
        }
    }
    header('content-type: application/json');
    echo json_encode($response);
?>