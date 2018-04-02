<?php

class MY_Controller extends CI_Controller 
{
    function __construct () 
    {
        // Load lại hàm khởi tạo của CI_Controller
        parrent::__construct();
        $controller = $this->uri->segment(1); // Lấy ra phân đoạn ci_url
        echo $controller;
    }

}