<div class="wrapper">
    <br>
    <?php if ($message <> '') { $this->load->view('admin/admin/message'); } ?>
    <br>


    <div class="widget">
        <div class="title">
            <span class="titleIcon"><input id="titleCheck" name="titleCheck" type="checkbox"></span>
            <h6>Danh sách Admin</h6>
            <div class="num f12">
                Tổng số: <b><?php echo $total;?></b>
            </div>
        </div>

        <table cellpadding="0" cellspacing="0" class="sTable mTable myTable withCheck" id="checkAll" width="100%">
            <thead>
                <tr>
                    <td style="width: 10px;">
                    	<img src="<?php echo public_url('admin')?>/images/icons/tableArrows.png">
                    </td>
                    <td style="width: 80px;">id</td>
                    <td>Tên đăng nhập</td>
                    <td>Họ tên</td>
                    <td style="width: 100px;">Hành động</td>
                </tr>
            </thead>

            <tfoot>
                <tr>
                    <td colspan="7">
                        <div class="list_action itemActions">
                            <a class="button blueB" href="#submit" id="submit" url="user/del_all.html"><span style='color: white;'>Xóa hết</span></a>
                        </div>
                        <div class='pagination'></div>
                    </td>
                </tr>
            </tfoot>
            <tbody>
                <?php foreach ($list as $row):?>
                <tr>
                    <td>
                        <input name="id[]" type="checkbox" value="<?php echo $row->id?>">
                    </td>
                    <!--id -->
                    <td class="textC">
                        <?php echo $row->id?>
                    </td>
                    <!--username -->


                    <td>
                      <span class="tipS" title="<?php echo $row->username?>"><?php echo $row->username?></span>
                    </td>
                    <!-- name -->
                    <td>
                      <span class="tipS" title="<?php echo $row->name?>"><?php echo $row->name?></span>
                    </td>
                    <td class="option">
                        <a class="tipS" href="<?php echo admin_url('admin/edit/'.$row->id)?>" title="Chỉnh sửa"><img src="<?php echo public_url('admin')?>/images/icons/color/edit.png"></a>
                        <a class="tipS verify_action" href="<?php echo admin_url('admin/delete/'.$row->id)?>" title="Xóa"><img src="<?php echo public_url('admin')?>/images/icons/color/delete.png"></a>
                    </td>
                </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    </div>
</div>