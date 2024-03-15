<div class="col-md-8">
        <div class="head"> 
             <div class="icon"><span class="icosg-target1"></span></div>		
            <h2>  Library Settings  </h2>
             <div class="right"> 
             <?php echo anchor( 'admin/library_settings/create' , '<i class="glyphicon glyphicon-plus">
                </i> '.lang('web_add_t', array(':name' => 'Library Settings')), 'class="btn btn-primary"');?> 
              <?php echo anchor( 'admin/library_settings' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Library Settings')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
               
				   <div class="block-fluid">

<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>
<div class='form-group'>
	<div class="col-md-3" for='fine'>Fine per day <span class='required'>*</span></div><div class="col-md-4">
	<?php echo form_input('fine' ,$result->fine , 'id="fine_"  class="form-control" ' );?>
 	<?php echo form_error('fine'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='book_duration'>Book Duration (Days) <span class='required'>*</span></div><div class="col-md-4">
	<?php echo form_input('book_duration' ,$result->book_duration , 'id="book_duration_"  class="form-control" placeholder="E.g 7, 10, 14 etc"' );?>
 	<?php echo form_error('book_duration'); ?>
	<span class=''>Borrower to return book after</span>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='limit'>Borrow Limit <span class='required'>*</span></div><div class="col-md-9">
	<?php echo form_input('limit' ,$result->limit , 'id="limit" style="width:200px;" class="form-control " placeholder="E.g 3, 5 etc"' );?>
 	<?php echo form_error('limit'); ?>
	<span class=''><br>Total number of books to be borrowed per student</span>
</div>
</div>

<div class='form-group'><div class="col-md-2"></div><div class="col-md-10">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo anchor('admin/library_settings','Cancel','class="btn  btn-default"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
            </div>