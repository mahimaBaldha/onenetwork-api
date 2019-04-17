<?php
require_once "config.php";

// $userid = $_REQUEST['userid'];
$projectid = $_REQUEST['projectid'];

$project_details = "SELECT * FROM projects WHERE id = $projectid";
$result = mysqli_query($con,$project_details);
$users_count;
// $names_array = array();
$applied_user_details = array();

if(mysqli_num_rows($result)<1){
    $response = array('error' => 'true' , 'message' => 'not success' , 'description' => 'could get project details');
}
else{
    $row = mysqli_fetch_assoc($result);
    $small_description = substr($row['description'],0,300);
    
    $creatorquery = "SELECT firstname,lastname FROM users WHERE id = ".$row['creator'];
    $mentorquery = "SELECT firstname,lastname FROM users WHERE id = ".$row['mentor'];
    $result2 = mysqli_query($con,$creatorquery);
    $row2 = mysqli_fetch_assoc($result2);
    $result3 = mysqli_query($con,$mentorquery);
    $row3 = mysqli_fetch_assoc($result3);
    
    $applied_users_count = "SELECT user_id FROM applied_users WHERE project_id = $projectid";
    $result3 = mysqli_query($con,$applied_users_count);
    $users_count = mysqli_num_rows($result3);
    if($users_count>0){
        while($row4 = mysqli_fetch_assoc($result3)){
            $name_of_applies_users = "SELECT firstname,lastname from users WHERE id = ".$row4['user_id'];
            $result4 = mysqli_query($con , $name_of_applies_users);
            $row5 = mysqli_fetch_assoc($result4);
            $res1 = array('applied_user_name' => $row5['firstname']." ".$row5['lastname'] , 'applied_student_id' => $row4['user_id']);
            array_push($applied_user_details , $res1);
        }
        $response = array('error' => 'false' , 'message' => 'success' , 'project_details' => $row,'small_description' => $small_description,'creator_name' => $row2['firstname']." ".$row2['lastname'],'mentor_name' => $row3['firstname']." ".$row3['lastname'],'applied_users_count'=>$users_count,'applied_user_names' => $applied_user_details);
    }
    else{
        $response = array('error' => 'false' , 'message' => 'success' , 'project_details' => $row,'small_description' => $small_description,'creator_name' => $row2['firstname']." ".$row2['lastname'],'mentor_name' => $row3['firstname']." ".$row3['lastname'],'applied_users_count'=>$users_count,'applied_user_names' => 'No one has applied for the project yet' );
    }
    // while($row4 = mysqli_fetch_assoc($result3)){
    //     // $users_count ++;
        
    //     $name_of_applies_users = "SELECT firstname,lastname from users WHERE id = ".$row4['user_id'];
    //     $myquery = mysqli_query($con , $name_of_applies_users);
    //     $row5 = mysqli_fetch_assoc($myquery);
    //     $res1 = array('applied_user' => $row5['firstname']." ".$row5['lastname']);
    //     array_push($names_array , $res1);
    // }
    // $response = array('error' => 'false' , 'message' => 'success' , 'project_details' => $row,'small_description' => $small_description,'creator_name' => $row2['firstname']." ".$row2['lastname'],'applied_users_count'=>$users_count,'applied_users_names' => $names_array);
}

header('content-type: application/json');
echo json_encode($response);
?>