<div class="col-md-8">
        <div class="head"> 
             <div class="icon"><span class="icosg-target1"></span></div>		
            <h2>  Subcounties  </h2>
             <div class="right"> 
             <?php echo anchor( 'admin/subcounties/create' , '<i class="glyphicon glyphicon-plus">
                </i> '.lang('web_add_t', array(':name' => 'Subcounties')), 'class="btn btn-primary"');?> 
              <?php echo anchor( 'admin/subcounties' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Subcounties')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
               
				   <div class="block-fluid">

<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>
<div class='form-group'>
	<div class="col-md-3" for='county'>County <span class='required'>*</span></div>
<div class="col-md-6">
                <?php 
				
				$items = $this->ion_auth->populate('counties','id','name');		
     echo form_dropdown('county', array(''=>'Select County')+$items,  (isset($result->county)) ? $result->county : ''     ,   ' class="chzn-select" data-placeholder="Select Options..." ');
     echo form_error('county'); ?>
</div></div>

<div class='form-group'>
	<div class="col-md-3" for='subcounty'>Subcounty <span class='required'>*</span></div><div class="col-md-6">
	<?php echo form_input('subcounty' ,$result->subcounty , 'id="subcounty_"  class="form-control" ' );?>
 	<?php echo form_error('subcounty'); ?>
</div>
</div>

<div class='form-group'><div class="col-md-3"></div><div class="col-md-6">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo anchor('admin/subcounties','Cancel','class="btn  btn-default"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
            </div>