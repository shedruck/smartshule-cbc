<div class="block-fluid">
    <div class="head dark">
        <div class="icon"><span class="icosg-target1"></span></div>
        <h2> Add Subject </h2> 
        <div class="right">                            
            <?php echo anchor('admin/setup/subjects/' . $page, '<i class="glyphicon glyphicon-list"></i> List Subjects '  , 'class="btn btn-primary"'); ?>
        </div>    					
    </div>

    <div class="block-fluid col-md-8">
        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo form_open_multipart(current_url(), $attributes);
        ?>
        <div class='form-group'>
            <div class="col-md-2" for='title'>Title <span class='required'>*</span></div><div class="col-md-10">
                <?php echo form_input('title', $result->name, 'id="title_"  class="form-control" '); ?>
                <?php echo form_error('title'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-2" for='code'>Code </div><div class="col-md-10">
                <?php echo form_input('code', $result->code, 'id="code_"  class="form-control" '); ?>
                <?php echo form_error('code'); ?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-12">
                <span class="top title">Select Class</span>
                <?php
                $classes = $this->ion_auth->list_classes();
                echo form_dropdown('class[]', $classes, (isset($result->class)) ? $result->class : '', ' multiple="multiple" id="msc"');
                echo form_error('class');
                ?>
            </div>
        </div>     

        <div class="widget">
            <div class="head dark">
                <div class="icon"><i class="icos-pencil"></i></div>
                <h2>Description</h2>
            </div>
            <div class="block-fluid editor">
                <textarea id="wysiwyg"  name="description" style="height: 300px;"><?php echo set_value('description', $result->description); ?></textarea>   
                <?php echo form_error('description'); ?> </textarea>
            </div>

        </div> 

        <div class='form-group'><div class="control-div"></div>
            <div class="col-md-10"> 
                <?php echo form_submit('submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
                <?php echo anchor('admin/setup/subjects', 'Cancel', 'class="btn btn-danger"'); ?>
            </div>
        </div>

        <?php echo form_close(); ?>
        <div class="clearfix"></div>
    </div>
</div>



