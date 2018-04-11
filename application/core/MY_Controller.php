<?php

class MY_Controller extends CI_Controller
{

	function __construct ()
	{
		// Load lại hàm khởi tạo của CI_Controller
		parent::__construct();
		$controller = $this->uri->segment(1); // Lấy ra phân đoạn ci_url

		switch ($controller) {
			case 'admin':
			{
				// Xử lí code cho trang admin tại đây
				$this->load->helper('admin');
				$this->_check_login();
				break;
			}
			default:
			{
					// Xử lí các trang không phải trang login
			}
		}
	}

	function _check_login ()
	{
		$controller = $this->uri->rsegment('1');
		$controller = strtolower($controller);

		$login = $this->session->userdata('login');

		// Kiểm tra nếu người dùng chưa đăng nhập mà truy cập 1 controller khác.
		if(!$login && $controller != 'login')
		{
			redirect(admin_url('login'));
		}

		// Kiểm tra nếu người dùng đã đăng nhập mà truy cập controller login.
		if($login && $controller == 'login')
		{
			redirect(admin_url('home'));
		}
	}


}