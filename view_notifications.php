<?php

require_once "config.php";

$userid = $_REQUEST['userid'];

header('content-type: application/json');

$view_noti_query = "SELECT *  FROM notifications WHERE owner_id = $userid ORDER BY time DESC";
$result_view_notify = mysqli_query($con,$view_noti_query);

$notify_array = array();
if(mysqli_num_rows($result_view_notify)<1){
    $msg = array('error' => 'true' , 'message' => 'not success' , 'description' => 'NO notifications available');
}
else{
    
    $notify = "SELECT u.firstname,p.title,p.id,n.type from users u inner join notifications n on u.id = n.user_id join projects p on p.id = n.project_id AND n.owner_id = '$userid'"; 
    $result_notify = mysqli_query($con,$notify);
    if(mysqli_num_rows($result_notify)<1)
    {
         $msg = array('error' => 'true' , 'message' => 'not success' , 'description' => 'NO such record available');
    }
    else{
       while($row = mysqli_fetch_assoc($result_notify))
        {
            if($row['type'] == 'applied_student'){
                $flag = 1;
                $msg = $row['firstname']. " has applied for " .$row['title']; 
                $notification = array('error' => 'false' , 'message' => 'success' , 'notification' => $msg , 'project_id' => $row['id'] ,'project_title'=>$row['title'] , 'flag_value' => $flag);   
            }else
            {
                $flag = 0;
                $msg = $row['firstname']. " wants to mentor your project " .$row['title']; 
                 $notification = array('error' => 'false' , 'message' => 'success' , 'notification' => $msg , 'project_id' => $row['id'] , 'flag_value' => $flag);
            //   $msg = array('error' => 'false' , 'message' => 'success' , 'firstname' => $row['firstname'] , 'title' => $row['title'] );    
            }
            array_push($notify_array , $notification);
        }
    }
}
echo json_encode($notify_array);

?>