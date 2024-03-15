<div class="col-md-8">
        <div class="head"> 
             <div class="icon"><span class="icosg-target1"></span></div>		
            <h2>  Mc Choices  </h2>
             <div class="right"> 
             <?php echo anchor( 'admin/mc_choices/create' , '<i class="glyphicon glyphicon-plus">
                </i> '.lang('web_add_t', array(':name' => 'Mc Choices')), 'class="btn btn-primary"');?> 
              <?php echo anchor( 'admin/mc_choices' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Mc Choices')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
               
				   <div class="block-fluid">

<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>
<div class='form-group'>
	<div class="col-md-3" for='question_id'>Question Id <span class='required'>*</span></div><div class="col-md-6">
	<?php echo form_input('question_id' ,$result->question_id , 'id="question_id_"  class="form-control" ' );?>
 	<?php echo form_error('question_id'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='choice'>Choice </div><div class="col-md-6">
	<?php echo form_input('choice' ,$result->choice , 'id="choice_"  class="form-control" ' );?>
 	<?php echo form_error('choice'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='state'>State </div><div class="col-md-6">
	<?php echo form_input('state' ,$result->state , 'id="state_"  class="form-control" ' );?>
 	<?php echo form_error('state'); ?>
</div>
</div>

<div class='form-group'><div class="col-md-3"></div><div class="col-md-6">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo anchor('admin/mc_choices','Cancel','class="btn  btn-default"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
            </div>