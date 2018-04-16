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
		// Kiểm tra có thực hiện lọc không
		//Lọc bằng id
		$id = $this->input->get('id');
		$id = intval($id);
		$input['where'] = array();
		if($id > 0)
		{
			$input['where']['id'] = $id;
		}
		// Lọc theo tên
		$name = $this->input->get('name');
		if($name)
		{
			$input['like'] = array('name' , $name);
		}
		//Lọc theo $catalog_id
		$catalog_id = $this->input->get('catalog');
		$catalog_id = intval($catalog_id);
		if($catalog_id > 0)
		{
			$input['where']['catalog_id'] = $catalog_id;
		}

		// Lấy ra danh sách các sản phẩm trong CSDL.
		$list = $this->product_model->get_list($input);
		$this->data['list'] = $list;
		// Lấy ra danh mục các catalogs
		$this->load->model('catalog_model');
		$input['where'] = array ('parent_id' => 0);
		$catalogs = $this->catalog_model->get_list($input);
		foreach ($catalogs as $row	) {
			$row->id = intval($row->id);
			$input['where'] = array('parent_id' => $row->id);
			$subs = $this->catalog_model->get_list($input);
			$row->subs = $subs;
		}
		$this->data['catalogs'] = $catalogs;


		// Load ra thông báo
		$message = $this->session->flashdata('message');
		$this->data['message'] = $message;
		// Layout master
		$this->data['temp'] = 'admin/product/index';
		$this->load->view('admin/main', $this->data);
	}

	/*
	 * Thêm mới sản phẩm
	 */

	function add ()
	{
		$input = array();
		// Load thư viện quản kiểm tra lỗi trên form nhập liệu
		$this->load->library('form_validation');
		$this->load->helper('form');

		// Nếu có dữ liệu gửi lên thì kiểm tra
		if($this->input->post ("submit"))
		{
			$this->form_validation->set_rules('name', 'Tên danh mục', 'required');
			$this->form_validation->set_rules('price', 'Giá sản phầm', 'required');
			$this->form_validation->set_rules('discount', 'Giảm giá', 'required|is_natural_no_zero|less_than[100]');

			// Nếu nhập liệu chính xác
			if($this->form_validation->run())
			{
				// Thêm vào CSDL
				$name = $this->input->post('name');
				$price = $this->input->post('price');
				$price = str_replace(',','',$price);
				$discount = $this->input->post('discount');
				$catalog_id = $this->input->post('catalog');
				$warranty = $this->input->post('warranty');
				$gifts = $this->input->post('sale');
				$site_title = $this->input->post('site_title');
				$meta_desc = $this->input->post('meta_desc');
				$meta_key = $this->input->post('meta_key');
				$content = $this->input->post('content');

				// Lấy tên file ảnh được upload.
				$this->load->library('upload_library');
				$upload_patch = './upload/product/';
				$upload_data = $this->upload_library->upload($upload_patch, 'image');
				$image_link = '';
				if($upload_data['file_name'])
				{
					$image_link = $upload_data['file_name'];
				}
				// Upload các file ảnh kèm theo
				$image_list = array();
				$upload_data = $this->upload_library->upload_file($upload_patch, 'image_list');
				$image_list = $upload_data;
				$image_list = json_encode($image_list);

				// Biến data để tạo trong csdl.
				$data = array (
						'name'       => $name,
						'image_link' => $image_link,
						'image_list' => $image_list,
 						'price'      => $price,
						'discount'   => $discount,
						'catalog_id' => $catalog_id,
						'warranty'   => $warranty,
						'gifts'      => $gifts,
						'site_title' => $site_title,
						'meta_desc'  => $meta_desc,
						'meta_key'   => $meta_key,
						'content'    => $content,
						'created'    => now(),
				);
				// tạo sản phẩm mới trong CSDL.
				if($this->product_model->create($data))
				{
					$this->session->set_flashdata('message', 'Thêm mới sản phẩm vào csdl thành công!');
				}
				else
				{
					$this->session->set_flashdata('message', 'Thêm thất bại! Vui lòng kiểm tra lại.');
				}
 				redirect(admin_url('product'));
			}

		}
		// Lấy ra danh sách các danh mục sản phẩm trong csdl.
		$this->load->model('catalog_model');
		$input['where'] = array ('parent_id' => 0);
		$catalogs = $this->catalog_model->get_list($input);
		foreach ($catalogs as $row	) {
			$row->id = intval($row->id);
			$input['where'] = array('parent_id' => $row->id);
			$subs = $this->catalog_model->get_list($input);
			$row->subs = $subs;
		}
		$this->data['catalogs'] = $catalogs;
		// Layout master
		$this->data['temp'] = 'admin/product/add';
		$this->load->view('admin/main', $this->data);
	}

	// Chỉnh sửa thông tin sản phẩm
	function edit ()
	{
		$input = array();
		// Load thư viện quản kiểm tra lỗi trên form nhập liệu
		$this->load->library('form_validation');
		$this->load->helper('form');

		$id = $this->uri->rsegment('3');
		$id = intval($id);
		$product = $this->product_model->get_info($id);
		if(empty($product))
		{
			$this->session->set_flashdata('message', 'Không tồn tại sản phẩm này');
			redirect(admin_url('product'));
		}
		else
		{
			$image_link_old = $product->image_link;
			$image_list_old = $product->image_list;
		}
		// Nếu có dữ liệu gửi lên thì kiểm tra
		if($this->input->post ("submit"))
		{

			$this->form_validation->set_rules('name', 'Tên danh mục', 'required');
			$this->form_validation->set_rules('price', 'Giá sản phầm', 'required');
			$this->form_validation->set_rules('discount', 'Giảm giá', 'required|is_natural_no_zero|less_than[100]');

			// Nếu nhập liệu chính xác
			if($this->form_validation->run())
			{
				// Thêm vào CSDL

				$name = $this->input->post('name');
				$price = $this->input->post('price');
				$price = str_replace(',','',$price);
				$discount = $this->input->post('discount');
				$catalog_id = $this->input->post('catalog');
				$warranty = $this->input->post('warranty');
				$gifts = $this->input->post('sale');
				$site_title = $this->input->post('site_title');
				$meta_desc = $this->input->post('meta_desc');
				$meta_key = $this->input->post('meta_key');
				$content = $this->input->post('content');

				// Upload file ảnh của sản phẩm.
				$this->load->library('upload_library');
				$upload_patch = './upload/product/';
				$upload_data = $this->upload_library->upload($upload_patch, 'image');
				$image_link = '';
				if($upload_data['file_name'])
				{
					$image_link = $upload_data['file_name'];
				}
				// Up load các file ảnh kèm theo.
				$image_list = array();
				$upload_data = $this->upload_library->upload_file($upload_patch, 'image_list');
				$image_list = $upload_data;

				// Biến data để tạo trong csdl.
				$data = array (
						'name'       => $name,
						'price'      => $price,
						'discount'   => $discount,
						'catalog_id' => $catalog_id,
						'warranty'   => $warranty,
						'gifts'      => $gifts,
						'site_title' => $site_title,
						'meta_desc'  => $meta_desc,
						'meta_key'   => $meta_key,
						'content'    => $content,
						'created'    => now(),
				);
				// Cập nhật ảnh của sản phẩm.
				if ($image_link != '') {
					$data = array('image_link' => $image_link);
					// Xóa file ảnh cũ.
					$this->upload_library->del_image('./upload/product', $image_link_old);
				}
				// Cập nhật image list.
				if (!empty($image_list))
				{
					$image_list = json_encode($image_list);
					$data['image_list'] = $image_list;
					// Xóa các ảnh kèm theo.
					$this->upload_library->del_image_list('./upload/product', $image_list_old);
				}

				// Cập nhật thông tin sản phẩm trong CSDL.
				if($this->product_model->update($id,$data))
				{
					$this->session->set_flashdata('message', 'Thêm mới sản phẩm vào csdl thành công!');
				}
				else
				{
					$this->session->set_flashdata('message', 'Thêm thất bại! Vui lòng kiểm tra lại.');
				}
				redirect(admin_url('product'));
			}

		}

		// Lấy ra danh sách các danh mục sản phẩm trong csdl.
		$this->load->model('catalog_model');
		$input['where'] = array ('parent_id' => 0);
		$catalogs = $this->catalog_model->get_list($input);
		foreach ($catalogs as $row	) {
			$row->id = intval($row->id);
			$input['where'] = array('parent_id' => $row->id);
			$subs = $this->catalog_model->get_list($input);
			$row->subs = $subs;
		}
		$this->data['catalogs'] = $catalogs;
		// Layout master
		$this->data['product'] = $product;
		$this->data['temp'] = 'admin/product/edit';
		$this->load->view('admin/main', $this->data);
	}

	function del()
	{
		// Load ra thư viện upload.
		$this->load->library('upload_library');
		// Lấy thông tin sản phẩm cần xóa.
		$id = $this->uri->rsegment('3');
		$id = intval($id);
		$product = $this->product_model->get_info($id);
		if(!$product)
		{
			$this->session->set_flashdata('message', 'Không tồn tại sản phẩm này');
			redirect(admin_url('product'));
		}
		if($this->product_model->delete($id))
		{
			$this->session->set_flashdata('message', 'Xóa thành công!');
		}
		else
		{
			$this->session->set_flashdata('message', 'Lỗi! chưa xóa được');
		}
		// Xóa các ảnh của sản phẩm.
		$this->upload_library->del_image('./upload/product/', $product->image_link);
		// Xóa các ảnh kèm theo.
		$this->upload_library->del_image_list('./upload/product/',$product->image_list);
		redirect(admin_url('product'));
	}
}
?>
