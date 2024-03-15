<div class="col-md-8">
        <div class="head"> 
             <div class="icon"><span class="icosg-target1"></span></div>		
            <h2>  License Renewal  </h2>
             
                </div>
         	                    
               
				   <div class="block-fluid">

<?php echo form_open(current_url()) ?>

<div class='form-group'>
	<div class="col-md-3" for='name'>Update Status <span class='required'>*</span></div><div class="col-md-6">
	<select name="status" class="select select-2">
        <option value="0">Active</option>
        <option value="1">Inactive</option>
    </select>
</div>
</div>



<div class='form-group'><div class="col-md-3"></div><div class="col-md-6">
    
<button class="btn btn-sm btn-success">Update Status</button>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
            </div>