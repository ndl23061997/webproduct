<?php $this->load->view('admin/product/header')?>
<div class="line"></div>
<div class="wrapper">

	<!-- Form -->
	<form class="form" id="form" action="" method="post" enctype="multipart/form-data">
		<fieldset>
			<div class="widget">
				<div class="title">
					<img src="<?php echo public_url('admin/')?>images/icons/dark/add.png" class="titleIcon">
					<h6>Thêm mới Sản phẩm</h6>
				</div>

				<ul class="tabs">
					<li><a href="#tab1">Thông tin chung</a></li>
					<li><a href="#tab2">SEO Onpage</a></li>
					<li><a href="#tab3">Bài viết</a></li>

				</ul>

				<div class="tab_container">
					<div id="tab1" class="tab_content pd0">
						<div class="formRow">
							<label class="formLeft" for="param_name">Tên:<span class="req">*</span></label>
							<div class="formRight">
								<span class="oneTwo"><input name="name" id="param_name"
									_autocheck="true" type="text" value="<?php echo $product->name?>"></span> <span
									name="name_autocheck" class="autocheck"></span>
								<div name="name_error" class="clear error"><?php echo form_error('name');?></div>
							</div>
							<div class="clear"></div>
						</div>

						<div class="formRow">
							<label class="formLeft">Hình ảnh: <span></span> </label>
							<div class="formRight">
								<div class="left">
									<input type="file" id="image" name="image" value="<?php echo $product->image_link?>">
								</div>
								<div name="image_error" class="clear error"></div>
							</div>
							<div class="formRight">
								<img src="<?php echo base_url()?>/upload/product/<?php echo $product->image_link?>" alt="" height="70" style="margin-top:10px;"/>
							</div>
							<div class="clear"></div>
						</div>

						<div class="formRow">
							<label class="formLeft">Ảnh kèm theo:</label> <span></span>
							<div class="formRight">
								<div class="left">
									<input type="file" id="image_list" name="image_list[]"
										multiple="">
								</div>

								<div name="image_list_error" class="clear error"></div>
							</div>
							<div class="formRight">
							<?php if ($product->image_list != '') :?>
							<?php $image_list = json_decode($product->image_list)?>
								<?php foreach ($image_list as $img):?>
									<img src="<?php echo base_url()?>/upload/product/<?php echo $img?>" alt="" height="70" style="margin-top:10px;margin-right:10px;"/>
								<?php endforeach;?>
							<?php endif?>
							</div>
							<div class="clear"></div>
						</div>

						<!-- Price -->
						<div class="formRow">
							<label class="formLeft" for="param_price"> Giá (VND) : <span
								class="req">*</span>
							</label>
							<div class="formRight">
								<span class="oneTwo"> <input value="<?php echo $product->price?>" name="price" style="width: 100px"
									id="param_price" class="format_number" _autocheck="true"
									type="text"> <img class="tipS"
									title="Giá bán sử dụng để giao dịch"
									style="margin-bottom: -8px"
									src="<?php echo public_url('admin/')?>crown/images/icons/notifications/information.png">
								</span> <span name="price_autocheck" class="autocheck"></span>
								<div name="price_error" class="clear error"><?php echo form_error('price');?></div>
							</div>
							<div class="clear"></div>
						</div>

						<!-- Discount -->
						<div class="formRow">
							<label class="formLeft" for="param_discount"> Giảm giá (%) : <span class="req">*</span>
							</label>
							<div class="formRight">
								<span> <input value="<?php echo $product->discount?>" name="discount" style="width: 100px"
									id="param_discount" class="format_number" type="text"> <img
									class="tipS" title="Số tiền giảm giá"
									style="margin-bottom: -8px"
									src="<?php echo public_url('admin/')?>crown/images/icons/notifications/information.png">
								</span> <span name="discount_autocheck" class="autocheck"></span>
								<div name="discount_error" class="clear error"><?php echo form_error('discount');?></div>
							</div>
							<div class="clear"></div>
						</div>

						<!-- Select box hiển thị các danh mục sản phẩm -->
						<div class="formRow">
							<label class="formLeft" for="param_cat">Thể loại:</label>
							<div class="formRight">
								<td class="item">
									<select name="catalog">
										<?php foreach ($catalogs as $row):?>
											<?php if (count($row->subs) > 1):?>
												<optgroup label="<?php echo $row->name?>">
													<?php foreach ($row->subs as $sub):?>
														<option value="<?php echo $sub->id?>" <?php echo ($sub->id == $this->input->get('catalog')) ? 'selected' : '' ?>>
															<?php echo $sub->name?>
														</option>
													<?php endforeach;?>
												</optgroup>
											<?php else:?>
												<option value="<?php echo $row->id?>" <?php echo ($row->id == $this->input->get('catalog')) ? 'selected' : '' ?>>
													<?php echo $row->name?>
												</option>
											<?php endif;?>
										<?php endforeach;?>
									</select>
								</td>
							</div>

							<div class="clear"></div>
						</div>


						<!-- warranty -->
						<div class="formRow">
							<label class="formLeft" for="param_warranty"> Bảo hành : </label>
							<div class="formRight">
								<span class="oneFour"><input value="<?php echo $product->warranty?>" name="warranty" id="param_warranty"
									type="text"></span> <span name="warranty_autocheck"
									class="autocheck"></span>
								<div name="warranty_error" class="clear error"></div>
							</div>
							<div class="clear"></div>
						</div>

						<div class="formRow">
							<label class="formLeft" for="param_sale">Tặng quà:</label>
							<div class="formRight">
								<span class="oneTwo"><textarea value="<?php echo $product->gifts?>" name="sale" id="param_sale"
										rows="4" cols=""></textarea></span> <span
									name="sale_autocheck" class="autocheck"></span>
								<div name="sale_error" class="clear error"></div>
							</div>
							<div class="clear"></div>
						</div>
						<div class="formRow hide"></div>
					</div>

					<div id="tab2" class="tab_content pd0">

						<div class="formRow">
							<label class="formLeft" for="param_site_title">Title:</label>
							<div class="formRight">
								<span class="oneTwo"><textarea value="<?php echo $product->site_title?>" name="site_title"
										id="param_site_title" _autocheck="true" rows="4" cols=""></textarea></span>
								<span name="site_title_autocheck" class="autocheck"></span>
								<div name="site_title_error" class="clear error"></div>
							</div>
							<div class="clear"></div>
						</div>

						<div class="formRow">
							<label class="formLeft" for="param_meta_desc">Meta description:</label>
							<div class="formRight">
								<span class="oneTwo"><textarea value="<?php echo $product->meta_desc?>" name="meta_desc"
										id="param_meta_desc" _autocheck="true" rows="4" cols=""></textarea></span>
								<span name="meta_desc_autocheck" class="autocheck"></span>
								<div name="meta_desc_error" class="clear error"></div>
							</div>
							<div class="clear"></div>
						</div>

						<div class="formRow">
							<label class="formLeft" for="param_meta_key">Meta keywords:</label>
							<div class="formRight">
								<span class="oneTwo"><textarea value="<?php echo $product->meta_key?>" name="meta_key"
										id="param_meta_key" _autocheck="true" rows="4" cols=""></textarea></span>
								<span name="meta_key_autocheck" class="autocheck"></span>
								<div name="meta_key_error" class="clear error"></div>
							</div>
							<div class="clear"></div>
						</div>
						<div class="formRow hide"></div>
					</div>

					<div id="tab3" class="tab_content pd0">
						<div class="formRow">
							<label class="formLeft">Nội dung:</label>
							<div class="formRight">
								<textarea value="<?php echo $product->content?>" name="content" id="param_content" class="editor"></textarea>
								<div name="content_error" class="clear error"></div>
							</div>
							<div class="clear"></div>
						</div>
						<div class="formRow hide"></div>
					</div>


				</div>
				<!-- End tab_container-->

				<div class="formSubmit">
					<input type="submit" name="submit" value="Cập nhật" class="redB">
				</div>
				<div class="clear"></div>
			</div>
		</fieldset>
	</form>
</div>