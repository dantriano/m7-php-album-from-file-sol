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
                $line = fgets($file);
                $pic_info = explode("###", $line);
                if ($pic_info[0] && $pic_info[1]) {
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
}
