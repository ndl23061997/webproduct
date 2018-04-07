<html>
	<?php $this->load->view('admin/head')?>
	<body>
		<?php $this->load->view('admin/left')?>
		<div id="rightSide">
			<?php $this->load->view('admin/header')?>
			<?php $this->load->view($temp, $this->data);?>
		</div>
	</body>
</html>
