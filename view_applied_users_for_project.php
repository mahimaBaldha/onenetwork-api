<?php
require_once "config.php";
$users_array = array();
if(empty($_REQUEST['projectid'])){
    $response = array("error" => "true", "message" => "not success", "description" => "project id required");
}
else{
    $projectid = $_REQUEST['projectid'];
    $applied_users = "SELECT user_id FROM applied_users WHERE project_id = $projectid";
    $result = mysqli_query($con,$applied_users);
    if(mysqli_num_rows($result)<1){
        $response = array("error" => "true", "message" => "not success", "description" => "project id required");
    }
    else{
        while($row = mysqli_fetch_assoc($result)){
            // $users_array = array();
            $get_users = "SELECT id,firstname,lastname FROM users WHERE id =". $row['user_id'];
            $result2 = mysqli_query($con,$get_users);
            if($result2){
                $row2 = mysqli_fetch_assoc($result2);
                
                $row2['name']=$row2['firstname']." ". $row2['lastname'];
                array_push($users_array,$row2);
                
                $response = array("error" => "false", "message" => "success", "applied_users" => $users_array);
                
            }
            else{
                $response = array("error" => "true", "message" => "not success", "description" => "could not fetch users");
            }
        }
    }
}
header('content-type: application/json');
echo json_encode($response);
?>