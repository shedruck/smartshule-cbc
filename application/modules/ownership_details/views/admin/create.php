<div class="col-md-8">
        <div class="head"> 
             <div class="icon"><span class="icosg-target1"></span></div>		
            <h2>  Ownership Details  </h2>
             <div class="right"> 
             <?php echo anchor( 'admin/ownership_details/create' , '<i class="glyphicon glyphicon-plus">
                </i> '.lang('web_add_t', array(':name' => 'Ownership Details')), 'class="btn btn-primary"');?> 
              <?php echo anchor( 'admin/ownership_details' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Ownership Details')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
               
				   <div class="block-fluid">

<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>
<div class='form-group'>
	<div class="col-md-3" for='ownership'>Ownership </div><div class="col-md-6">
	<?php echo form_input('ownership' ,$result->ownership , 'id="ownership_"  class="form-control" ' );?>
 	<?php echo form_error('ownership'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='proprietor'>Proprietor </div><div class="col-md-6">
	<?php echo form_input('proprietor' ,$result->proprietor , 'id="proprietor_"  class="form-control" ' );?>
 	<?php echo form_error('proprietor'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='ownership_type'>Ownership Type </div><div class="col-md-6">
	<?php echo form_input('ownership_type' ,$result->ownership_type , 'id="ownership_type_"  class="form-control" ' );?>
 	<?php echo form_error('ownership_type'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='certificate_no'>Certificate No </div><div class="col-md-6">
	<?php echo form_input('certificate_no' ,$result->certificate_no , 'id="certificate_no_"  class="form-control" ' );?>
 	<?php echo form_error('certificate_no'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='town'>Town </div><div class="col-md-6">
	<?php echo form_input('town' ,$result->town , 'id="town_"  class="form-control" ' );?>
 	<?php echo form_error('town'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='police_station'>Police Station </div><div class="col-md-6">
	<?php echo form_input('police_station' ,$result->police_station , 'id="police_station_"  class="form-control" ' );?>
 	<?php echo form_error('police_station'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='health_facility'>Health Facility </div><div class="col-md-6">
	<?php echo form_input('health_facility' ,$result->health_facility , 'id="health_facility_"  class="form-control" ' );?>
 	<?php echo form_error('health_facility'); ?>
</div>
</div>

<div class='form-group'><div class="col-md-3"></div><div class="col-md-6">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo anchor('admin/ownership_details','Cancel','class="btn  btn-default"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
            </div>