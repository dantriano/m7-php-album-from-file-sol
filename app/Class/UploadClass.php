<?php
define("MAX_SIZE", 5); //Max Mb
define("UPLOAD_FOLDER", "pictures/");
define("PICTURES_LIST", "pictures/list.txt");

class Upload
{
    private $fileName = null;
    private $file = null;
    private $error = null;
    function __construct($fileName)
    {
        $this->fileName = $fileName;
        $this->uploadPicture();
    }
    function uploadPicture()
    {
        try {
            //Check if the folder exist is a valid picture and title
            //$_SERVER['DOCUMENT_ROOT'] return the folder of the server where is our APP
            if (!is_dir($_SERVER['DOCUMENT_ROOT'] . '/' . UPLOAD_FOLDER)) {
                if (!mkdir($_SERVER['DOCUMENT_ROOT'] . '/' . UPLOAD_FOLDER))
                    throw new UploadError("Error: No se ha podido crear el directorio");
            }
            if (!is_writable($_SERVER['DOCUMENT_ROOT'] . '/' . UPLOAD_FOLDER))
                throw new UploadError("Error: No puedes escribir en el directorio");

            // Check if file was uploaded without errors
            if ($_FILES[$this->fileName]["error"] != 0)
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
            $maxsize = MAX_SIZE * 1024 * 1024;
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
            $this->file = UPLOAD_FOLDER . $filename;
            //echo "Your file was uploaded successfully.";

        } catch (UploadError $e) {
            $this->error = $e->getMessage();
        } catch (Exception $e) {
            $this->error = $e->getMessage();
        }
    }

    function addPictureToFile()
    {
        try {
            $title = $_POST["title"];
            $fp = fopen(PICTURES_LIST, 'a'); //opens file in append mode  
            fwrite($fp,  "\n" . $title . '###' . $this->file);
            fclose($fp);
        } catch (Exception $e) {
            $this->error = $e->getMessage();
        }
    }
    function getError()
    {
        return $this->error;
    }
    function getFile()
    {
        return $this->file;
    }
}
