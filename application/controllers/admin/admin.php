<?php

class admin extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('admin_model');
    }

    function index()
    {
        $input = array();
        // Lấy toàn bộ danh sách admin.
        $list = $this->admin_model->get_list($input);
        $this->data['list'] = $list;

        // Lấy tổng số admin
        $total = $this->admin_model->get_total($input);
        $this->data['total'] = $total;

        // Load ra thông báo
        $message = $this->session->flashdata('message');
        $this->data['message'] = $message;
        // Layout master
        $this->data['temp'] = 'admin/admin/index';
        $this->load->view('admin/main', $this->data);
    }
    // Kiểm tra xem username đã tồn tại chưa
    function check_username ()
    {
        $username = $this->input->post('username');
        $where = array('username' => $username);
        if($this->admin_model->check_exists($where))
        {
            //Kiểm tra xem username đã tồn tại hay chưa.
            $this->form_validation->set_message(__FUNCTION__, 'Tài khoản đã tồn tại');
            return false;
        }
        return true;
    }

    function add()
    {
        $input = array();
        // Load thư viện quản kiểm tra lỗi trên form nhập liệu
        $this->load->library('form_validation');
        $this->load->helper('form');

        // Nếu có dữ liệu gửi lên thì kiểm tra
        if($this->input->post ())
        {
            $this->form_validation->set_rules('name', 'Tên', 'required|min_length[8]|required');
            $this->form_validation->set_rules('username', 'Tên đăng nhập', 'required|min_length[8]|callback_check_username');
            $this->form_validation->set_rules('password', 'Mật khẩu', 'required|min_length[8]');
            $this->form_validation->set_rules('re_password', 'Nhập lại mật khẩu', 'required|matches[password]');

            // Nếu nhập liệu chính xác
            if($this->form_validation->run())
            {
                // Thêm vào CSDL
                $name = $this->input->post('name'); // biến name được gửi lên nếu không có lỗi
                $username = $this->input->post('username'); // biến username được gửi lên nếu không có lỗi
                $password = $this->input->post('password'); // biến password được gửi lên nếu không có lỗi

                $data = array (
                    'name' => $name,
                    'username' => $username,
                    'password' => md5($password) // Mã hóa password để bảo mật.
                );

                if($this->admin_model->create($data))
                {
                    $this->session->set_flashdata('message', 'Thêm mới dữ liệu thành công!');
                }
                else
                {
                    $this->session->set_flashdata('message', 'Thêm thất bại! Vui lòng kiểm tra lại.');
                }
                redirect(admin_url('admin'));
            }

        }

        // Layout master
        $this->data['temp'] = 'admin/admin/add';
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
        $info = $this->admin_model->get_info($id);
        if(!$info)
        {
            $this->session->set_flashdata('message', 'Không tồn tại quản trị viên!');
            redirect(admin_url('admin'));
        }

        if($this->input->post ())
        {
            $this->form_validation->set_rules('name', 'Tên', 'required|min_length[8]|required');
            // Nếu username giống username ban đầu thì không cần check validation nữa.
            if ($this->input->post('username') <> $info->username)
            {
                $this->form_validation->set_rules('username', 'Tên đăng nhập', 'required|min_length[8]|callback_check_username');
            }
            $password = $this->input->post('password');
            $re_password = $this->input->post('re_password');
            // Nếu password hoặc re_password bị thay đổi thì mới kiểm tra điều kiện.
            if($password <> '' || $re_password)
            {
                $this->form_validation->set_rules('password', 'Mật khẩu', 'required|min_length[8]');
                $this->form_validation->set_rules('re_password', 'Nhập lại mật khẩu', 'required|matches[password]');
            }

            // Nếu nhập liệu chính xác
            if($this->form_validation->run())
            {
                // Cập nhật vào CSDL
                $name = $this->input->post('name'); // biến name được update nếu không có lỗi
                $username = $this->input->post('username'); // biến username được update nếu không có lỗi

                $data = array (
                        'name' => $name,
                        'username' => $username,
                );
                // Nếu password bị thay đổi thì mới update
                if ($password)
                {
                    $data['password'] = md5($password); // Nếu password được thay đổi.
                }

                if($this->admin_model->update($id,$data))
                {
                    $this->session->set_flashdata('message', 'Cập nhật dữ liệu thành công!');
                }
                else
                {
                    $this->session->set_flashdata('message', 'Cập nhật thất bại! Vui lòng kiểm tra lại.');
                }
                redirect(admin_url('admin'));
            }

        }
        // Layout master
        $this->data['info'] = $info;
        $this->data['temp'] = 'admin/admin/edit';
        $this->load->view('admin/main', $this->data);
    }

    function delete ()
    {
        // Lấy id của quản trị viên cần chỉnh sửa
        $id = $this->uri->rsegment('3');
        $id = intval($id);

        // Lấy thông tin của admin
        $info = $this->admin_model->get_info($id);
        if(!$info)
        {
            $this->session->set_flashdata('message', 'Không tồn tại quản trị viên!');
            redirect(admin_url('admin'));
        }

        if($this->admin_model->delete($id,$data))
        {
            $this->session->set_flashdata('message', 'Xóa tài khoản thành công!');
        }
        else
        {
            $this->session->set_flashdata('message', 'Xóa tài khoản thất bại! Vui lòng kiểm tra lại.');
        }
        redirect(admin_url('admin'));
    }

    /*
     * Đăng xuất
     */
    function log_out ()
    {
    	if($this->session->userdata('login'))
    	{
    		$this->session->unset_userdata('login');
    	}
    	redirect(admin_url('login'));
    }
}