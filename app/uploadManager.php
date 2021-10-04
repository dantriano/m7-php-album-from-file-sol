<?php
define("MAX", 5);
define("UPLOAD_FOLDER", "pictures/");
define("PICTURES_LIST", "pictures/list.txt");

class UploadError extends Exception
{
}
// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["picture"])) {
    $file_uploaded = uploadPicture();
    if ($file_uploaded) addPictureToFile($file_uploaded);
    header("Location: index.php?upload=success");
}
function addPictureToFile($file_uploaded)
{
    try {
        $title = $_POST["title"];
        $fp = fopen(PICTURES_LIST, 'a'); //opens file in append mode  
        fwrite($fp,  "\n" . $title . '###' . $file_uploaded);
        fclose($fp);
    } catch (Exception $e) {
        header('Location: index.php?upload=error&msg=' . urlencode($e->getMessage()));
        die();
    }
}
function uploadPicture()
{
    try {
        // Check if file was uploaded without errors
        if ($_FILES["picture"]["error"] != 0)
            throw new UploadError("Error: " . $_FILES["picture"]["error"]);

        $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
        $filename = $_FILES["picture"]["name"];
        $filetype = $_FILES["picture"]["type"];
        $filesize = $_FILES["picture"]["size"];

        // Verify file extension
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if (!array_key_exists($ext, $allowed))
            throw new UploadError("Error: Please select a valid file format.");

        // Verify file size - 5MB maximum
        $maxsize = MAX * 1024 * 1024;
        if ($filesize > $maxsize)
            throw new UploadError("Error: File size is larger than the allowed limit.");

        // Verify MYME type of the file
        if (!in_array($filetype, $allowed))
            throw new UploadError("Error: There was a problem uploading your file. Please try again.");

        // Check whether file exists before uploading it
        if (file_exists(UPLOAD_FOLDER . $filename))
            throw new UploadError("Error: " . $filename . " is already exists.");

        // IF NO errors, then move the picture to Folder
        move_uploaded_file($_FILES["picture"]["tmp_name"], UPLOAD_FOLDER . $filename);
        return UPLOAD_FOLDER . $filename;
        //echo "Your file was uploaded successfully.";

    } catch (UploadError $e) {
        header('Location: index.php?upload=error&msg=' . urlencode($e->getMessage()));
        die();
    } catch (Exception $e) {
        header('Location: index.php?upload=error&msg=' . urlencode($e->getMessage()));
        die();
    }
}
