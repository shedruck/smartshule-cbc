<div class="col-md-8">
    <div class="head"> 
        <div class="icon"><span class="icosg-target1"></span></div>		
        <h2>  Medical Records  </h2>
        <div class="right">
            <?php echo anchor('admin/medical_records', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Medical Records')), 'class="btn btn-primary"'); ?>
        </div>
    </div>
    <div class="block-fluid">
        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo form_open_multipart(current_url(), $attributes);
        ?>
        <div class='form-group'>
            <div class="col-md-4" for='date'>Date Reported </div>
            <div class="col-md-6 input-group">
                <input id='date' type='text' name='date' maxlength=''  class='form-control datepicker' value="<?php
                if (!empty($result->date) && $result->date > 10000)
                {
                        echo date('d/m/Y', $result->date);
                }
                else
                {
                        echo set_value('date', (isset($result->date)) ? $result->date : '');
                }
                ?>"  />
				 <span class="input-group-addon "><i class="glyphicon glyphicon-calendar "></i></span>
                <?php echo form_error('date'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-4" for='student'>Student <span class='required'>*</span></div>
            <div class="col-md-6">
                <?php
                $items = $this->ion_auth->students_full_details();
                echo form_dropdown('student', array('' => 'Select student') + (array) $items, (isset($result->student)) ? $result->student : '', ' class="select" data-placeholder="Select Options..." ');
                echo form_error('student');
                ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-4" for='sickness'>Problem/Sickness Reported <span class='required'>*</span></div><div class="col-md-6">
                <?php echo form_input('sickness', $result->sickness, 'id="sickness_"  class="form-control" '); ?>
                <?php echo form_error('sickness'); ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-3">Notify Parent by SMS? </div>
            <div class="col-md-9">
                Yes<input type="radio" id="sms" name="sms" value="1" />
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  No <input type="radio" name="sms" id="not" value="0"/>
                <textarea name="message" placeholder="Write sms message" id="shows"></textarea>
            </div>
        </div>
        <div class='widget'>
            <div class='head dark'>
                <div class='icon'><i class='icos-pencil'></i></div>
                <h2>Action Taken <span class='required'>*</span></h2></div>
            <div class="block-fluid editor">
                <textarea id="action_taken"   style="height: 300px;" class=" wysiwyg "  name="action_taken"  /><?php echo set_value('action_taken', (isset($result->action_taken)) ? htmlspecialchars_decode($result->action_taken) : ''); ?></textarea>
                <?php echo form_error('action_taken'); ?>
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

        <div class='form-group'>
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <?php echo form_submit('submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
                <?php echo anchor('admin/medical_records', 'Cancel', 'class="btn  btn-default"'); ?>
            </div>
        </div>
        <?php echo form_close(); ?>
        <div class="clearfix"></div>
    </div>
</div>
<script>
        $(document).ready(function ()
        {
            $('#shows').hide();
            $('#sms').click(function ()
            {
                $('#shows').show();
            });
            $('#not').click(function ()
            {
                $('#shows').hide();
            });
        });
</script>	