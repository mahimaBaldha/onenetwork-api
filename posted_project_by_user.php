<?php

require_once "config.php";
header('content-type: application/json');

$user = $_REQUEST['userid'];

$projects = array();
$query = "SELECT * FROM projects WHERE creator = $user AND deleted = 0";
$result = mysqli_query($con,$query);

if(mysqli_num_rows($result)<1){
    
    $msg = array('error' => mysqli_error($con) , 'message' => 'Not success' );
    
}else
{
    while($row = mysqli_fetch_assoc($result))
    {
        $intereststr="";
        $interests_array = array();
        $interests = "SELECT i.name FROM interests i JOIN project_in_interests p ON i.id = p.interest_id WHERE p.project_id = ".$row['id'];
        $exec_interests = mysqli_query($con,$interests);
        if($exec_interests){
            while($row2 = mysqli_fetch_assoc($exec_interests)){
                // array_push($interests_array, $row2);
                $intereststr.= $row2['name'].",";
            }
            $intereststr = rtrim($intereststr,",");
        }
        // $msg1 = array('project' => $row ,'interests' => $interests_array);
        $msg1 = array('project' => $row ,'interests_string' => $intereststr);
        array_push($projects , $msg1);
    }
    $msg4 = array('error' => 'false' ,'message' => 'success' , 'projects' => $projects);
}

echo json_encode($msg4);

?>