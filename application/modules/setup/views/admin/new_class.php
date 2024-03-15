  
<div class="block-fluid  ">
<div class=" col-md-8 ">
    <div class="head dark">
        <div class="icon"><span class="icosg-target1"></span></div>
        <h2>School Classes</h2> 
        <div class="right">    
            <?php echo anchor('admin/setup/classes/', '<i class="glyphicon glyphicon-list">
                </i> List All Classes', 'class="btn btn-primary"'); ?>
 
        </div>    					
    </div>
    <div class="block-fluid  ">

        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo form_open_multipart(current_url(), $attributes);
        ?>
        <div class='form-group'>
            <div class="col-md-2" for='class_name'>Class Name </div><div class="col-md-6">
                <?php echo form_input('class_name', $result->class_name, 'id="class_name_"  class="form-control" '); ?>
                <?php echo form_error('class_name'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-2" for='stream'>Stream  </div>
            <div class="col-md-6">
                <?php
                echo form_dropdown('stream', $stream, (isset($result->stream)) ? $result->stream : '', ' class="chzn-select" placeholder="E.g Yellow, B etc" ');
                echo form_error('stream');
                ?>

            </div></div> 
        <div class='form-group'>
            <div class="col-md-2" for='max_no_of_students'>Capacity </div><div class="col-md-6">
                <?php echo form_input('max_no_of_students', $result->max_no_of_students, 'id="max_no_of_students_" placeholder="E.g 45" class="form-control" '); ?>
                <?php echo form_error('max_no_of_students'); ?>
            </div>
        </div>
 
        <div class='form-group'>
            <div class="col-md-2" for='class_teacher'>Class Teacher  </div>
            <div class="col-md-6">
                <?php
                $items = $this->ion_auth->get_teachers();
                echo form_dropdown('class_teacher', array('' => 'Select Teacher') + (array) $items, (isset($result->class_teacher)) ? $result->class_teacher : '', ' class="chzn-select" data-placeholder="Select Options..." ');
                echo form_error('class_teacher');
                ?>
            </div></div>

        <div class="widget">
            <div class="head dark">
                <div class="icon"><i class="icos-pencil"></i></div>
                <h2>Description</h2>
            </div>
            <div class="block-fluid editor">

                <textarea id="wysiwyg"  name="description" style="height: 300px;">
                    <?php echo set_value('description', (isset($result->description)) ? htmlspecialchars_decode($result->description) : ''); ?></textarea>
                <?php echo form_error('description'); ?>

            </div>

        </div> 

        <div class='form-group'><div class="col-md-2"></div><div class="col-md-6">
                 <?php echo form_submit('submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
                <?php echo anchor('admin/setup/classes/', 'Cancel', 'class="btn btn-danger"'); ?>
            </div></div>

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
            <?php echo form_open('admin/setup/quick_add', 'class=""'); ?> 
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
</div>