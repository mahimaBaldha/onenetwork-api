<?php
require_once "config.php";
require_once "functions.php";
header('content-type: application/json');
$userid = $_REQUEST['userid'];

if(user_already_exists($con,$userid)){

    $user_role = "SELECT role FROM users WHERE id = $userid";
    $result = mysqli_query($con,$user_role);
    
    $row = mysqli_fetch_assoc($result);
    $user_role_name = "SELECT name FROM roles WHERE id = ".$row['role'];
    $result2 = mysqli_query($con,$user_role_name);
    $row2 = mysqli_fetch_assoc($result2);
        
    $response = array("error" => "false","message" => "success", "role_id" => $row['role'], "role_name" => $row2['name']);
}

else{
    $response = array("error" => "true","message" => "not success", "description" => "user id invalid");
}

echo json_encode($response);
?>