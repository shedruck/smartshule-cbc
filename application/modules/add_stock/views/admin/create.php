 <script type="text/javascript">
  function totals(){
      //grab the values
      quantity = document.getElementById('quantity').value;
      unit_price = document.getElementById('unit_price').value;

      document.getElementById('total').value = parseFloat(quantity) * parseFloat(unit_price);
  }
  </script>
  
    <div class="col-md-8">
 <div class="head">
                    <div class="icon"><span class="icosg-target1"></span></div>
                    <h2> Stocks Management</h2> 
                     <div class="right">                            
						 <?php echo anchor( 'admin/add_stock/create/' , '<i class="glyphicon glyphicon-plus">
                </i> Add Stock ', 'class="btn btn-primary"');?> 
			    <?php echo anchor( 'admin/add_stock/' , '<i class="glyphicon glyphicon-list">
                </i> List All', 'class="btn btn-primary"');?>
			  <div class="btn-group">
					<button class="btn dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-cog"></i> Options</button>
					
					<ul class="dropdown-menu pull-right">
					  <li><a class=""  href="<?php echo base_url('admin/items'); ?>"><i class="glyphicon glyphicon-list-alt"></i> Manage Items</a></li>
					   <li class="divider"></li>
					  <li><a href="<?php echo base_url('admin/items_category'); ?>"><i class="glyphicon glyphicon-fullscreen"></i> Manage Items Category</a></li>
					  <li class="divider"></li>
					  <li><a href="<?php echo base_url('admin/add_stock/create'); ?>"><i class="glyphicon glyphicon-plus"></i> Add Stock</a></li>
					    <li class="divider"></li>
					  <li><a href="<?php echo base_url('admin/stock_taking'); ?>"><i class="glyphicon glyphicon-edit"></i> Stock Taking</a></li>
					   <li class="divider"></li>
					  <li><a href="<?php echo base_url('admin/inventory'); ?>"><i class="glyphicon glyphicon-folder-open"></i> Inventory Listing</a></li>
					</ul>
				</div>
			
                     </div>    					
                </div>             
               <div class="block-fluid">
  
 <?php if(empty($product)):?> 
 <h4>No Item Added, kindly add Item first <a href="<?php echo base_url('admin/items/create'); ?>">Add Here</a></h4>
 <?php else:?> 
  
  
<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>
<div class='form-group'>
	<div class="col-md-3" for='start_date'>Date <span class='required'>*</span></div>
	<div class="col-md-6">
	 
	<div id="datetimepicker1" class="input-group date form_datetime">
	<?php echo form_input('day', $add_stock_m->day > 0 ? date('d M Y', $add_stock_m->day) : $add_stock_m->day, 'class="validate[required] form-control datepicker col-md-4"'); ?>
	 <span class="input-group-addon "><i class="glyphicon glyphicon-calendar"></i></span>
 </div>
 <?php echo form_error('day'); ?>

</div>
</div>	 
            


<div class='form-group'>
	<div class="col-md-3" for='product_id'>Product Name <span class='required'>*</span></div>
<div class="col-md-6">
                 <?php 
						 echo form_dropdown('product_id', array(''=>'Select Item')+(array)$product,  (isset($products_m->product_id)) ? $products_m->product_id : ''     ,   ' class="select populate" data-placeholder="Select Options..." ');
						 echo form_error('product_id'); ?>
</div></div>

<div class='form-group'>
	<div class=' col-md-3' for='quantity'>Quantity <span class='required'>*</span></div>
        <div class="col-md-6">
	<?php echo form_input('quantity' ,$add_stock_m->quantity , 'id="quantity"  class="" id="focusedinput" onblur="totals()"' );?>
 	<?php echo form_error('quantity'); ?>
</div>
</div>

<div class='form-group'>
	<div class=' col-md-3' for='unit_price'>Unit Price <span class='required'>*</span></div>
        <div class="col-md-6">
	<?php echo form_input('unit_price' ,$add_stock_m->unit_price , 'id="unit_price"  class="" id="focusedinput" onblur="totals()"' );?>
 	<?php echo form_error('unit_price'); ?>
</div>
</div>

<div class='form-group'>
	<div class=' col-md-3' for='total'>Total ( Buying Price ) </div>
        <div class="col-md-6">
	<?php echo form_input('total' ,$add_stock_m->total , 'id="total"  class="" id="focusedinput" ' );?>
 	<?php echo form_error('total'); ?>
</div>
</div>
<div class='form-group'>
	<div class="col-md-3" for='user_id'>Person Responsible <span class='required'>*</span></div>
<div class="col-md-6">
                 <?php 
				  $staff=$this->ion_auth->get_admins();
				  $member=$this->ion_auth->get_members();
				  $teachers=$this->ion_auth->get_teachers_and_title();
				  $h_teachers=$this->ion_auth->get_headteachers();
				  $managers=$this->ion_auth->get_managers();
				 
						 echo form_dropdown('user_id', array(''=>'Select Person Responsible')+$staff+$member+$teachers+$h_teachers+$managers,  (isset($add_stock_m->user_id)) ? $add_stock_m->user_id : ''     ,   ' class="select populate" ');
						 echo form_error('user_id'); ?>
</div></div>

<div class='form-group'>
	<div class=' col-md-3' for='receipt'><?php echo lang( ($updType == 'edit')  ? "web_file_edit" : "web_file_create" )?> (receipt) </div>
 <div class="col-md-6">
	<input id='receipt' type='file' name='receipt' />

	<?php if ($updType == 'edit'): ?>
	<a href='/public/uploads/add_stock/files/<?php echo $add_stock_m->receipt?>' />Download actual file (receipt)</a>
	<?php endif ?>

	<br/><?php echo form_error('receipt'); ?>
	<?php  echo ( isset($upload_error['receipt'])) ?  $upload_error['receipt']  : ""; ?>
</div>
</div>
<div class="widget">
                    <div class="head dark">
                        <div class="icon"><i class="icos-pencil"></i></div>
                        <h2>Description</h2>
                    </div>
                    <div class="block-fluid editor">
                        
                        <textarea id="wysiwyg"  name="description" style="height: 300px;">
                          <?php echo set_value('description', (isset($result->description)) ? htmlspecialchars_decode($result->description) : ''); ?></textarea>
	<?php echo form_error('description'); ?>
                        
                    </div>
                   
                </div> 
	
<div class='form-group'>
	<div class="col-md-6">
		

		<?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
		<?php echo anchor('admin/add_stock','Cancel','class="btn btn-danger"');?>
	</div>
	</div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 <?php endif;?> 
 </div>
            </div>
        </div>
    </div>
	
	
		
