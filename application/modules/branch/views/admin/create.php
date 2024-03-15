<div class="col-md-8">
        <div class="head"> 
             <div class="icon"><span class="icosg-target1"></span></div>		
            <h2>  Branch  </h2>
             <div class="right"> 
             <?php echo anchor( 'admin/branch/create' , '<i class="glyphicon glyphicon-plus">
                </i> '.lang('web_add_t', array(':name' => 'Branch')), 'class="btn btn-primary"');?> 
              <?php echo anchor( 'admin/branch' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Branch')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
               
				   <div class="block-fluid">

<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>
<div class='form-group'>
	<div class="col-md-3" for='name'>Name </div><div class="col-md-6">
	<?php echo form_input('name' ,$result->name , 'id="name_"  class="form-control" ' );?>
 	<?php echo form_error('name'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='location'>Location </div><div class="col-md-6">
	<?php echo form_input('location' ,$result->location , 'id="location_"  class="form-control" ' );?>
 	<?php echo form_error('location'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='url'>URL </div><div class="col-md-6">
	<?php echo form_input('url' ,$result->url , 'id="url_"  class="form-control" ' );?>
 	<?php echo form_error('url'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='client_id'>Client Id </div><div class="col-md-6">
	<?php echo form_input('client_id' ,$result->client_id , 'id="client_id_"  class="form-control" ' );?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='secret'>Client Secret </div><div class="col-md-6">
	<?php echo form_input('client_secret' ,$result->client_secret , 'id="secret_"  class="form-control" ' );?>
  
</div>
</div>





<div class='widget'>
  <div class='head dark'>
        <div class='icon'><i class='icos-pencil'></i></div>
	<h2>Description </h2></div>
	 <div class="block-fluid editor">
	<textarea id="description"   style="height: 300px;" class=" wysiwyg "  name="description"  /><?php echo set_value('description', (isset($result->description)) ? htmlspecialchars_decode($result->description) : ''); ?></textarea>
	<?php echo form_error('description'); ?>
</div>
</div>

<div class='form-group'><div class="col-md-3"></div><div class="col-md-6">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo anchor('admin/branch','Cancel','class="btn  btn-default"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
            </div>