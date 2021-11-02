<?php
include('PictureClass.php');

class Gallery
{
    private $_fileName = '';
    private $_gallery = [];

    function __construct($fileName)
    {
        $this->_fileName = $fileName;
        $this->loadGallery();
    }
    public function loadGallery()
    {
        if (file_exists($this->_fileName)) {
            $file = fopen($this->_fileName, "r");
            while (!feof($file)) {
                //We use trim to crean the string from empty spaces
                //$_SERVER['DOCUMENT_ROOT'] return the folder of the server where is our APP
                $line = trim(fgets($file));
                $pic_info = explode("###", $line);
                $image_path = $_SERVER['DOCUMENT_ROOT'] . '/' . $pic_info[1];

                //Check if the is a valid picture and title
                if ($pic_info[0] && $this->is_image($image_path)) {
                    $picture = new Picture($pic_info[0], $pic_info[1]);
                    array_push($this->_gallery, $picture);
                }
            }
            fclose($file);
        }
    }
    public function getGallery()
    {
        return $this->_gallery;
    }
    public function is_image($path)
    {
        $info = getimagesize($path);
        $image_type = $info[2];

        if (in_array($image_type, array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_BMP))) {
            return true;
        }
        return false;
    }
}
