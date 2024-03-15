<div class="col-md-2">&nbsp;</div>
<div class="col-md-9 card-box table-responsive">
    <div class="head"> 
        <div class="icon"><span class="icosg-target1"></span></div>		
        <h2> <?php echo isset($type) ? $type : ' Add ' ?> Assignment 
            <div class="pull-right"> 
                <?php echo anchor('trs/assignments', '<i class="mdi mdi-reply">
                </i> ' . lang('web_list_all', array(':name' => 'Assignments')), 'class="btn btn-primary"'); ?> 
            </div>
        </h2>
    </div>
    <div class="clearfix"></div><hr>
    <div class="block-fluid">
        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo form_open_multipart(current_url(), $attributes);
        ?>
        <div class='form-group'>
            <div class="col-md-3" for='title'>Title <span class='required'>*</span></div>
            <div class="col-md-6">
                <?php echo form_input('title', $result->title, 'id="title"  class="form-control" '); ?>
                <?php echo form_error('title'); ?>
            </div>
        </div>
		
		<div class='form-group'>
            <div class="col-md-3" for='title'>Subject / Learning Area <span class='required'>*</span></div>
            <div class="col-md-6">
               <?php 
					 $items = array('' =>'Select Subject');		
					 echo form_dropdown('subject', $items+$subjects,  (isset($result->subject)) ? $result->subject : '',' id="subject" class="select" data-placeholder="Select Options..." ');
					 echo form_error('subject'); 
				 ?>
            </div>
        </div>
		
		<div class='form-group'>
            <div class="col-md-3" for='topic'>Topic / Strand <span class='required'>*</span></div>
            <div class="col-md-6">
                <?php echo form_input('topic', $result->topic, 'id="topic"  class="form-control" '); ?>
                <?php echo form_error('topic'); ?>
            </div>
        </div>
		
		<div class='form-group'>
            <div class="col-md-3" for='title'>Subtopic / Sub-strand </div>
            <div class="col-md-6">
                <?php echo form_input('subtopic', $result->subtopic, 'id="subtopic"  class="form-control" '); ?>
                <?php echo form_error('subtopic'); ?>
            </div>
        </div>
		
        <div class='form-group'>
            <div class="col-md-3" for='start_date'>Start Date <span class='required'>*</span></div><div class="col-md-6">
                <div id="datetimepicker1" class="input-group date form_datetime">
				    <input type="text" name="start_date" value="<?php if($result->start_date) echo date('d M Y',$result->start_date);?>" class="date form-control datepicker col-md-3" >
                    
                    <span class="input-group-addon "><i class="mdi mdi-calendar"></i></span>
                </div>
                <?php echo form_error('start_date'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-3" for='end_date'>End Date <span class='required'>*</span></div><div class="col-md-6">
                <div id="datetimepicker1" class="input-group date form_datetime">
				       <input value="<?php if($result->end_date) echo date('d M Y',$result->end_date);?>" type="text" name="end_date" class="date form-control datepicker col-md-3" >
					   
                  
                    <span class="input-group-addon "><i class="mdi mdi-calendar"></i></span>
                </div>
                <?php echo form_error('end_date'); ?>
            </div>
        </div>         
        <div class='form-group'>
            <div class="col-md-3" for='document'>Upload Document </div>
            <div class="col-md-8">
                <input id='document' type='file' name='document' />
                <br/><?php echo form_error('document'); ?>
                <?php echo isset($type) ? 'File: ' . $result->document : ' ' ?>
                <?php echo ( isset($upload_error['document'])) ? $upload_error['document'] : ""; ?>
            </div>
        </div>

        <div class='widget'>
            <div class='head dark'>
                <div class='icon'><i class='icos-pencil'></i></div>
                <h4>Assignment - Type or past the assignment here </h4></div>
            <div class="block-fluid editor">
                <textarea id="assignment" class="summernote ckeditor form-control"  name="assignment"  /><?php echo set_value('assignment', (isset($result->assignment)) ? htmlspecialchars_decode($result->assignment) : ''); ?></textarea>
                <?php echo form_error('assignment'); ?>
            </div>
        </div>

        <div class='widget'>
            <div class='head dark'>
                <div class='icon'><i class='icos-pencil'></i></div>
                <h4>Comment </h4></div>
            <div class="block-fluid editor">
                <textarea id="comment" class="summernote ckeditor form-control"  name="comment"  /><?php echo set_value('comment', (isset($result->comment)) ? htmlspecialchars_decode($result->comment) : ''); ?></textarea>
                <?php echo form_error('comment'); ?>
                <?php
                $ext = isset($ex) ? $ex : 0;
                echo form_hidden('extras', set_value('extras', $ext));
                ?>
            </div>
        </div>
		<hr>
        <div class='form-group'><div class="col-md-3"></div><div class="col-md-8">
                <?php echo anchor('trs/assignments', 'Cancel', 'class="btn  btn-default"'); ?>
                <?php echo form_submit('submit', 'Save', "id='submit' class='btn btn-primary'"); ?>
            </div>
        </div>
        <?php echo form_close(); ?>
        <div class="clearfix"></div>
    </div>
</div>