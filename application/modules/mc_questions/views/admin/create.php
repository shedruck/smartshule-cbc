<div class="col-md-8">
        <div class="head"> 
             <div class="icon"><span class="icosg-target1"></span></div>		
            <h2>  Mc Questions  </h2>
             <div class="right"> 
             <?php echo anchor( 'admin/mc_questions/create' , '<i class="glyphicon glyphicon-plus">
                </i> '.lang('web_add_t', array(':name' => 'Mc Questions')), 'class="btn btn-primary"');?> 
              <?php echo anchor( 'admin/mc_questions' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Mc Questions')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
               
				   <div class="block-fluid">

<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>
<div class='form-group'>
	<div class="col-md-3" for='mc'>Mc </div><div class="col-md-6">
	<?php echo form_input('mc' ,$result->mc , 'id="mc_"  class="form-control" ' );?>
 	<?php echo form_error('mc'); ?>
</div>
</div>

<div class='widget'>
  <div class='head dark'>
        <div class='icon'><i class='icos-pencil'></i></div>
	<h2>Question <span class='required'>*</span></h2></div>
	 <div class="block-fluid editor">
	<textarea id="question"   style="height: 300px;" class=" wysiwyg "  name="question"  /><?php echo set_value('question', (isset($result->question)) ? htmlspecialchars_decode($result->question) : ''); ?></textarea>
	<?php echo form_error('question'); ?>
</div>
</div>

<div class='form-group'><div class="col-md-3"></div><div class="col-md-6">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo anchor('admin/mc_questions','Cancel','class="btn  btn-default"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
            </div>