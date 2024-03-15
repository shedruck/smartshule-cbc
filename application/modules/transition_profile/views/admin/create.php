<div class="col-md-8">
        <div class="head"> 
             <div class="icon"><span class="icosg-target1"></span></div>		
            <h2>  Transition Profile  </h2>
             <div class="right"> 
             <?php echo anchor( 'admin/transition_profile/create' , '<i class="glyphicon glyphicon-plus">
                </i> '.lang('web_add_t', array(':name' => 'Transition Profile')), 'class="btn btn-primary"');?> 
              <?php echo anchor( 'admin/transition_profile' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Transition Profile')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
               
				   <div class="block-fluid">

<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>
<div class='widget'>
  <div class='head dark'>
        <div class='icon'><i class='icos-pencil'></i></div>
	<h2>Allergy </h2></div>
	 <div class="block-fluid editor">
	<textarea id="allergy"   style="height: 300px;" class=" wysiwyg "  name="allergy"  /><?php echo set_value('allergy', (isset($result->allergy)) ? htmlspecialchars_decode($result->allergy) : ''); ?></textarea>
	<?php echo form_error('allergy'); ?>
</div>
</div>

<div class='widget'>
  <div class='head dark'>
        <div class='icon'><i class='icos-pencil'></i></div>
	<h2>General Health </h2></div>
	 <div class="block-fluid editor">
	<textarea id="general_health"   style="height: 300px;" class=" wysiwyg "  name="general_health"  /><?php echo set_value('general_health', (isset($result->general_health)) ? htmlspecialchars_decode($result->general_health) : ''); ?></textarea>
	<?php echo form_error('general_health'); ?>
</div>
</div>

<div class='widget'>
  <div class='head dark'>
        <div class='icon'><i class='icos-pencil'></i></div>
	<h2>General Academic </h2></div>
	 <div class="block-fluid editor">
	<textarea id="general_academic"   style="height: 300px;" class=" wysiwyg "  name="general_academic"  /><?php echo set_value('general_academic', (isset($result->general_academic)) ? htmlspecialchars_decode($result->general_academic) : ''); ?></textarea>
	<?php echo form_error('general_academic'); ?>
</div>
</div>

<div class='widget'>
  <div class='head dark'>
        <div class='icon'><i class='icos-pencil'></i></div>
	<h2>Feeding Habit </h2></div>
	 <div class="block-fluid editor">
	<textarea id="feeding_habit"   style="height: 300px;" class=" wysiwyg "  name="feeding_habit"  /><?php echo set_value('feeding_habit', (isset($result->feeding_habit)) ? htmlspecialchars_decode($result->feeding_habit) : ''); ?></textarea>
	<?php echo form_error('feeding_habit'); ?>
</div>
</div>

<div class='widget'>
  <div class='head dark'>
        <div class='icon'><i class='icos-pencil'></i></div>
	<h2>Behaviour </h2></div>
	 <div class="block-fluid editor">
	<textarea id="behaviour"   style="height: 300px;" class=" wysiwyg "  name="behaviour"  /><?php echo set_value('behaviour', (isset($result->behaviour)) ? htmlspecialchars_decode($result->behaviour) : ''); ?></textarea>
	<?php echo form_error('behaviour'); ?>
</div>
</div>

<div class='widget'>
  <div class='head dark'>
        <div class='icon'><i class='icos-pencil'></i></div>
	<h2>Co Curriculum </h2></div>
	 <div class="block-fluid editor">
	<textarea id="co_curriculum "   style="height: 300px;" class=" wysiwyg "  name="co_curriculum "  /><?php echo set_value('co_curriculum ', (isset($result->co_curriculum )) ? htmlspecialchars_decode($result->co_curriculum ) : ''); ?></textarea>
	<?php echo form_error('co_curriculum '); ?>
</div>
</div>

<div class='widget'>
  <div class='head dark'>
        <div class='icon'><i class='icos-pencil'></i></div>
	<h2>Parental Involvement </h2></div>
	 <div class="block-fluid editor">
	<textarea id="parental_involvement"   style="height: 300px;" class=" wysiwyg "  name="parental_involvement"  /><?php echo set_value('parental_involvement', (isset($result->parental_involvement)) ? htmlspecialchars_decode($result->parental_involvement) : ''); ?></textarea>
	<?php echo form_error('parental_involvement'); ?>
</div>
</div>

<div class='form-group'>
	<div class='col-md-3'>Transport </div><div class="col-md-6">
	<input type='radio' name='transport' id='transport_0' value='private' <?php echo preset_radio('transport', 'private', (isset($result->transport)) ? $result->transport : 'private'  );?> > <div class='col-md-3 inline' for='transport_0'> Private transport </div>
	<input type='radio' name='transport' id='transport_1' value='school' <?php echo preset_radio('transport', 'school', (isset($result->transport)) ? $result->transport : 'private'  );?> > <div class='col-md-3 inline' for='transport_1'> School transport </div>
	<?php echo form_error('transport'); ?>
</div>
</div>

<div class='form-group'><div class="col-md-3"></div><div class="col-md-6">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo anchor('admin/transition_profile','Cancel','class="btn  btn-default"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
            </div>