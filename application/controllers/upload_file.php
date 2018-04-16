<?php

	class upload_file extends CI_Controller {
		function __construct()
		{
			parent:: __construct();
			$this->load->helper('admin_helper');
		}
		function index()
		{

			$this->load->helper('form');
			$input = array();
			if($this->input->post("submit"))
			{
				$this->load->library('upload_library');
				$upload_patch = './upload/user';
				$upload_data = $this->upload_library->upload($upload_patch, 'image');
				$image_link = '';
				pre($upload_data);

			}

			$this->load->view('upload.php');

		}

		function upload()
		{
			$this->load->helper('form');
			$input = array();
			if($this->input->post("submit"))
			{
				$this->load->library('upload_library');
				$upload_patch = './upload/user';
				$image_list = array();
				$upload_data = $this->upload_library->upload_file($upload_patch, 'image_list');
				$image_list = $upload_data;
				//$image_list = json_encode($image_list);
				pre($image_list);
			}

			$this->load->view('upload_file.php');
		}
	}
