<!-- Form thêm mới quản trị viên  -->
<div class="wrapper">
	<!-- header của form -->
	<div class="widget">
		<!-- Form title -->
		<div class="title">
			<img src="<?php echo public_url('admin')?>/images/icons/dark/add.png"
				class="titleIcon">
			<h6>Cập nhật thông tin danh mục sản phẩm</h6>
		</div>
		<form class="form" id="form" action="" method="post" enctype="multipart/form-data">
			<fieldset>
				<div class="formRow">
                	<label class="formLeft" for="name">Tên:<span class="req">*</span></label>
                	<div class="formRight">
                		<span class="oneTwo"><input name="name" id="param_name" value="<?php echo $info->name?>" _autocheck="true" type="text"></span>
                		<span name="name_autocheck" class="autocheck"></span>
                		<div name="name_error" class="clear error"><?php echo form_error('name');?></div>
                	</div>
                	<div class="clear"></div>
                </div>

                <!-- Hiển thị danh mục cha của sản phẩm -->
				<div class="formRow">
                	<label class="formLeft" for="param_parent_id">Danh mục cha:</label>
                	<div class="formRight">
                		<span class="oneTwo">
                			<select name="parent_id" id="param_parent_id" _auto_check="true">
								<option value="0">Là danh mục cha</option>
								<?php foreach ($list as $row):?>
									<option value="<?php echo $row->parent_id?>" <?php echo ($row->id == $info->parent_id) ? 'selected' : ''?>><?php echo $row->name?></option>
								<?php endforeach;?>
							</select>
						</span>
                	</div>
                	<div class="clear"></div>
                </div>

				<!-- Hiển thị thứ tự hiển thị của danh mục -->
                <div class="formRow">
                	<label class="formLeft" for="param_sort_order">Thứ tự hiển thị:</label>
                	<div class="formRight">
                		<span class="oneTwo"><input name="sort_order" id="param_sort_order" value ="<?php echo $info->sort_order?>" _autocheck="true"  type="text"></span>
                		<span name="sort_order_autocheck" class="autocheck"></span>
                	</div>
                	<div class="clear"></div>
                </div>

                <div class="formSubmit">
           			<input type="submit" value="Cập nhật" class="redB">
	           	</div>

			</fieldset>
		</form>
	</div>
</div>