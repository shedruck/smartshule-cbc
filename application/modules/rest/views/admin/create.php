<div class="col-md-8">
    <div class="head"> 
        <div class="icon"><span class="icosg-target1"></span></div>		
        <h2>  House  </h2>
        <div class="right"> 
            <?php echo anchor('admin/house/create', '<i class="glyphicon glyphicon-plus">
                </i> ' . lang('web_add_t', array(':name' => 'House')), 'class="btn btn-primary"'); ?> 
            <?php echo anchor('admin/house', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'House')), 'class="btn btn-primary"'); ?> 

        </div>
    </div>


    <div class="block-fluid">

        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo form_open_multipart(current_url(), $attributes);
        ?>
        <div class='form-group'>
            <div class="col-md-3" for='name'>Name <span class='required'>*</span></div><div class="col-md-9">
                <?php echo form_input('name', $result->name, 'id="name_"  class="form-control" '); ?>
                <?php echo form_error('name'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-3" for='slogan'>Slogan </div><div class="col-md-9">
                <?php echo form_input('email', $result->email, 'id="slogan_"  class="form-control" placeholder=" E.g We are the champions" '); ?>
                <?php echo form_error('email'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-3"></div>
            <div class="col-md-9">
                <?php echo form_submit('submit', 'Save', "id='submit' class='btn btn-primary'"); ?>
            </div>
        </div>

        <?php echo form_close(); ?>
        <div class="clearfix"></div>
    </div>
</div>