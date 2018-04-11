<?php

class Login extends MY_Controller
{

	function index ()
	{
		// Load thư viện quản kiểm tra lỗi trên form nhập liệu
		$this->load->library('form_validation');
		$this->load->helper('form');
		// kiểm tra lỗi khi có dữ liệu gửi lên
		if ($this->input->post()) {
			$this->form_validation->set_rules('login', 'login', 'callback_check_login');
		}
		if ($this->form_validation->run()) {
			$this->session->set_userdata('login', true);
			redirect(admin_url('home'));
		}

		$this->load->view('admin/login/index');
	}

	// Hàm kiểm tra thông tin đăng nhập
	function check_login ()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$password = md5($password);

		// Kiểm tra thông tin đăng nhập có tồn tại hay không
		$this->load->model('admin_model');
		$where = array(
				'username' => $username,
				'password' => $password
		);
		if ($this->admin_model->check_exists($where)) {
			return true;
		}
		$this->form_validation->set_message(__FUNCTION__, 'Thông tin đăng nhập không chính xác!');
		return false;
	}
}