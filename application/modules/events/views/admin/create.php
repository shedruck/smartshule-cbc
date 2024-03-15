<div class="col-md-6">
    <div class="head"> 
        <div class="icon"><span class="icosg-target1"></span></div>		
        <h2>Add  Event </h2>
        <div class="right">          
            <?php echo anchor('admin/events', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Events')), 'class="btn btn-primary"'); ?>
        </div>
    </div>
    <div class="block-fluid">
        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo form_open_multipart(current_url(), $attributes);
        ?>
        <div class='form-group'>
            <div class="col-md-3" for='title'>Title <span class='required'>*</span></div><div class="col-md-6">
                <?php echo form_input('title', isset($result->title) ? $result->title : '', 'id="title_"  class="form-control" '); ?>
                <?php echo form_error('title'); ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-3" for='date'>Date <span class='required'>*</span></div><div class="col-md-6">
                <?php
                $dt = '';
                if ($result->date)
                {
                        if ((!preg_match('/[^\d]/', $result->date)))//if it contains digits only
                        {
                                $dt = date('d M Y', $result->date);
                        }
                        else
                        {
                                $dt = $result->date;
                        }
                }
                echo form_input('date', $dt, 'id="date_"  class="form-control datepicker" ');
                ?>
                <?php echo form_error('date'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-3" for='start'>Start <span class='required'>*</span></div><div class="col-md-6">
                <?php echo form_input('start', isset($result->start) ? $result->start : '', 'id="start_" placeholder="e.g 9.00 AM" class="form-control" '); ?>
                <?php echo form_error('start'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-3" for='end'>End </div><div class="col-md-6">
                <?php echo form_input('end', isset($result->end) ? $result->end : '', 'id="end_"  class="form-control" placeholder="e.g 11.00 AM" '); ?>
                <?php echo form_error('end'); ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-3" for='venue'>Venue </div>
            <div class="col-md-6">
                <?php echo form_input('venue', isset($result->venue) ? $result->venue : '', 'id="venue"  class="form-control" '); ?>
                <?php echo form_error('venue'); ?>
            </div>
        </div>

        <div class='widget'>
            <div class='head dark'>
                <div class='icon'><i class='icos-pencil'></i></div>
                <h2>Description <span class='required'>*</span></h2>
            </div>
            <div class="block-fluid editor">
                <textarea id="description" style="height: 300px;" class=" wysiwyg "  name="description" /><?php echo set_value('description', (isset($result->description)) ? htmlspecialchars_decode($result->description) : ''); ?></textarea>
                <?php echo form_error('description'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <?php echo form_submit('submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
                <?php echo anchor('admin/events', 'Cancel', 'class="btn  btn-default"'); ?>
            </div></div>

        <?php echo form_close(); ?>
        <div class="clearfix"></div>
    </div>
</div>
<div class="col-md-6">
    <div class="head"> 
        <div class="icon"><span class="icosg-target1"></span></div>		
        <h2>Add Announcement</h2>
        <div class="right"> 
            <?php echo anchor('admin/events', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Events')), 'class="btn btn-primary"'); ?>
        </div>
    </div>
    <div class="block-fluid">
        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo form_open_multipart(current_url(), $attributes);
        ?>
        <div class='form-group'>
            <div class="col-md-3">Title <span class='required'>*</span></div>
            <div class="col-md-6">
                <?php echo form_input('stitle', isset($result->stitle) ? $result->stitle : '', ' class="form-control" '); ?>
                <?php echo form_error('stitle'); ?>
            </div>
        </div>
        <div class='widget'>
            <div class='head dark'>
                <div class='icon'><i class='icos-pencil'></i></div>
                <h2>Description<span class='required'>*</span></h2>
            </div>
            <div class="block-fluid editor">
                <textarea style="height: 300px;" class=" wysiwyg "  name="desc" /><?php echo set_value('desc', (isset($result->desc)) ? htmlspecialchars_decode($result->desc) : ''); ?></textarea>
                <?php echo form_error('desc'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <?php echo form_submit('announce', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
                <?php echo anchor('admin/events', 'Cancel', 'class="btn  btn-default"'); ?>
            </div>
        </div>

        <?php echo form_close(); ?>
        <div class="clearfix"></div>
    </div>
</div>