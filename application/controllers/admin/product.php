<?php

class product extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('product_model');
	}

	function index()
	{
		// Lấy tổng các sản phẩm.
		$total_row = $this->product_model->get_total();
		$this->data['total_row'] = $total_row;

		// Load thư viện phân trang
		$this->load->library('pagination');
		$config = array();
		$config['total_rows'] = $total_row; // Tổng số sản phẩm trên trang.
		$config['base_url'] = admin_url('product/index'); // Link hiển thị danh sách phân trang.
		$config['per_page'] = 5; // Số sản phẩm tối đa hiển thị trên trang.
		$config['uri_segment'] = 4; // Phân đoạn hiển thị ra số trang trên url
		$config['next_link'] = 'Trang kế tiếp';
		$config['prev_link'] = 'Trang trước';
		// Khởi tạo các cấu hình phân trang.
		$this->pagination->initialize($config);

		$segment = $this->uri->segment(4);
		$segment = intval($segment);

		$input = array();
		$input['limit'] = array($config['per_page'], $segment);

		// Lấy ra danh sách các sản phẩm trong CSDL.
		$list = $this->product_model->get_list($input);
		$this->data['list'] = $list;

		// Load ra thông báo
		$message = $this->session->flashdata('message');
		$this->data['message'] = $message;
		// Layout master
		$this->data['temp'] = 'admin/product/index';
		$this->load->view('admin/main', $this->data);
	}

}
?>