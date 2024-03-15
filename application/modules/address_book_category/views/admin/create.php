<div class="col-md-8">
 <div class="head">
                    <div class="icon"><span class="icosg-target1"></span></div>
                    <h2>Address Book Category</h2> 
                     <div class="right">                            
                       
             <?php echo anchor( 'admin/address_book_category/create/'.$page, '<i class="glyphicon glyphicon-plus"></i>'.lang('web_add_t', array(':name' => 'New Category')), 'class="btn btn-primary"');?>
			     <?php echo anchor( 'admin/address_book_category' , '<i class="glyphicon glyphicon-list">
                </i>'.lang('web_list_all', array(':name' => ' Category')), 'class="btn btn-primary"');?> 
			
                     </div>    					
                </div>
       <div class="block-fluid">

<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>
<div class='form-group'>
	<label class='col-md-2' for='title'>Title </label><div class="col-md-6">
	<?php echo form_input('title' ,$result->title , 'id="title_"  class="form-control" ' );?>
 	<?php echo form_error('title'); ?>
</div>
</div>

<div class='form-group'><label class="col-md-2"></label><div class="col-md-6">
    
<?php echo anchor('admin/address_book_category_category','Back To Listing','class="btn  btn-default"');?>
    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-blue btn-small''" : "id='submit' class='btn btn-success'")); ?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
            </div>
       