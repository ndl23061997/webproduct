<?php
	class home extends MY_Controller
	{
		function __construct()
		{
			parent::__construct();
			$this->load->model('admin_model');
		}

		function index()
		{

			// Layout master
			$this->data['temp'] = 'admin/home/home';
			$this->load->view('admin/main', $this->data);
		}
	}
?>