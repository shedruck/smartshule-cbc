<div class="col-md-12">
    <div class="head"> 
        <div class="icon"><span class="icosg-target1"></span></div>		
        <h2> Class teacher for <?php echo $row->name ?></h2>
        <div class="right">            
            <?php echo anchor('admin/activities', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Activities')), 'class="btn btn-primary"'); ?>
        </div>
    </div>
    <div class="block-fluid">
        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo form_open_multipart(current_url(), $attributes);
        ?>
        <div class='form-group'>
            <div class="col-md-3" >Teacher<span class='required'>*</span></div>
            <div class="col-md-6">
                <?php
                echo form_dropdown('teacher', array('' => '') + $list, (isset($result->teacher)) ? $result->teacher : '', ' class="select" placeholder="Select..." ');
                echo form_error('teacher');
                ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-3">Term <span class='required'>*</span></div>
            <div class="col-md-6">
                <?php
                echo form_dropdown('term', array('' => '') + $this->worker->_terms(), (isset($result->term)) ? $result->term : '', ' class="select" placeholder="Select..." ');
                ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-3">Year <span class='required'>*</span></div>
            <div class="col-md-6">
                <?php
                $yrange = range(date('Y') - 2, date('Y'));
                $yrs = array_combine($yrange, $yrange);
                krsort($yrs);
                echo form_dropdown('year', array('' => '') + $yrs, (isset($result->year)) ? $result->year : '', ' class="select" placeholder="Select..." ');
                ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <?php echo form_submit('submit', 'Save', "id='submit' class='btn btn-primary'"); ?>
                <?php echo anchor('admin/messages', 'Cancel', 'class="btn  btn-default"'); ?>
            </div>
        </div>    
        <?php echo form_close(); ?>
        <div class="clearfix"></div>
    </div>
</div>