<div class="col-md-8">
        <div class="head"> 
             <div class="icon"><span class="icosg-target1"></span></div>		
            <h2>  Registration Details  </h2>
             <div class="right"> 
             <?php echo anchor( 'admin/registration_details/create' , '<i class="glyphicon glyphicon-plus">
                </i> '.lang('web_add_t', array(':name' => 'Registration Details')), 'class="btn btn-primary"');?> 
              <?php echo anchor( 'admin/registration_details' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Registration Details')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
               
				   <div class="block-fluid">

<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>
<div class='form-group'>
	<div class="col-md-3" for='registration_no'>Registration No </div><div class="col-md-6">
	<?php echo form_input('registration_no' ,$result->registration_no , 'id="registration_no_"  class="form-control" ' );?>
 	<?php echo form_error('registration_no'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='date_reg'>Date Reg </div><div class="col-md-6">
	<?php echo form_input('date_reg' ,$result->date_reg , 'id="date_reg_"  class="form-control" ' );?>
 	<?php echo form_error('date_reg'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='institution_category'>Institution Category </div><div class="col-md-6">
	<?php echo form_input('institution_category' ,$result->institution_category , 'id="institution_category_"  class="form-control" ' );?>
 	<?php echo form_error('institution_category'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='institution_cluster'>Institution Cluster </div><div class="col-md-6">
	<?php echo form_input('institution_cluster' ,$result->institution_cluster , 'id="institution_cluster_"  class="form-control" ' );?>
 	<?php echo form_error('institution_cluster'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='county'>County </div><div class="col-md-6">
	<?php echo form_input('county' ,$result->county , 'id="county_"  class="form-control" ' );?>
 	<?php echo form_error('county'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='sub_county'>Sub County </div><div class="col-md-6">
	<?php echo form_input('sub_county' ,$result->sub_county , 'id="sub_county_"  class="form-control" ' );?>
 	<?php echo form_error('sub_county'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='ward'>Ward </div><div class="col-md-6">
	<?php echo form_input('ward' ,$result->ward , 'id="ward_"  class="form-control" ' );?>
 	<?php echo form_error('ward'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='institution_type'>Institution Type </div><div class="col-md-6">
	<?php echo form_input('institution_type' ,$result->institution_type , 'id="institution_type_"  class="form-control" ' );?>
 	<?php echo form_error('institution_type'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='education_system'>Education System </div><div class="col-md-6">
	<?php echo form_input('education_system' ,$result->education_system , 'id="education_system_"  class="form-control" ' );?>
 	<?php echo form_error('education_system'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='education_level'>Education Level </div><div class="col-md-6">
	<?php echo form_input('education_level' ,$result->education_level , 'id="education_level_"  class="form-control" ' );?>
 	<?php echo form_error('education_level'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='knec_code'>Knec Code </div><div class="col-md-6">
	<?php echo form_input('knec_code' ,$result->knec_code , 'id="knec_code_"  class="form-control" ' );?>
 	<?php echo form_error('knec_code'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='institution_accommodation'>Institution Accommodation </div><div class="col-md-6">
	<?php echo form_input('institution_accommodation' ,$result->institution_accommodation , 'id="institution_accommodation_"  class="form-control" ' );?>
 	<?php echo form_error('institution_accommodation'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='scholars_gender'>Scholars Gender </div><div class="col-md-6">
	<?php echo form_input('scholars_gender' ,$result->scholars_gender , 'id="scholars_gender_"  class="form-control" ' );?>
 	<?php echo form_error('scholars_gender'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='locality'>Locality </div><div class="col-md-6">
	<?php echo form_input('locality' ,$result->locality , 'id="locality_"  class="form-control" ' );?>
 	<?php echo form_error('locality'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='kra_pin'>Kra Pin </div><div class="col-md-6">
	<?php echo form_input('kra_pin' ,$result->kra_pin , 'id="kra_pin_"  class="form-control" ' );?>
 	<?php echo form_error('kra_pin'); ?>
</div>
</div>

<div class='form-group'><div class="col-md-3"></div><div class="col-md-6">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo anchor('admin/registration_details','Cancel','class="btn  btn-default"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
            </div>