
<div class="col-md-8">
    <div class="head"> 
        <div class="icon"><span class="icosg-target1"></span></div>		
        <h2>  Books Stock  </h2>
        <div class="right"> 
            <!--<?php echo anchor('admin/books_stock/create', '<i class="glyphicon glyphicon-plus">
                </i> ' . lang('web_add_t', array(':name' => 'Books Stock')), 'class="btn btn-primary"'); ?> -->
            <?php echo anchor('admin/books_stock', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Books Stock')), 'class="btn btn-primary"'); ?> 
        </div>
    </div>
    <div class="block-fluid">
        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo form_open_multipart(current_url(), $attributes);
        ?>
        <div class='form-group'>
            <div class="col-md-3" for='purchase_date'>Purchased Date <span class='required'>*</span></div>
            <div class="col-md-4">
                <div id="datetimepicker1" class="input-group date form_datetime">
                    <?php echo form_input('purchase_date', $result->purchase_date > 0 ? date('d M Y', $result->purchase_date) : $result->purchase_date, 'class="form-control datepicker"'); ?>
                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                </div>
                <?php echo form_error('purchase_date'); ?>
            </div>
        </div>
        <div class='form-group'>
            <div class=' col-md-3' for='quantity'>Quantity <span class='required'>*</span></div>
            <div class="col-md-4">
                <?php echo form_input('quantity', $result->quantity, 'id="quantity"  class="" id="focusedinput" onblur="totals()"'); ?>
                <?php echo form_error('quantity'); ?>
            </div>
        </div>

        <div class='form-group'><div class="col-md-2"></div><div class="col-md-10">
                <?php echo form_submit('submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
                <?php echo anchor('admin/books_stock', 'Cancel', 'class="btn  btn-default"'); ?>
            </div></div>
        <?php echo form_close(); ?>
        <div class="clearfix"></div>
    </div>
</div>