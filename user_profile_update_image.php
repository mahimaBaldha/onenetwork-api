<?php
    require_once "config.php";
    $userid = $_REQUEST['userid'];
    // $filename = $_FILES["file1"]["name"];
    $filetype = $_FILES["file1"]["type"];
    $response = array("filename" => $filename, "filetype" => $filetype);
    if(empty($_FILES["file1"]["name"]) || empty($userid)){
        $response = array("error" => "true", "message" => "not success", "description" => "userid or file cannot be empty");
    }
    else{
    
        $dest_path = $_SERVER['DOCUMENT_ROOT']."/images/user_pics/";
        //echo $dest_path;
        $file_result = "";
        if($_FILES['file1']['error'] > 0){
            
            $file_result .= "No File uploaded or invalid File ";
            $file_result .= "Error Code: ".$_FILES["file1"]["error"]."<br>";
        }
        else{
            // move_uploaded_file($_FILES["file"]["tmp_name"],
            // "./profile_images/" . $_FILES["file"]["name"]);
    
            move_uploaded_file($_FILES["file1"]["tmp_name"],
            $dest_path . $_FILES["file1"]["name"]);
            $file_result .= "File uploaded successfully";
        }
        // $old_name = "./profile_images/" . $_FILES["file"]["name"];
        
        $old_name = $dest_path . $_FILES["file1"]["name"];
        $extension = chop($_FILES["file1"]["type"],"/");
        if($filetype == "image/jpeg" || $filetype == "image/jpg" || $filetype == "image/png"){
         $extension_new = ".".ltrim($extension,"image/");   
        }
        else{
            $extension_new = ".".ltrim($extension,"application/octet-stream")."jpeg";    
        }
        
        $randomname = md5(rand());
        // $new_name = "./profile_images/" . $randomname .$extension_new;
        $new_name = $dest_path . $randomname .$extension_new;
        rename($old_name,$new_name);
        
        $img_path = $randomname.$extension_new;
        $update_image = "UPDATE users SET profile_pic = '$img_path' WHERE id = $userid";
        $result = mysqli_query($con,$update_image);
        if($result){
            $response = array("error" => "false", "message" => "success", "description" => "profile pic updated successfully");
        }
        else{
            $response = array("error" => "true", "message" => "not success", "description" => "profile pic not updated ".mysqli_error($con));
        }
    }
    
    header('content-type: application/json');
    echo json_encode($response);
?>