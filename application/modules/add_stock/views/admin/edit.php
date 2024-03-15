<script type="text/javascript">
        function totals() {
            //grab the values
            quantity = document.getElementById('quantity').value;
            unit_price = document.getElementById('unit_price').value;

            document.getElementById('total').value = parseFloat(quantity) * parseFloat(unit_price);
        }
</script>

<div class="col-md-8">
    <div class="head">
        <div class="icon"><span class="icosg-target1"></span></div>
        <h2> Stocks Management</h2> 
        <div class="right">                            
            <?php echo anchor('admin/add_stock/create/', '<i class="glyphicon glyphicon-plus">
                </i> Add Stock ', 'class="btn btn-primary"'); ?> 
            <?php echo anchor('admin/add_stock/', '<i class="glyphicon glyphicon-list">
                </i> List All', 'class="btn btn-primary"'); ?>
            <div class="btn-group">
                <button class="btn dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-cog"></i> Options</button>

                <ul class="dropdown-menu pull-right">
                    <li><a class=""  href="<?php echo base_url('admin/items'); ?>"><i class="glyphicon glyphicon-list-alt"></i> Manage Items</a></li>
                    <li class="divider"></li>
                    <li><a href="<?php echo base_url('admin/items_category'); ?>"><i class="glyphicon glyphicon-fullscreen"></i> Manage Items Category</a></li>
                    <li class="divider"></li>
                    <li><a href="<?php echo base_url('admin/add_stock/create'); ?>"><i class="glyphicon glyphicon-plus"></i> Add Stock</a></li>
                    <li class="divider"></li>
                    <li><a href="<?php echo base_url('admin/stock_taking'); ?>"><i class="glyphicon glyphicon-edit"></i> Stock Taking</a></li>
                    <li class="divider"></li>
                    <li><a href="<?php echo base_url('admin/inventory'); ?>"><i class="glyphicon glyphicon-folder-open"></i> Inventory Listing</a></li>
                </ul>
            </div>

        </div>    					
    </div>            
    <div class="block-fluid">

        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo form_open_multipart(current_url(), $attributes);
        ?>

        <div class="form-group">
            <div class='  col-md-2' for='day'>Date <span class='required'>*</span></div>
            <div class="col-md-10">

                <?php echo form_input('day', $add_stock_m->day > 0 ? date('d M Y', $add_stock_m->day) : $add_stock_m->day, 'class="validate[required] form-control datepicker col-md-4"'); ?>
                <span class="input-group-addon" id="datepickerbtn2"><i class="glyphicon glyphicon-calendar"></i></span>

                <?php echo form_error('day'); ?>
            </div>
        </div> 



        <div class='form-group'>
            <div class="col-md-2" for='product_id'>Product Name <span class='required'>*</span></div>
            <div class="col-md-10">
                <?php
                echo form_dropdown(' product_id', $product, $add_stock_m->product_id, ' class="select col-md-4" data-placeholder="Select  Options..." ');
                echo form_error('product_id');
                ?>

            </div></div>

        <div class='form-group'>
            <div class=' col-md-2' for='quantity'>Quantity <span class='required'>*</span></div>
            <div class="col-md-10">
                <?php echo form_input('quantity', $add_stock_m->quantity, 'id="quantity"  class="col-md-4" id="focusedinput" onblur="totals()"'); ?>
                <?php echo form_error('quantity'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class=' col-md-2' for='unit_price'>Unit Price <span class='required'>*</span></div>
            <div class="col-md-10">
                <?php echo form_input('unit_price', $add_stock_m->unit_price, 'id="unit_price"  class="col-md-4" id="focusedinput" onblur="totals()"'); ?>
                <?php echo form_error('unit_price'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class=' col-md-2' for='total'>Total </div>
            <div class="col-md-10">
                <?php echo form_input('total', $add_stock_m->total, 'id="total"  class="col-md-4" id="focusedinput" '); ?>
                <?php echo form_error('total'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-2" for='user_id'>Person Responsible <span class='required'>*</span></div>
            <div class="col-md-10">
                <?php
                $staff = $this->ion_auth->get_admins();
                $member = $this->ion_auth->get_members();
                $teachers = $this->ion_auth->get_teachers_and_title();
                $h_teachers = $this->ion_auth->get_headteachers();
                $managers = $this->ion_auth->get_managers();

                echo form_dropdown('user_id', array('' => 'Select Person Responsible') + $staff + $member + $teachers + $h_teachers + $managers, (isset($add_stock_m->user_id)) ? $add_stock_m->user_id : '', ' class="select populate" ');
                echo form_error('user_id');
                ?>
            </div></div>

        <div class='form-group'>
            <div class=' col-md-2' for='receipt'><?php echo lang(($updType == 'edit') ? "web_file_edit" : "web_file_create" ) ?> (receipt) </div>
            <div class="col-md-10">
                <input id='receipt' type='file' name='receipt' />

                <?php if ($updType == 'edit'): ?>
                        <a href='/public/uploads/add_stock/files/<?php echo $add_stock_m->receipt ?>' />Download actual file (receipt)</a>
                <?php endif ?>

                <br/><?php echo form_error('receipt'); ?>
                <?php echo ( isset($upload_error['receipt'])) ? $upload_error['receipt'] : ""; ?>
            </div>
        </div>

        <div class="widget">
            <div class="head dark">
                <div class="icon"><i class="icos-pencil"></i></div>
                <h2>Description</h2>
            </div>
            <div class="block-fluid editor">
                <textarea id="wysiwyg"  class="wysiwyg col-md-8" style="height: 300px"  name="description"  /><?php echo set_value('description', (isset($add_stock_m->description)) ? htmlspecialchars_decode($add_stock_m->description) : ''); ?></textarea>
                <?php echo form_error('description'); ?>

            </div>

        </div> 


        <div class='form-group'>
            <div class="col-md-10">


                <?php echo form_submit('submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
                <?php echo anchor('admin/add_stock', 'Cancel', 'class="btn btn-danger"'); ?>
            </div>
        </div>

        <?php echo form_hidden('page', set_value('page', $page)); ?>
        <?php if ($updType == 'edit'): ?>
                <?php echo form_hidden('id', $add_stock_m->id); ?>
        <?php endif ?>

        <?php echo form_close(); ?>
    </div>
</div>
</div>
</div>