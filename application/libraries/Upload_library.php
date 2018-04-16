<?php

class Upload_library
{
	var $CI = '';
	function __construct ()
	{
		$this->CI = &get_instance();
	}

	/*
	 * Upload file
	 * @$upload_path : đường dẫn upload
	 * @$file_name : Tên thẻ input muốn upload
	 */
	function upload ($upload_patch = '', $file_name = '')
	{
		$config = $this->config($upload_patch);
		$this->CI->load->library('upload', $config);
		// Kiểm tra xem việc upload có thành công hay không.
		if ($this->CI->upload->do_upload($file_name)) {
			// Upload thành công
			$data = $this->CI->upload->data();
		} else {
			// không upload thanh công
			$data = false;
		}
		return $data;
	}

	/*
	 * Cấu hình upload file
	 * @$upload_path : đường dẫn upload
	 * @$file_name : Tên thẻ input muốn upload
	 */
	function config ($upload_path = '')
	{
		// Cấu hình đường dẫn upload.
		$config['upload_path'] = $upload_path;
		// Loại file cho phép upload.
		$config['allowed_types'] = 'gif|jpg|png';
		// Dung lượng tối đa cho phép.
		$config['max_size'] = '10480';
		// chiều rộng tối đa.
		$config['max_width'] = '2000';
		// chiều cao tối đa
		$config['max_height'] = '2000';

		return $config;
	}

	/*
	 * Cấu hình upload nhiều file file
	 * @$upload_path : đường dẫn upload
	 * @$file_name : Tên thẻ input muốn upload
	 */
	function upload_file ($upload_path = '', $file_name = '')
	{
		// Lấy thông tin cấu hình upload
		$config = $this->config($upload_path);

		// Lưu biến môi trường khi thực hiện upload.
		$file = $_FILES['image_list'];
		$count = count($file['name']); // Lấy tổng số file cần upload.
		$image_list = array(); // Lưu tên các file ảnh upload thành công.
		for ($i = 0; $i <= $count-1; $i++)
		{
			$_FILES['userfile']['name'] = $file['name'][$i]; // Khai báo tên của file thứ i.
			$_FILES['userfile']['type'] = $file['type'][$i]; // Khai báo kiểu file của file thứ i.
			$_FILES['userfile']['tmp_name'] = $file['tmp_name'][$i]; // Khai báo đường dẫn tạm của file thứ i.
			$_FILES['userfile']['error'] = $file['error'][$i]; // Khai báo lỗi của file thứ i.
			$_FILES['userfile']['size'] = $file['size'][$i]; // Khai báo kích cỡ của file thứ i.

			// Load thư viện upload và cấu hình.
			$this->CI->load->library('upload', $config);
			// Thực hiện upload từng file.
			if($this->CI->upload->do_upload())
			{
				// Nếu upload thành công thì lưu toàn bộ dữ liệu.
				$data = $this->CI->upload->data();
				// In cấu trúc dữ liệu của các file.
				$image_list[] = $data['file_name'];
			}
		}
		return $image_list;
	}

	/*
	 * Xóa các ảnh đã upload trên CSDL
	 */

	function del_image($file_patch, $file_name)
	{
		$image_link = $file_patch.'/'.$file_name;
		if(file_exists($image_link))
		{
			unlink($image_link);
			return true;
		}
		else
		{
			return false;
		}
	}

	/*
	 * Xóa danh sách các ảnh.
	 */

	function del_image_list($file_patch, $file_list)
	{
		$image_list = json_decode($file_list);
		if(is_array($image_list))
		{
			foreach ($image_list as $image)
			{
				$image = $file_patch.'/'.$image;
				if(file_exists($image))
				{
					unlink($image);
				}
			};
		}
	}
}
