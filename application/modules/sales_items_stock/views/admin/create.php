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
            <h2>  Sales Items Stock  </h2>
             <div class="right"> 
             <?php echo anchor( 'admin/sales_items_stock/create' , '<i class="glyphicon glyphicon-plus">
                </i> '.lang('web_add_t', array(':name' => 'Sales Items Stock')), 'class="btn btn-primary"');?> 
              <?php echo anchor( 'admin/sales_items_stock' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Sales Items Stock')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
               
				   <div class="block-fluid">

<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>
<div class='form-group'>
	<div class="col-md-3" for='purchase_date'>Purchase Date <span class='required'>*</span></div><div class="col-md-6">
	<div id="datetimepicker1" class="input-group date form_datetime">
		<?php echo form_input('purchase_date', $result->purchase_date > 0 ? date('d M Y', $result->purchase_date) : $result->purchase_date, 'class="validate[required] form-control datepicker col-md-4"'); ?>
	
	 <span class="input-group-addon "><i class="glyphicon glyphicon-calendar"></i></span>
 </div>
 	<?php echo form_error('purchase_date'); ?>
</div>
</div>

<div class='form-group'>
	<div class=' col-md-3' for='quantity'>Quantity <span class='required'>*</span></div>
        <div class="col-md-6">
	<?php echo form_input('quantity' ,$result->quantity , 'id="quantity"  class="" id="focusedinput" onblur="totals()"' );?>
 	<?php echo form_error('quantity'); ?>
</div>
</div>

<div class='form-group'>
	<div class=' col-md-3' for='unit_price'>Unit Price <span class='required'>*</span></div>
        <div class="col-md-6">
	<?php echo form_input('unit_price' ,$result->unit_price , 'id="unit_price"  class="" id="focusedinput" onblur="totals()"' );?>
 	<?php echo form_error('unit_price'); ?>
</div>
</div>

<div class='form-group'>
	<div class=' col-md-3' for='total'>Total ( Buying Price ) <span class='required'>*</span></div>
        <div class="col-md-6">
	<?php echo form_input('total' ,$result->total , 'id="total"  class="" id="focusedinput" ' );?>
 	<?php echo form_error('total'); ?>
</div>
</div>
<div class='form-group'>
	<div class="col-md-3" for='person_responsible'>Person Responsible <span class='required'>*</span></div>
<div class="col-md-6">
                 <?php 
				  $staff=$this->ion_auth->get_admins();
				  $member=$this->ion_auth->get_members();
				  $teachers=$this->ion_auth->get_teachers_and_title();
				  $h_teachers=$this->ion_auth->get_headteachers();
				  $managers=$this->ion_auth->get_managers();
				 
						 echo form_dropdown('person_responsible', array(''=>'Select Person Responsible')+$staff+$member+$teachers+$h_teachers+$managers,  (isset($result->person_responsible)) ? $result->person_responsible : ''     ,   ' class="select populate" ');
						 echo form_error('person_responsible'); ?>
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

<div class='widget'>
  <div class='head dark'>
        <div class='icon'><i class='icos-pencil'></i></div>
	<h2>Description </h2></div>
	 <div class="block-fluid editor">
	<textarea id="description"   style="height: 300px;" class=" wysiwyg "  name="description"  /><?php echo set_value('description', (isset($result->description)) ? htmlspecialchars_decode($result->description) : ''); ?></textarea>
	<?php echo form_error('description'); ?>
</div>
</div>

<div class='form-group'><div class="col-md-3"></div><div class="col-md-6">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo anchor('admin/sales_items_stock','Cancel','class="btn  btn-default"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
            </div>