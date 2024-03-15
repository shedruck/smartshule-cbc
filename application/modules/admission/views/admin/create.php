<div class="col-md-8">
    <div class="head"> 
        <div class="icon"><span class="icosg-target1"></span></div>		
        <h2>  Admission  </h2>
        <div class="right"> 
             <?php echo anchor('admin/admission/create', '<i class="glyphicon glyphicon-plus">
                </i> ' . lang('web_list_all', array(':name' => 'Admission')), 'class="btn btn-primary"'); ?> 
             <?php echo anchor('admin/admission', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Students')), 'class="btn btn-primary"'); ?> 
        </div>
    </div>

    <div class="block-fluid">
         <?php
             $attributes = array('class' => 'form-horizontal', 'id' => '');
             echo form_open_multipart(current_url(), $attributes);
         ?>
        <div class='form-group'>
            <div class="col-md-2" for='first_name'>First Name <span class='required'>*</span></div><div class="col-md-10">
                 <?php echo form_input('first_name', $result->first_name, 'id="first_name_"  class="form-control" '); ?>
                 <?php echo form_error('first_name'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-2" for='last_name'>Last Name <span class='required'>*</span></div><div class="col-md-10">
                 <?php echo form_input('last_name', $result->last_name, 'id="last_name_"  class="form-control" '); ?>
                 <?php echo form_error('last_name'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-2" for='dob'>Dob <span class='required'>*</span></div><div class="col-md-10">
                <input id='dob' type='text' name='dob' maxlength='' class='form-control datepicker' value="<?php echo set_value('dob', (isset($result->dob)) ? $result->dob : ''); ?>"  />
                <?php echo form_error('dob'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class='col-md-2'>Gender <span class='required'>*</span></div><div class="col-md-10">
                <input type='radio' name='gender' id='gender_0' value='male' <?php echo preset_radio('gender', 'male', (isset($result->gender)) ? $result->gender : 'male' ); ?> > <div class='col-md-2inline' for='gender_0'> Male </div>
                <input type='radio' name='gender' id='gender_1' value='female' <?php echo preset_radio('gender', 'female', (isset($result->gender)) ? $result->gender : 'male' ); ?> > <div class='col-md-2inline' for='gender_1'> Female </div>
                <?php echo form_error('gender'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-2" for='email'>Email <span class='required'>*</span></div><div class="col-md-10">
                 <?php echo form_input('email', $result->email, 'id="email_"  class="form-control" '); ?>
                 <?php echo form_error('email'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-2" for='year'>Year <span class='required'>*</span></div>
            <div class="col-md-10">
                 <?php
                     $items = array('' => '',
                             "0" => "Spanish",
                             "1" => "English",
                     );
                     echo form_dropdown('year', $items, (isset($result->year)) ? $result->year : '', ' class="chzn-select" data-placeholder="Select Options..." ');
                     echo form_error('year');
                 ?>
            </div></div>

        <div class='form-group'>
            <div class="col-md-2" for='class'>Class <span class='required'>*</span></div>
            <div class="col-md-10">
                 <?php echo form_dropdown('class', $school_classes, (isset($result->class)) ? $result->class : '', ' class="chzn-select" data-placeholder="Select  Options..." ');
                 ?>		
                 <?php echo form_error('class'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-2" for='stream'>Stream <span class='required'>*</span></div>
            <div class="col-md-10">
                 <?php echo form_dropdown('stream', $class_stream, (isset($result->stream)) ? $result->stream : '', ' class="chzn-select" data-placeholder="Select  Options..." ');
                 ?>		
                 <?php echo form_error('stream'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-2" for='parent_first_name'>Parent First Name <span class='required'>*</span></div><div class="col-md-10">
                 <?php echo form_input('parent_first_name', $result->parent_first_name, 'id="parent_first_name_"  class="form-control" '); ?>
                 <?php echo form_error('parent_first_name'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-2" for='parent_last_name'>Parent Last Name <span class='required'>*</span></div><div class="col-md-10">
                 <?php echo form_input('parent_last_name', $result->parent_last_name, 'id="parent_last_name_"  class="form-control" '); ?>
                 <?php echo form_error('parent_last_name'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-2" for='parent_phone'>Parent Phone <span class='required'>*</span></div>
            <div class="col-md-10">
                 <?php echo form_input('parent_phone', $result->parent_phone, 'id="parent_phone_"  class="form-control" '); ?>
                 <?php echo form_error('parent_phone'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-2" for='parent_email'>Parent Email <span class='required'>*</span></div><div class="col-md-10">
                 <?php echo form_input('parent_email', $result->parent_email, 'id="parent_email_"  class="form-control" '); ?>
                 <?php echo form_error('parent_email'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-2" for='address'>Address <span class='required'>*</span></div><div class="col-md-10">
                <textarea id="address"  class="autosize-transition form-control "  name="address"  /><?php echo set_value('address', (isset($result->address)) ? htmlspecialchars_decode($result->address) : ''); ?></textarea>
                <?php echo form_error('address'); ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-2"></div>
            <div class="col-md-10">
                 <?php echo form_submit('submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
                 <?php echo anchor('admin/admission', 'Cancel', 'class="btn  btn-default"'); ?>
            </div>
        </div>
        <?php echo form_close(); ?>
        <div class="clearfix"></div>
    </div>
</div>
</div>