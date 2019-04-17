<?php
    require_once "config.php";
    require_once "functions.php";
    $path = $_SERVER['SERVER_NAME']."/images/user_pics/";
    // echo $path;
    $userid = $_REQUEST['userid'];
    if(empty($userid)){
        $response = array("error" => "true", "message" => "not success", "description" => "Userid cannot be empty");
    }
    else{
        if(user_already_exists($con,$userid)){
            $user_details = "SELECT * FROM users WHERE id= $userid";
            $result = mysqli_query($con,$user_details);
            
            if(mysqli_num_rows($result)<1){
                $response = array("error" => "true", "message" => "not success", "description" => "could fetch details");
                
            }else{
                $row = mysqli_fetch_assoc($result);
                $row['profile_pic'] = "http://".$_SERVER['SERVER_NAME']."/images/user_pics/".$row['profile_pic'];
                $row['resume'] = "http://".$_SERVER['SERVER_NAME']."/user_resumes/".$row['resume'];
                $response = array("error" => "false", "message" => "success", "user_details" => $row);
            }
        }
        else{
            $response = array("error" => "true", "message" => "not success", "description" => "User doesn't exists");
        }
    }
        
    header('content-type: application/json');
    echo json_encode($response);
    
?>