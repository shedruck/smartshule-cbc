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
                    <h2> Stock Taking </h2> 
                     <div class="right">                            
						 <?php echo anchor( 'admin/stock_taking/create/' , '<i class="glyphicon glyphicon-plus">
                </i> Take Stock ', 'class="btn btn-primary"');?> 
			
             <?php echo anchor( 'admin/stock_taking/' , '<i class="glyphicon glyphicon-list">
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

<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>
 
 <div class='form-group'>
	<div class="col-md-2" for='start_date'>Date <span class='required'>*</span></div>
	<div class="col-md-10">
	<div id="datetimepicker1" class="input-group date form_datetime">
	 <input type="text" class="col-md-10  datepicker" id='stock_date' style="" name='stock_date' value="<?php echo set_value('stock_date', (isset($add_stock_m->stock_date)) ? $add_stock_m->stock_date : ''); ?>"><span class="input-group-addon "><i class="glyphicon glyphicon-calendar"></i></span>
 	<?php echo form_error('stock_date'); ?>
</div>
</div>
</div>	
  
<div class='form-group'>
	<div class="col-md-2" for='product_id'>Product Name </div>
<div class="col-md-10">
                 <?php 
						 echo form_dropdown('product_id', array(0=>'Select Item')+(array)$product,  (isset($products_m->product_id)) ? $products_m->product_id : ''     ,   ' class="select" placeholder="Select Options..." ');
						 echo form_error('product_id'); ?>
</div></div>

<div class='form-group'>
	<div class=' col-md-2' for='closing_stock'>Closing Stock </div>
        <div class="col-md-6">
	<?php echo form_input('closing_stock' ,$stock_taking_m->closing_stock , 'id="closing_stock_"  class="" id="focusedinput" ' );?>
 	<?php echo form_error('closing_stock'); ?>
</div>
</div>
<div class="widget">
                    <div class="head dark">
                        <div class="icon"><i class="icos-pencil"></i></div>
                        <h2>Description</h2>
                    </div>
                    <div class="block-fluid editor">
                        
                        <textarea id="wysiwyg"  name="description" style="height: 300px;">
                         <?php echo set_value('comment', (isset($stock_taking_m->comment)) ? htmlspecialchars_decode($stock_taking_m->comment) : ''); ?></textarea>   
					<?php echo form_error('comment'); ?> </textarea>

                        
                    </div>
                   
                </div> 
	
<div class='form-group'>
	<div class="col-md-10">
		

		<?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
		<?php echo anchor('admin/stock_taking','Cancel','class="btn btn-danger"');?>
	</div>
	</div>

<?php echo form_hidden('page',set_value('page', $page)); ?>

<?php if ($updType == 'edit'): ?>
	<?php echo form_hidden('id',$stock_taking_m->id); ?>
<?php endif ?>

<?php echo form_close(); ?>

</div> 
</div> 

 