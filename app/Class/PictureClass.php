<?php

class Picture
{
    private $_title = '';
    private $_fileName = '';

    function __construct($title, $fileName)
    {
        $this->_title = $title;
        $this->_fileName = $fileName;
    }
    public function title(){
        return $this->_title;
    }
    public function fileName(){
        return $this->_fileName;
    }
}
