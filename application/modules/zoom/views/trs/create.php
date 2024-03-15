<div class="portlet mt-2">
    <div class="portlet-heading portlet-default border-bottom">
        <h3 class="portlet-title text-dark">
            Zoom Classes
        </h3>
        <div class="portlet-widgets">
            <?php echo anchor('trs/zoom', '<i class="mdi mdi-reply"></i> Back', 'class="btn btn-primary"'); ?>
        </div>
        <div class="clearfix"></div>
        <hr>
    </div>
    <div id="bg-default" class="panel-collapse collapse in">
        <div class="portlet-body">
            <?php
           echo form_open();
         
            ?>
            <div class="form-group">
                <label>Meeting Title</label>
                <input id='title' type='text' placeholder="Title of the meeting" name='title' maxlength='' class='form-control' value="<?php echo set_value('title', (isset($result->title)) ? $result->title : ''); ?>"  />
                <?php echo form_error('title'); ?>
            </div>

        <div class="form-group">
            <label>Meeting Link</label>
            <textarea name="link" placeholder="Please enter the meeting link here" class="form-control"><?php echo set_value('link', (isset($result->link)) ? $result->link : ''); ?></textarea>
            <?php echo form_error('link'); ?>
        </div>

        <div class='form-group'>
            <label>Meeting Time</label>
            <input type="datetime-local" name="time" class="form-control"  value="<?php echo set_value('time', (isset($result->time)) ? $result->time : ''); ?>" required>
            <?php echo form_error('time'); ?>
        </div>

        <div class='form-group'>
            <label>Select Class</label>
                <?php
                $classes = $this->ion_auth->fetch_classes();
                echo form_dropdown('class', $classes, (isset($result->class)) ? $result->class : '', ' class="select" data-placeholder="Select  Options..." ');
                ?>		
        </div>  

                             
<div class='form-group'>
    <button class="btn btn-sm btn-success">Submit</button>
</div>
            <?php echo form_close(); ?>
            <div class="clearfix mb-5"></div>
        </div>
    </div>
</div>

