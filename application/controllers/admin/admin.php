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
                    echo 'Thêm thành công';
                }
                else
                {
                    echo 'Không thêm được';
                }
            }

        }

        // Layout master
        $this->data['temp'] = 'admin/admin/add';
        $this->load->view('admin/main', $this->data);
    }
}