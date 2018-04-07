<?php

class MY_Controller extends CI_Controller
{
    function __construct ()
    {
        // Load lại hàm khởi tạo của CI_Controller
        parent::__construct();
        $controller = $this->uri->segment(1); // Lấy ra phân đoạn ci_url

        switch ($controller)
        {
            case 'admin':
                {
                    // Xử lí code cho trang admin tại đây
                    $this->load->helper('admin');
                    break;
                }
            default:
                {
                    // Xử lí các trang không phải trang login
                }
        }
    }

}