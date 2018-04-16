<!-- Form thêm mới quản trị viên  -->
<div class="wrapper">
	<!-- header của form -->
	<div class="widget">
		<!-- Form title -->
		<div class="title">
			<img src="<?php echo public_url('admin')?>/images/icons/dark/add.png"
				class="titleIcon">
			<h6>Thêm mới quản trị viên</h6>
		</div>
		<form class="form" id="form" action="" method="post" enctype="multipart/form-data">
			<fieldset>
				<div class="formRow">
					<label class="formLeft">Hình ảnh:<span class="req">*</span></label>
					<div class="formRight">
						<div class="left">
							<input type="file" id="image" name="image">
						</div>
						<div name="image_error" class="clear error"></div>
					</div>
					<div class="clear"></div>
				</div>

                <div class="formSubmit">
           			<input name = "submit" type="submit" value="Thêm mới" class="redB">
           			<input type="reset" value="Hủy bỏ" class="basic">
	           	</div>

			</fieldset>
		</form>
	</div>
</div>