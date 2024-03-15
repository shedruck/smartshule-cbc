<div class="col-md-8">
        <div class="head"> 
             <div class="icon"><span class="icosg-target1"></span></div>		
            <h2>  Return Book Fund  </h2>
             <div class="right"> 
             <?php echo anchor( 'admin/return_book_fund/create' , '<i class="glyphicon glyphicon-plus">
                </i> '.lang('web_add_t', array(':name' => 'Return Book Fund')), 'class="btn btn-primary"');?> 
              <?php echo anchor( 'admin/return_book_fund' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Return Book Fund')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
               
				   <div class="block-fluid">

<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>
<div class='form-group'>
	<div class="col-md-2" for='return_date'>Return Date <span class='required'>*</span></div><div class="col-md-10">
	<input id='return_date' type='text' name='return_date' maxlength='' class='form-control datepicker' value="<?php echo set_value('return_date', (isset($result->return_date)) ? $result->return_date : ''); ?>"  />
 	<?php echo form_error('return_date'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-2" for='book'>Book </div>
<div class="col-md-10">
                <?php $items = array('' =>'', 
"0"=>"Spanish",
"1"=>"English",
);		
     echo form_dropdown('book', $items,  (isset($result->book)) ? $result->book : ''     ,   ' class="chzn-select" data-placeholder="Select Options..." ');
     echo form_error('book'); ?>
</div></div>

<div class='form-group'><div class="col-md-2"></div><div class="col-md-10">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo anchor('admin/return_book_fund','Cancel','class="btn  btn-default"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
            </div>