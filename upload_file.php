<?php

require_once "config.php";
$userid = $_REQUEST['userid'];


$file_result = "";
    if($_FILES['file']['error'] > 0){
        die("helllo");
        $file_result .= "No File uploaded or invalid File ";
        $file_result .= "Error Code: ".$_FILES["file"]["error"]."<br>";
    }
    else{
        // $filename = rename("./profile_images/".$_FILES["file"]["name"],"20182000");
        // $filename = 201812000;
        // $file_result .=
        // "Upload:" . $_FILES["file"]["name"]."<br>".
        // "Type:" . $_FILES["file"]["type"] . "<br>" .
        // "Size:" . ($_FILES["file"]["size"]/1024) . " Kb<br>" .
        // "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";

        move_uploaded_file($_FILES["file"]["tmp_name"],
        "./profile_images/" . $_FILES["file"]["name"]);

        $file_result .= "File uploaded successfully";
        
        
    }
    $old_name = "./profile_images/" . $_FILES["file"]["name"];
    $extension = chop($_FILES["file"]["type"],"/");
    $extension_new = ".".ltrim($extension,"image/");
    $new_name = "./profile_images/" . $userid .$extension_new;
    rename($old_name,$new_name);
    
    $img_path = $userid.$extension_new;
    $update_image = "UPDATE users SET profile_pic = '$img_path' WHERE id = $userid";
    $result = mysqli_query($con,$update_image);
    if($result){
        $response = array("error" => "false", "message" => "success", "description" => "profile pic updated successfully");
    }
    else{
        $response = array("error" => "true", "message" => "not success", "description" => "profile pic not updated ".mysqli_error($con));
    }
    
    
    // echo $extension_new."<br>";
    
    // echo $file_result;
    header('content-type: application/json');
  echo json_encode($response);
    
?>