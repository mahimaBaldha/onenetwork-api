<?php
    require_once "config.php";
    require_once "functions.php";
    
    
    if(!empty($_REQUEST['userid'])){
        $userid = $_REQUEST['userid'];
        $posted_project_by_user = "SELECT * FROM projects WHERE creator = ".$userid;
        $result = mysqli_query($con,$posted_project_by_user);
        $posted_project_by_user_array = array();
        if(mysqli_num_rows($result)<1){
            $response = array("error" => "true", "message" => "not success", "description" => "this user hasn't posted any project");
        }
        else{
            while($row = mysqli_fetch_assoc($result)){
                array_push($posted_project_by_user_array,$row);
            }
            $response = array("error" => "false", "message" => "success", "projects_posted_by_user" => $posted_project_by_user_array);
        }
        
    }
    else{
        $response = array("error" => "true", "message" => "not success", "description" => "userid cannot be empty");
    }
    
    header('content-type: application/json');
    echo json_encode($response);
?>