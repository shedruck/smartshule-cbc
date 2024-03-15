<div class="col-md-8">
    <div class="head">
        <div class="icon"><span class="icosg-target1"></span></div>
        <h2> Add Streams </h2> 
        <div class="right">                            
            <?php echo anchor('admin/class_groups/', '<i class="glyphicon glyphicon-list"> </i> List All', 'class="btn btn-primary"'); ?>
        </div>    					
    </div>

    <div class="block-fluid">
        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo form_open_multipart(current_url(), $attributes);
        ?> 
        <div class="form-group">
            <div class="col-md-12">
                <span class="top title">Add Streams for: </span>
                <span class="label label-info">  <?php echo $class; ?></span> 
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-12">
                <span class="top title">Select Streams</span>
                <?php
					echo form_dropdown('streams[]', $streams, '', ' multiple="multiple"  class="select" ');
					echo form_error('streams');
                ?> 
            </div>
        </div>     
        <div class='form-group'><div class="control-div"></div>
            <div class="col-md-10">
                <?php echo form_submit('submit', 'Save', "id='submit' class='btn btn-primary'"); ?>
                <?php echo anchor('admin/class_groups', 'Cancel', 'class="btn btn-danger"'); ?>
            </div>
        </div>
        <?php echo form_close(); ?>
        <div class="clearfix"></div>
    </div>
</div>
<div class="col-md-4">
    <div class="widget">
        <div class="head dark">
            <div class="icon"></div>
            <h2>Add Class Stream</h2>
        </div>
        <div class="block-fluid">
            <?php echo form_open('admin/class_stream/quick_add/'.$group, 'class=""'); ?> 
            <div class="form-group">
                <div class="col-md-3">Name:</div>
                <div class="col-md-9">                                      
                    <?php echo form_input('name', '', 'id="title_"  placeholder=" e.g Red"'); ?>
                    <?php echo form_error('name'); ?>
                </div>
            </div>


            <div class="toolbar TAR">
                <button class="btn btn-primary">Add</button>
            </div>
            <?php echo form_close(); ?> 
        </div>
    </div>

</div>



