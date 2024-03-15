<script>
	$(function() {
		$('.datepicker').datepicker({dateFormat: 'dd-mm-yy'});
	});
</script>
<div class="row">
 <div class="col-md-10 widget-container-span ui-sortable">
        <div class="widget-box" style="opacity: 1; z-index: 0;">   
            <div class="widget-header"> <h5>Reports </h5>
             <div class="widget-toolbar">
             <span class="badge badge-success">
                       <?php echo anchor( 'admin/reports/', '<i class="glyphicon glyphicon-list">
                    </i>'.lang('web_list_all', array(':name' => 'reports')));?>                  
                     </span> <a href="#" data-action="collapse">
                        <i class="glyphicon glyphicon-chevron-up"></i>
                    </a></div>
            </div>
        	                      
               <div class="widget-body">    <div class="widget-main">
                  <div class='space-6'></div>

<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo ($updType == 'create') ? form_open_multipart('admin/reports/create', $attributes) : form_open_multipart('admin/reports/edit', $attributes); 
?>
<div class='control-group'>
	<label class=' control-label' for='name'>Name <span class='required'>*</span></label><div class="controls">
	<?php echo form_input('name' ,$reports_m->name , 'id="name_"  class="col-md-7" ' );?>
 	<?php echo form_error('name'); ?>
</div>
</div>

<div class='control-group'>
	<label class=' control-label' for='client_id'>Client Id <span class='required'>*</span></label>
	<div class="controls">
    <?php echo form_dropdown(' client_id', $array_clients_m,  (isset($reports_m->client_id)) ? $reports_m->client_id : ''     ,   ' class="chzn-select col-md-4" data-placeholder="Select  Options..." ');
                            ?>		
 	<?php echo form_error('client_id'); ?>
</div>
</div>

<div class='control-group'>
	<label class=' control-label' for='date'>Date <span class='required'>*</span></label><div class="controls">
	<input id='date' type='text' name='date' maxlength='' class='col-md-5 date-picker' value="<?php echo set_value('date', (isset($reports_m->date)) ? $reports_m->date : ''); ?>"  />
       <?php //->format('Y-m-d');?>
	<?php echo form_error('date'); ?>
</div>
</div>

<div class='control-group'>
	<label class=' control-label' for='description'>Description </label><div class="controls">
	<textarea id="description"  class="autosize-transition col-md-7 "  name="description"  /><?php echo set_value('description', (isset($reports_m->description)) ? htmlspecialchars_decode($reports_m->description) : ''); ?></textarea>
	<?php echo form_error('description'); ?>
</div>
</div>

<div class='control-group'><label class="control-label"></label><div class="controls">
    
<?php echo anchor('admin/reports','Back To Listing','class="btn  btn-mini"');?>
    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-blue  btn-small''" : "id='submit' class='btn btn-blue'")); ?>
</div></div>

<?php echo form_hidden('page',set_value('page', $page)); ?>

<?php if ($updType == 'edit'): ?>
	<?php echo form_hidden('id',$reports_m->id); ?>
<?php endif ?>

<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
            </div>
        </div>
    </div>
 
</div>