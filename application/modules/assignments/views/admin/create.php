<div class="col-md-8">
    <div class="head"> 
        <div class="icon"><span class="icosg-target1"></span></div>		
        <h2>  Assignments  </h2>
        <div class="right"> 
            <?php echo anchor('admin/assignments/create', '<i class="glyphicon glyphicon-plus">
                </i> ' . lang('web_add_t', array(':name' => 'Assignments')), 'class="btn btn-primary"'); ?> 
            <?php echo anchor('admin/assignments', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Assignments')), 'class="btn btn-primary"'); ?> 
        </div>
    </div>
    <div class="block-fluid">
        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo form_open_multipart(current_url(), $attributes);
        ?>
        <div class='form-group'>
            <div class="col-md-2" for='title'>Title <span class='required'>*</span></div>
            <div class="col-md-10">
                <?php echo form_input('title', $result->title, 'id="title_"  class="form-control" '); ?>
                <?php echo form_error('title'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-2" for='start_date'>Start Date <span class='required'>*</span></div><div class="col-md-10">
                <div id="datetimepicker1" class="input-group date form_datetime">
                    <?php echo form_input('start_date', $result->start_date > 0 ? date('d M Y', $result->start_date) : $result->start_date, 'class="validate[required] form-control datepicker col-md-4"'); ?>
                    <span class="input-group-addon "><i class="glyphicon glyphicon-calendar"></i></span>
                </div>
                <?php echo form_error('start_date'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-2" for='end_date'>End Date <span class='required'>*</span></div><div class="col-md-10">
                <div id="datetimepicker1" class="input-group date form_datetime">
                    <?php echo form_input('end_date', $result->end_date > 0 ? date('d M Y', $result->end_date) : $result->end_date, 'class="validate[required] form-control datepicker col-md-4"'); ?>
                    <span class="input-group-addon "><i class="glyphicon glyphicon-calendar"></i></span>
                </div>
                <?php echo form_error('end_date'); ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <span class="top title">Select Class</span>
                <?php
                $classes = $this->ion_auth->classes_and_stream();
                echo form_dropdown('class[]', $classes, (isset($result->class)) ? $result->class : '', ' multiple="multiple" id="msc"');
                echo form_error('class');
                ?>
            </div>
        </div>  
        <div class='form-group'>
            <div class="col-md-2" for='document'>Upload Document </div>
            <div class="col-md-10">
                <input id='document' type='file' name='document' />
                <?php if ($updType == 'edit'): ?>
                        <a href='<?php echo base_url('uploads/files/' . $result->document); ?>' >Download actual file (document)</a>
                <?php endif ?>

                <br/><?php echo form_error('document'); ?>
                <?php echo ( isset($upload_error['document'])) ? $upload_error['document'] : ""; ?>
            </div>
        </div>

        <div class='widget'>
            <div class='head dark'>
                <div class='icon'><i class='icos-pencil'></i></div>
                <h2>Assignment </h2></div>
            <div class="block-fluid editor">
                <textarea id="assignment"   style="height: 300px;" class=" wysiwyg "  name="assignment"  /><?php echo set_value('assignment', (isset($result->assignment)) ? htmlspecialchars_decode($result->assignment) : ''); ?></textarea>
                <?php echo form_error('assignment'); ?>
            </div>
        </div>

        <div class='widget'>
            <div class='head dark'>
                <div class='icon'><i class='icos-pencil'></i></div>
                <h2>Comment </h2></div>
            <div class="block-fluid editor">
                <textarea id="comment"   style="height: 300px;" class=" wysiwyg "  name="comment"  /><?php echo set_value('comment', (isset($result->comment)) ? htmlspecialchars_decode($result->comment) : ''); ?></textarea>
                <?php echo form_error('comment'); ?>
            </div>
        </div>
        <div class='form-group'><div class="col-md-2"></div><div class="col-md-10">
                <?php echo form_submit('submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
                <?php echo anchor('admin/assignments', 'Cancel', 'class="btn  btn-default"'); ?>
            </div></div>

        <?php echo form_close(); ?>
        <div class="clearfix"></div>
    </div>
</div>