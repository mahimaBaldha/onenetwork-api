<?php
    require_once "config.php";
    $userid = $_REQUEST['userid'];
    // $projectid = $_REQUEST['projectid'];
    $project_name_array = array();
    if(empty($userid)){
        $response = array("error" => "true", "message" => "not success", "description" => "userid cannot be empty");
    }
    else{
        $applied_user_details = "SELECT * FROM applied_users WHERE user_id = $userid AND approved = 1";
        $result = mysqli_query($con,$applied_user_details);
        if(mysqli_num_rows($result)>0){
            // $response = array("error" => "false", "message" => "success", "description" => "approved successfully");
            while($row = mysqli_fetch_assoc($result)){
                $get_project_name = "SELECT title FROM projects WHERE id = ".$row['project_id'];
                $result2 = mysqli_query($con,$get_project_name);
                $row2 = mysqli_fetch_assoc($result2);
                array_push($project_name_array,$row2);
            }
            $response = array("error" => "false", "message" => "success", "description" => $project_name_array);
            
        }
        else{
            $response = array("error" => "true", "message" => "not success", "description" => "no new notifications");
        }
    }
    header('content-type: application/json');
    echo json_encode($response);
?>