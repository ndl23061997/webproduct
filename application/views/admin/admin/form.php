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
                	<label class="formLeft" for="name">Tên:<span class="req">*</span></label>
                	<div class="formRight">
                		<span class="oneTwo"><input name="name" id="param_name" value="<?php echo set_value('name')?>" _autocheck="true" type="text"></span>
                		<span name="name_autocheck" class="autocheck"></span>
                		<div name="name_error" class="clear error"><?php echo form_error('name');?></div>
                	</div>
                	<div class="clear"></div>
                </div>

                <div class="formRow">
                	<label class="formLeft" for="param_username">Username:<span class="req">*</span></label>
                	<div class="formRight">
                		<span class="oneTwo"><input name="username" id="param_username" value ="<?php echo set_value('username')?>" _autocheck="true"  type="text"></span>
                		<span name="name_autocheck" class="autocheck"></span>
                		<div name="name_error" class="clear error"><?php echo form_error('username');?></div>
                	</div>
                	<div class="clear"></div>
                </div>

                <div class="formRow">
                	<label class="formLeft" for="param_password">Password:<span class="req">*</span></label>
                	<div class="formRight">
                		<span class="oneTwo"><input name="password" id="param_password" _autocheck="true" type="password"></span>
                		<span name="name_autocheck" class="autocheck"></span>
                		<div name="name_error" class="clear error"><?php echo form_error('password');?></div>
                	</div>
                	<div class="clear"></div>
                </div>

                <div class="formRow">
                	<label class="formLeft" for="param_re_password">Re-Password:<span class="req">*</span></label>
                	<div class="formRight">
                		<span class="oneTwo"><input name="re_password" id="param_re_password" _autocheck="true" type="password"></span>
                		<span name="name_autocheck" class="autocheck"></span>
                		<div name="name_error" class="clear error"><?php echo form_error('re_password');?></div>
                	</div>
                	<div class="clear"></div>
                </div>

                <div class="formSubmit">
           			<input type="submit" value="Thêm mới" class="redB">
           			<input type="reset" value="Hủy bỏ" class="basic">
	           	</div>

			</fieldset>
		</form>
	</div>
</div>