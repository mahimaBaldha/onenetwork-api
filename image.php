<!--<html>-->
<!--    <body>-->
<!--        <form action="upload_file.php" method="POST" enctype="multipart/form-data">-->
<!--               Browse for File to Upload : <br>-->
<!--            <input name="file" type="file" id="file"><br>-->
<!--            <input type="submit" id="u_button" name="u_button" value="Upload the file">-->
<!--        </form>-->
<!--    </body>-->
<!--</html>-->

<!DOCTYPE html>
<html>
<body>

<form action="upload_file.php" enctype="multipart/form-data" method="POST">
    Select image to upload:
    <input type="file" name="file" id="file">
    <input type="submit" value="Upload Image" name="submit">
</form>

</body>
</html>