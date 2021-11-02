<?php
include('Class/UploadClass.php');
define("PICTURE_NAME", "picture");
define("PICTURE_TITLE", "title");
define('TITLE_ERROR', "Please write a title for the picture");


// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES[PICTURE_NAME])) {
    //check if title is in the form
    if (empty($_POST[PICTURE_TITLE])) {
        header('Location: index.php?upload=error&msg=' . urlencode(TITLE_ERROR));
        return;
    }
    $upload = new Upload(PICTURE_NAME);
    //If File is uploaded correcty, we added to our file
    if ($upload->getFile() != null)
        $upload->addPictureToFile();
    // Any error redirect with error message
    if ($upload->getError() != null)
        header('Location: index.php?upload=error&msg=' . urlencode($upload->getError()));
    else header("Location: index.php?upload=success");
}
