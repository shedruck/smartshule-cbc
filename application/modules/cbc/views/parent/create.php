<div class="col-md-8">
    <div class="head"> 
        <div class="icon"><span class="icosg-target1"></span></div>		
        <h2>  Fee Extras  </h2>
        <div class="right"> 
            <?php echo anchor('admin/fee_extras/create', '<i class="glyphicon glyphicon-plus">
                </i> ' . lang('web_add_t', array(':name' => 'Fee Extras')), 'class="btn btn-primary"'); ?> 
            <?php echo anchor('admin/fee_extras', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Fee Extras')), 'class="btn btn-primary"'); ?> 
        </div>
    </div>
    <div class="block-fluid">
        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo form_open_multipart(current_url(), $attributes);
        ?>
        <div class='form-group'>
            <div class="col-md-2" for='title'>Title <span class='required'>*</span></div><div class="col-md-10">
                <?php echo form_input('title', $result->title, 'id="title_"  class="form-control" '); ?>
                <?php echo form_error('title'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-2" for='ftype'>Fee Type <span class='required'>*</span></div>
            <div class="col-md-10">
                <?php
                $items = array('' => '',
                    "1" => "Charge",
                    "2" => "Waiver",
                );
                echo form_dropdown('ftype', $items, (isset($result->ftype)) ? $result->ftype : '', ' class="select" data-placeholder="Select Options..." ');
                echo form_error('ftype');
                ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-2" for='amount'>Amount <span class='required'>*</span></div><div class="col-md-10">
                <?php echo form_input('amount', $result->amount, 'id="amount_"  class="form-control" '); ?>
                <?php echo form_error('amount'); ?>
            </div>
        </div>
        
        <div class='form-group'>
            <div class="col-md-2" for='cycle'>Charged: <span class='required'>*</span></div>
            <div class="col-md-10">
                <?php
                $pays = array('' => '',
                    "Once" => "Once",
                    "Per Year" => "Per Year",
                    "Per Term" => "Per Term",
                    "Per Month" => "Per Month",
                    "999" => "On Demand"
                 );
                echo form_dropdown('cycle', $pays, (isset($result->cycle)) ? $result->cycle : '', ' class="select" data-placeholder="Select Options..." ');
                echo form_error('cycle');
                ?>
            </div>
        </div>
 
        <div class='widget'>
            <div class='head dark'>
                <div class='icon'><i class='icos-pencil'></i></div>
                <h2>Description </h2></div>
            <div class="block-fluid editor">
                <textarea id="description"   style="height: 300px;" class=" wysiwyg "  name="description"  /><?php echo set_value('description', (isset($result->description)) ? htmlspecialchars_decode($result->description) : ''); ?></textarea>
                <?php echo form_error('description'); ?>
            </div>
        </div>

        <div class='form-group'><div class="col-md-2"></div>
            <div class="col-md-10">
                <?php echo form_submit('submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
                <?php echo anchor('admin/fee_extras', 'Cancel', 'class="btn  btn-default"'); ?>
            </div></div>

        <?php echo form_close(); ?>
        <div class="clearfix"></div>
    </div>
</div>