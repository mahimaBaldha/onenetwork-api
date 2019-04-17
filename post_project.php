<?php
require_once "config.php";
header('content-type: application/json');

$title = $_REQUEST['title'];
$description = $_REQUEST['description'];
$userid = $_REQUEST['userid'];
$project_type = $_REQUEST['project_type'];
$arr = $_REQUEST["arr"];


$creator = $userid;
$time = time();
$status = 1;

$role = "SELECT role FROM users WHERE id = ".$userid;

$result = mysqli_query($con ,$role);

$row = mysqli_fetch_assoc($result);

if($row['role'] == 1){
    $mentor = strval($userid);
    
$insertproject = "INSERT INTO projects (title , description , mentor, project_type , creator , time , status) VALUES ('$title','$description',$mentor,$project_type,'$creator',$time,$status)";
}
else{
$insertproject = "INSERT INTO projects (title , description , project_type , creator , time , status) VALUES ('$title','$description',$project_type,'$creator',$time,$status)";
}
$result2 = mysqli_query($con,$insertproject);

$query = "SELECT id FROM projects WHERE creator = $userid ORDER BY time DESC LIMIT 1";
$qxec_query = mysqli_query($con,$query);

$result1 = mysqli_fetch_assoc($qxec_query);
$projectid = $result1['id'];

if($result){
    if($result2){
        foreach ($arr as $a) {
        $sql = "INSERT INTO project_in_interests (project_id,interest_id) VALUES ($projectid,$a)";
        $qsql = mysqli_query($con,$sql);
            if($qsql){
                $m1 = array('error' => 'false' ,'message' => 'success', 'description' => 'project added successfully');
            }else{
                $sqlerror = mysqli_error($con);
                $m1 = array('error' => 'true' ,'message' => 'not success', 'description' => 'project not added' ,'sqlerror' => $sqlerror);
            }
        }
    }
    else
    {
        $sqlerror = mysqli_error($con);
        $m1 = array('error' => 'true' ,'message' => 'not success', 'description' => 'project not added' ,'sqlerror' => $sqlerror);
    }
}



echo json_encode($m1);

?>