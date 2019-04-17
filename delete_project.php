<?php

require_once "config.php";

$projectid = $_REQUEST['projectid'];
$delete_project = "UPDATE projects SET deleted = 1 WHERE id = $projectid";
$result = mysqli_query($con,$delete_project);
if($result){
    $response = array('error' => 'false' , 'message' => 'success', 'description' => 'project deleted successfully');
}
else{
    $response = array('error' => 'false' , 'message' => 'success' ,'description' => 'could not delete project');
}


// $delete1 = "DELETE FROM project_members WHERE project_id = ".$projectid;
//     $del_exec1 = mysqli_query($con , $delete1);
    
//     if($del_exec1)
//     {
//         $response = array('error' => 'false' , 'message' => 'deleted from project_members');
//     }else{
//         $response = array('error' => 'true' , 'message' => 'not deleted from members');
//     }

// $delete2 = "DELETE FROM notifications WHERE project_id = ".$projectid;
//     $del_exec2 = mysqli_query($con , $delete2);
    
//     if($del_exec2)
//     {
//         $response = array('error' => 'false' , 'message' => 'deleted from notifications');
//     }else{
//         $response = array('error' => 'true' , 'message' => 'not deleted from notifications');
//     }

// $delete3 = "DELETE FROM applied_users WHERE project_id = ".$projectid;
//     $del_exec3 = mysqli_query($con , $delete3);
    
//     if($del_exec3)
//     {
//         $response = array('error' => 'false' , 'message' => 'deleted from applied_users');
//     }else{
//         $response = array('error' => 'true' , 'message' => 'not deleted from applied_users');
//     }

// $delete4 = "DELETE FROM projects WHERE id = ".$projectid;
//     $del_exec4 = mysqli_query($con , $delete4);
    
//     if($del_exec4)
//     {
//         $response = array('error' => 'false' , 'message' => 'deleted from project');
//     }else{
//         $response = array('error' => 'true' , 'message' => 'not deleted from project');
//     }
    
header('content-type: application/json');
echo json_encode($response);
?>