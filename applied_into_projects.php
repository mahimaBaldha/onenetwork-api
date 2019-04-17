<?php

require_once "config.php";
header('content-type: application/json');

$userid = $_REQUEST['userid'];

$projects = array();
$query = "SELECT user_id,project_id,approved FROM applied_users WHERE user_id = $userid";
$result = mysqli_query($con,$query);

if(mysqli_num_rows($result)<1){
    
    $msg = array('error' => mysqli_error($con) , 'message' => 'Not success', 'description'=>'user has not applied for any project' );
    
}else
{
    while($row = mysqli_fetch_assoc($result))
    {
        $q = "SELECT * from projects WHERE id = ".$row['project_id'];
        $exec_q = mysqli_query($con,$q);
        $row3 = mysqli_fetch_assoc($exec_q);
        
        $intereststr="";
        $interests_array = array();
        $interests = "SELECT i.name FROM interests i JOIN project_in_interests p ON i.id = p.interest_id WHERE p.project_id = ".$row3['id'];
        $exec_interests = mysqli_query($con,$interests);
        if($exec_interests){
            while($row2 = mysqli_fetch_assoc($exec_interests)){
                // array_push($interests_array, $row2);
                $intereststr.= $row2['name'].",";
            }
            $intereststr = rtrim($intereststr,",");
        }
        $msg1 = array('project_detail' => $row3 , 'approved_status' => $row['approved'] , 'interests_string' => $intereststr);
        array_push($projects , $msg1);
    }
    
   $msg = array('error' => 'false' , 'message' => 'success' , 'projects' => $projects);
}

echo json_encode($msg);

?>