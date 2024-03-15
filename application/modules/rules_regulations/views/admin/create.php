<div class="col-md-8">
        <div class="head"> 
             <div class="icon"><span class="icosg-target1"></span></div>		
            <h2>  Rules Regulations  </h2>
             <div class="right"> 
             <?php echo anchor( 'admin/rules_regulations/create' , '<i class="glyphicon glyphicon-plus">
                </i> '.lang('web_add_t', array(':name' => 'Rules Regulations')), 'class="btn btn-primary"');?> 
              <?php echo anchor( 'admin/rules_regulations' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Rules Regulations')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
               
				   <div class="block-fluid">

<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>
<div class='form-group'>
	<div class="col-md-3" for='title'>Title </div><div class="col-md-6">
	<?php echo form_input('title' ,$result->title , 'id="title_"  class="form-control" ' );?>
 	<?php echo form_error('title'); ?>
</div>
</div>

<div class='widget' >
  <div class='head dark'>
        <div class='icon'><i class='icos-pencil'></i></div>
	<h2>Content </h2></div>
	 <div class="block-fluid editor"  >
	<textarea id="content"   style="min-height: 300px !important;" rows="15" class=" wysiwyg "  name="content"  /><?php echo set_value('content', (isset($result->content)) ? htmlspecialchars_decode($result->content) : ''); ?>

	</textarea>
	<?php echo form_error('content'); ?>
</div>
</div>

<div class='form-group'><div class="col-md-3"></div><div class="col-md-6">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo anchor('admin/rules_regulations','Cancel','class="btn  btn-default"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
            </div>