<div class="col-md-8">
        <div class="head"> 
             <div class="icon"><span class="icosg-target1"></span></div>		
            <h2>  Book List  </h2>
             <div class="right"> 
             <?php echo anchor( 'admin/book_list/create' , '<i class="glyphicon glyphicon-plus">
                </i> '.lang('web_add_t', array(':name' => 'Book List')), 'class="btn btn-primary"');?> 
              <?php echo anchor( 'admin/book_list' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Book List')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
               
				   <div class="block-fluid">
<?php echo validation_errors()?>
<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>
<div class='form-group'>
	<div class="col-md-3" for='thumbnail'><?php echo lang( ($updType == 'edit')  ? "web_image_edit" : "web_image_create" )?> (thumbnail) <span class='required'>*</span></div>
<div class="col-md-6">
	<?php if ($updType == 'edit'): ?>
		 <img src='/public/uploads/book_list/img/thumbs/<?php echo $result->thumbnail?>' /> 
	<?php endif ?>

	<input id='thumbnail' type='file'  class="col-md-5" name='userfile' />

	<br/><?php echo form_error('thumbnail'); ?>
	<?php  echo ( isset($upload_error['thumbnail'])) ?  $upload_error['thumbnail']  : ""; ?>
</div>
</div>

  

<div class='form-group'>
	<div class="col-md-3" for='class'>Class <span class='required'>*</span></div>
<div class="col-md-6">
<?php echo form_dropdown('class', array('' => 'Select class') + $this->classes, '', 'id="class_" class="xsel validate[required] select select-2"'); ?>
                                    <?php echo form_error('class'); ?>
             </select>
</div></div>

<div class='form-group'>
	<div class="col-md-3" for='subject'>Subject <span class='required'>*</span></div>
<div class="col-md-6">
             <select class="select select2-offscreen" name="subject" tabindex="-1">
                  <option value="">Select Subject</option>
                  <?php foreach($subjects as $subject){?>
                    <option value="<?php echo $subject->id?>"><?php echo $subject->name?></option>
                  <?php } ?>
             </select>
</div></div>

<div class='form-group'>
	<div class="col-md-3" for='book_name'>Book Name <span class='required'>*</span></div><div class="col-md-6">
	<?php echo form_input('book_name' ,$result->book_name , 'id="book_name_"  class="form-control" ' );?>
 	<?php echo form_error('book_name'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='publisher'>Publisher <span class='required'>*</span></div><div class="col-md-6">
	<?php echo form_input('publisher' ,$result->publisher , 'id="publisher_"  class="form-control" ' );?>
 	<?php echo form_error('publisher'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='price'>Price <span class='required'>*</span></div><div class="col-md-6">
	<?php echo form_input('price' ,$result->price , 'id="price_"  class="form-control" ' );?>
 	<?php echo form_error('price'); ?>
</div>
</div>


<div class='form-group'><div class="col-md-3"></div><div class="col-md-6">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo anchor('admin/book_list','Cancel','class="btn  btn-default"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
            </div>