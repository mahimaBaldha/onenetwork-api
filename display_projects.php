<?php

require_once "config.php";
header('content-type: application/json');

$userid = $_REQUEST['userid'];
$query = "SELECT * FROM projects WHERE deleted = 0 ORDER BY time DESC";
$result = mysqli_query($con,$query);

$projects = array();
if(mysqli_num_rows($result)<1){
    $msg = array('error' => 'true' , 'message' => 'not success' , 'description' => "NO projects available");
}
else
{
    while($row = mysqli_fetch_assoc($result))
    {
        $q2 = "SELECT firstname , lastname FROM users WHERE id = ".$row['creator'];
        $q2_exec = mysqli_query($con,$q2);
        
        $small_description = substr($row['description'],0,200);
        // $row['short_description'] = $small_description;
        //validation
        
        $q1 = "SELECT * FROM applied_users WHERE user_id = $userid AND project_id =".$row['id'] ;
        $q1_exec = mysqli_query($con , $q1);
        if(mysqli_num_rows($q1_exec) > 0)
        {
            // $response = array('error' => 'true' , 'message' => 'success' , 'description' => 'user has already applied for this project');
            $applied = 1;
        }else{
            $applied = 0;
        }
        
        if($row['mentor'] != NULL){
            $q3 = "SELECT firstname , lastname FROM users WHERE id = ".$row['mentor'];
            $q3_exec = mysqli_query($con,$q3);
                if($q3_exec){
                $q3_row = mysqli_fetch_assoc($q3_exec);
                $mentor_name = $q3_row['firstname']." ".$q3_row['lastname'];
                // $msg = array('error' => 'true' , 'message' => 'not success' , 'names' => );
                }else
                {
                     $msg = array('error' => 'true' , 'message' => 'not success' , 'description' => "NO names available");
                }
        }
        else
        {
           $mentor_name = 'no mentors assigned'; 
        }
        if($q2_exec){
            $q2_row = mysqli_fetch_assoc($q2_exec);
            // $msg = array('error' => 'true' , 'message' => 'not success' , 'names' => );
        }else
        {
             $msg = array('error' => 'true' , 'message' => 'not success' , 'description' => "NO names available");
        }
        
        $intereststr="";
        $interests_array = array();
        
        $interests = "SELECT i.name FROM interests i JOIN project_in_interests p ON i.id = p.interest_id WHERE p.project_id = ".$row['id'];
        
        $exec_interests = mysqli_query($con,$interests);
        if($exec_interests){
            while($row2 = mysqli_fetch_assoc($exec_interests)){
                $intereststr.= $row2['name'].",";
            }
        $intereststr = rtrim($intereststr,",");
        }
       // $msg1 = array('creator_name' => $q2_row['firstname']." ".$q2_row['lastname'] ,'project' => $row ,'interests' => $interests_array,"interest_str" => $intereststr);
        $msg1 = array('short_description' => $small_description,'applied' => $applied ,'creator_name' => $q2_row['firstname']." ".$q2_row['lastname'] ,'mentor_name' => $mentor_name ,'project' => $row ,'interest_str' => $intereststr);
        array_push($projects , $msg1);
    }
    $msg4 = array('error' => 'false' ,'message' => 'success' , 'projects' => $projects);
}
echo json_encode($msg4);

?>