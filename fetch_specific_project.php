<?php

require_once "config.php";
header('content-type: application/json');

$pid = $_REQUEST['projectid'];
$query = "SELECT * FROM projects WHERE id = $pid AND deleted = 0";
$result = mysqli_query($con,$query);

$projects = array();
if(mysqli_num_rows($result)<1){
    $msg = array('error' => 'true' , 'message' => 'not success' , 'description' => "NO projects available");
}
else
{
    $row = mysqli_fetch_assoc($result);
    $msg = array('error' => 'false' , 'message' => 'success' , 'project_detail' => $row );
}    
echo json_encode($msg);

?>