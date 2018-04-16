  <?php

class catalog extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('catalog_model');
    }

    function index()
    {
        $input = array();
        // Lấy toàn bộ danh sách các danh mục sản phẩm.
        $list = $this->catalog_model->get_list($input);
        $this->data['list'] = $list;

        // Lấy tổng số danh mục sản phẩm.
        $total = $this->catalog_model->get_total($input);
        $this->data['total'] = $total;

        // Load ra thông báo
        $message = $this->session->flashdata('message');
        $this->data['message'] = $message;
        // Layout master
        $this->data['temp'] = 'admin/catalog/index';
        $this->load->view('admin/main', $this->data);
    }

    function add ()
    {
    	$input = array();
    	// Load thư viện quản kiểm tra lỗi trên form nhập liệu
    	$this->load->library('form_validation');
    	$this->load->helper('form');

    	// Nếu có dữ liệu gửi lên thì kiểm tra
    	if($this->input->post ())
    	{
    		$this->form_validation->set_rules('name', 'Tên danh mục', 'required');

    		// Nếu nhập liệu chính xác
    		if($this->form_validation->run())
    		{
    			// Thêm vào CSDL
    			$name = $this->input->post('name'); // biến name được gửi lên nếu không có lỗi
    			$parent_id = $this->input->post('parent_id');
    			$sort_order = $this->input->post('sort_order');

    			$data = array (
    					'name' => $name,
    					'parent_id' => $parent_id,
    					'sort_order' => $sort_order // Mã hóa password để bảo mật.
    			);

    			if($this->catalog_model->create($data))
    			{
    				$this->session->set_flashdata('message', 'Thêm mới dữ liệu thành công!');
    			}
    			else
    			{
    				$this->session->set_flashdata('message', 'Thêm thất bại! Vui lòng kiểm tra lại.');
    			}
    			redirect(admin_url('catalog'));
    		}

    	}

    	// Lấy ra danh sách các danh mục cha
    	$input['where'] = array('parent_id' => 0);
    	$list = $this->catalog_model->get_list($input);
    	$this->data['list'] = $list;

    	// Layout master
    	$this->data['temp'] = 'admin/catalog/add';
    	$this->load->view('admin/main', $this->data);
    }

    function edit ()
    {
    	// Load thư viện quản kiểm tra lỗi trên form nhập liệu
    	$this->load->library('form_validation');
    	$this->load->helper('form');

    	// Lấy id của quản trị viên cần chỉnh sửa
    	$id = $this->uri->rsegment('3');
    	$id = intval($id);

    	// Lấy thông tin của admin
    	$info = $this->catalog_model->get_info($id);
    	if(!$info)
    	{
    		$this->session->set_flashdata('message', 'Không tồn tại danh mục sản phẩm này!');
    		redirect(admin_url('catalog'));
    	}

    	if($this->input->post ())
    	{
    		$this->form_validation->set_rules('name', 'Tên danh mục', 'required');
    		$parent_id = $this->input->post('parent_id');
    		$sort_order = $this->input->post('sort_order');

    		// Nếu nhập liệu chính xác
    		if($this->form_validation->run())
    		{
    			// Cập nhật vào CSDL
    			$name = $this->input->post('name'); // biến name được update nếu không có lỗi
    			$data = array (
    					'name' => $name,
    					'parent_id' => $parent_id,
    					'sort_order' => $sort_order
    			);

    			if($this->catalog_model->update($id,$data))
    			{
    				$this->session->set_flashdata('message', 'Cập nhật dữ liệu thành công!');
    			}
    			else
    			{
    				$this->session->set_flashdata('message', 'Cập nhật thất bại! Vui lòng kiểm tra lại.');
    			}
    			redirect(admin_url('catalog'));
    		}

    	}

    	// Lấy ra danh sách các danh mục cha
    	$input['where'] = array('parent_id' => 0);
    	$list = $this->catalog_model->get_list($input);
    	$this->data['list'] = $list;

    	// Layout master
    	$this->data['info'] = $info;
    	$this->data['temp'] = 'admin/catalog/edit';
    	$this->load->view('admin/main', $this->data);
    }

    function delete()
    {
    	// Load thư viện quản kiểm tra lỗi trên form nhập liệu
    	$this->load->library('form_validation');
    	$this->load->helper('form');

    	// Lấy ra id của danh mục cần xóa
    	$id = $this->uri->rsegment('3');
    	$id = intval($id);

    	// Lấy ra thông tin của danh mục sau đó kiểm tra xem quản trị viên có tồn tại hay không.
    	$info = $this->catalog_model->get_info($id);
		if (!$info)
		{
			$this->session->set_flashdata('message', 'Không tồn tại danh mục này');
			redirect(admin_url('catalog'));
		}
		// thực hiện xóa danh mục sản phẩm.
		if ($this->catalog_model->delete($id))
		{
			$this->session->set_flashdata('message', 'Xóa thành công');
		}
		else
		{
			$this->sesseon->set_flashdata('message', 'Xóa thất bại! Vui lòng kiểm tra lại');
		}
		redirect(admin_url('catalog'));
    }
}