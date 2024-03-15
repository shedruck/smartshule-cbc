<div class="col-md-8">
        <div class="head"> 
             <div class="icon"><span class="icosg-target1"></span></div>		
            <h2>  Leaving Certificate  </h2>
             <div class="right"> 
             <?php echo anchor( 'admin/leaving_certificate/create' , '<i class="glyphicon glyphicon-plus">
                </i> '.lang('web_add_t', array(':name' => 'Leaving Certificate')), 'class="btn btn-primary"');?> 
              <?php echo anchor( 'admin/leaving_certificate' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Leaving Certificate')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
               
				   <div class="block-fluid">

<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>

 <div class='form-group'>
            <div class="col-md-3" for='leaving_date'>Leaving Date </div><div class="col-md-6">

                <div id="datetimepicker1" class="input-group date form_datetime">
                    <?php echo form_input('leaving_date', $result->leaving_date > 0 ? date('d M Y', $result->leaving_date) : $result->leaving_date, 'class="validate[required] form-control datepicker col-md-4"'); ?>


                    <span class="input-group-addon "><i class="glyphicon glyphicon-calendar "></i></span>

                </div>
                <?php echo form_error('leaving_date'); ?>
            </div>
        </div>

<div class='widget'>
  <div class='head dark'>
        <div class='icon'><i class='icos-pencil'></i></div>
	<h2>Headteacher Remarks </h2></div>
	 <div class="block-fluid editor">
	<textarea id="ht_remarks"   style="height: 300px;" class=" wysiwyg "  name="ht_remarks"  /><?php echo set_value('ht_remarks', (isset($result->ht_remarks)) ? htmlspecialchars_decode($result->ht_remarks) : ''); ?></textarea>
	<?php echo form_error('ht_remarks'); ?>
</div>
</div>

<div class='widget'>
  <div class='head dark'>
        <div class='icon'><i class='icos-pencil'></i></div>
	<h2>Co-Curricular Activities</h2></div>
	 <div class="block-fluid editor">
	<textarea id="co_curricular"   style="height: 300px;" class=" wysiwyg "  name="co_curricular"  /><?php echo set_value('co_curricular', (isset($result->co_curricular)) ? htmlspecialchars_decode($result->co_curricular) : ''); ?></textarea>
	<?php echo form_error('co_curricular'); ?>
</div>
</div>

<div class='form-group'><div class="col-md-2"></div><div class="col-md-10">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo anchor('admin/leaving_certificate','Cancel','class="btn  btn-default"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
            </div>