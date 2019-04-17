<?php
    $userid = $_REQUEST['userid'];
    if(empty($_FILES["file"]["name"]) || empty($userid)){
        $response = array("error" => "true", "message" => "not success", "description" => "userid or file cannot be empty");
    }
    else{
        $filetype = $_FILES['file']['type'];
    
            $extension = ltrim($filetype,"application");
            $extension = ltrim($extension,"/");
            // echo "<br>".$extension;
            $dest_path = $_SERVER['DOCUMENT_ROOT']."/user_resumes/";
            
            require_once "config.php";
            // $userid = $_REQUEST['userid'];
            
            $file_result = "";
            if($_FILES['file']['error'] > 0){
                
                $file_result .= "No File uploaded or invalid File ";
                $file_result .= "Error Code: ".$_FILES["file"]["error"]."<br>";
            }
            else{
                // move_uploaded_file($_FILES["file"]["tmp_name"],
                // "./resumes/" . $_FILES["file"]["name"]);
                
                move_uploaded_file($_FILES["file"]["tmp_name"],
                $dest_path . $_FILES["file"]["name"]);
        
                $file_result .= "File uploaded successfully";
            }
            $old_name = $dest_path . $_FILES["file"]["name"];
            // $extension = chop($_FILES["file"]["type"],"/");
            $extension = ".".$extension;
            // $extension_new = ".".ltrim($extension,"application/");
            $randomname = md5(rand());
            $new_name = $dest_path . $randomname .$extension;
            rename($old_name,$new_name);
            
            $img_path = $randomname.$extension;
            $update_resume = "UPDATE users SET resume = '$img_path' WHERE id = $userid";
            $result = mysqli_query($con,$update_resume);
            if($result){
                $response = array("error" => "false", "message" => "success", "description" => "resume updated successfully");
            }
            else{
                $response = array("error" => "true", "message" => "not success", "description" => "resume not updated ".mysqli_error($con));
            }
    }
    header('content-type: application/json');
    echo json_encode($response);
?>