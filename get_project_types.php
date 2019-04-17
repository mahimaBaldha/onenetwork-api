<?php
    require_once "config.php";
    $get_project_types = "SELECT * FROM project_types";
    $result = mysqli_query($con,$get_project_types);
    if(mysqli_num_rows($result)<1){
        $response = array("error" => "true", "message" => "not success", "description" => "No project types found");
    }
    else{
        $count_of_project_types = mysqli_num_rows($result);
        $project_types = array();
        while($row = mysqli_fetch_assoc($result)){
            array_push($project_types,$row);
        }
        $response = array("error" => "false", "message" => "success", "project_types" => $project_types, "count_of_project_types" => $count_of_project_types);
    }
    header('content-type: application/json');
    echo json_encode($response);
?>