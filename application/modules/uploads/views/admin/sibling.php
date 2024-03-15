<div class="col-md-8">
        <div class="head"> 
             <div class="icon"><span class="icosg-target1"></span></div>		
            <h2>  Uploads  </h2>
             <div class="right"> 
             
              <?php echo anchor( 'admin/uploads' , '<i class="glyphicon glyphicon-caret-left">
                </i> Back', 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
               
				   <div class="block-fluid">

<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>
<div class='form-group'>
<div class="col-md-3" for='parent_id'>Select Student <span class='required'>*</span></div>
		<div class="col-md-4">
	 <select name="student" class="select select2-offscreen" style="" tabindex="-1">
		<option value="">Select Student</option>
		<?php
		$data = $this->ion_auth->students_full_details();
		foreach ($data as $key => $value):
				?>
				<option value="<?php echo $key; ?>"><?php echo $value ?></option>
		<?php endforeach; ?>
	</select>
		</div>					
</div>

  <div class='form-group'>
		<div class="col-md-3" for='parent_id'>Select Parent to Assign<span class='required'>*</span></div>
		<div class="col-md-4">
           <?php echo form_dropdown('parent', $parents, '', ' class="select" ');?><span class="bottom">Required</span>		
		</div>
	</div>
						

<div class='form-group'><div class="col-md-3"></div><div class="col-md-6">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo anchor('admin/uploads','Cancel','class="btn  btn-default"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
            </div>