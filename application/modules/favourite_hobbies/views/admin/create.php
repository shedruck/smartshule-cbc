<div class="col-md-8">
        <div class="head"> 
             <div class="icon"><span class="icosg-target1"></span></div>		
            <h2>  Favourite Hobbies  </h2>
             <div class="right"> 
             <?php echo anchor( 'admin/favourite_hobbies/create' , '<i class="glyphicon glyphicon-plus">
                </i> '.lang('web_add_t', array(':name' => 'Favourite Hobbies')), 'class="btn btn-primary"');?> 
              <?php echo anchor( 'admin/favourite_hobbies' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Favourite Hobbies')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
               
				   <div class="block-fluid">

<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>
<div class='form-group'>
	<div class="col-md-3" for='student'>Student <span class='required'>*</span></div><div class="col-md-6">
	 <select name="student" class="select select2-offscreen" style="" tabindex="-1">
		<option value="">Select Student</option>
		<?php
		$data = $this->ion_auth->students_full_details();
		foreach ($data as $key => $value):
				?>
				<option value="<?php echo $key; ?>"><?php echo $value ?></option>
		<?php endforeach; ?>
	</select>
 	<?php echo form_error('student'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='year'>Year </div><div class="col-md-6">
	<?php echo form_input('year' ,$result->year , 'id="year_"  class="form-control" ' );?>
 	<?php echo form_error('year'); ?>
</div>
</div>

<div class='widget'>
  <div class='head dark'>
        <div class='icon'><i class='icos-pencil'></i></div>
	<h2>Languages Spoken </h2></div>
	 <div class="block-fluid editor">
	<textarea id="languages_spoken"   style="height: 80px;" class="  "  name="languages_spoken"  /><?php echo set_value('languages_spoken', (isset($result->languages_spoken)) ? htmlspecialchars_decode($result->languages_spoken) : ''); ?></textarea>
	<?php echo form_error('languages_spoken'); ?>
</div>
</div>

<div class='widget'>
  <div class='head dark'>
        <div class='icon'><i class='icos-pencil'></i></div>
	<h2>Hobbies </h2></div>
	 <div class="block-fluid editor">
	<textarea id="hobbies"   style="height: 80px;" class="  "  name="hobbies"  /><?php echo set_value('hobbies', (isset($result->hobbies)) ? htmlspecialchars_decode($result->hobbies) : ''); ?></textarea>
	<?php echo form_error('hobbies'); ?>
</div>
</div>

<div class='widget'>
  <div class='head dark'>
        <div class='icon'><i class='icos-pencil'></i></div>
	<h2>Favourite Subjects </h2></div>
	 <div class="block-fluid editor">
	<textarea id="favourite_subjects"   style="height: 80px;" class="  "  name="favourite_subjects"  /><?php echo set_value('favourite_subjects', (isset($result->favourite_subjects)) ? htmlspecialchars_decode($result->favourite_subjects) : ''); ?></textarea>
	<?php echo form_error('favourite_subjects'); ?>
</div>
</div>

<div class='widget'>
  <div class='head dark'>
        <div class='icon'><i class='icos-pencil'></i></div>
	<h2>Favourite Books </h2></div>
	 <div class="block-fluid editor">
	<textarea id="favourite_books"   style="height: 80px;" class="  "  name="favourite_books"  /><?php echo set_value('favourite_books', (isset($result->favourite_books)) ? htmlspecialchars_decode($result->favourite_books) : ''); ?></textarea>
	<?php echo form_error('favourite_books'); ?>
</div>
</div>

<div class='widget'>
  <div class='head dark'>
        <div class='icon'><i class='icos-pencil'></i></div>
	<h2>Favourite Food </h2></div>
	 <div class="block-fluid editor">
	<textarea id="favourite_food"   style="height: 80px;" class="  "  name="favourite_food"  /><?php echo set_value('favourite_food', (isset($result->favourite_food)) ? htmlspecialchars_decode($result->favourite_food) : ''); ?></textarea>
	<?php echo form_error('favourite_food'); ?>
</div>
</div>

<div class='widget'>
  <div class='head dark'>
        <div class='icon'><i class='icos-pencil'></i></div>
	<h2>Favourite Bible Verse </h2></div>
	 <div class="block-fluid editor">
	<textarea id="favourite_bible_verse"   style="height: 80px;" class="  "  name="favourite_bible_verse"  /><?php echo set_value('favourite_bible_verse', (isset($result->favourite_bible_verse)) ? htmlspecialchars_decode($result->favourite_bible_verse) : ''); ?></textarea>
	<?php echo form_error('favourite_bible_verse'); ?>
</div>
</div>

<div class='widget'>
  <div class='head dark'>
        <div class='icon'><i class='icos-pencil'></i></div>
	<h2>Favourite Cartoon </h2></div>
	 <div class="block-fluid editor">
	<textarea id="favourite_cartoon"   style="height: 80px;" class="  "  name="favourite_cartoon"  /><?php echo set_value('favourite_cartoon', (isset($result->favourite_cartoon)) ? htmlspecialchars_decode($result->favourite_cartoon) : ''); ?></textarea>
	<?php echo form_error('favourite_cartoon'); ?>
</div>
</div>

<div class='widget'>
  <div class='head dark'>
        <div class='icon'><i class='icos-pencil'></i></div>
	<h2>Favourite Career </h2></div>
	 <div class="block-fluid editor">
	<textarea id="favourite_career"   style="height: 80px;" class="  "  name="favourite_career"  /><?php echo set_value('favourite_career', (isset($result->favourite_career)) ? htmlspecialchars_decode($result->favourite_career) : ''); ?></textarea>
	<?php echo form_error('favourite_career'); ?>
</div>
</div>

<div class='widget'>
  <div class='head dark'>
        <div class='icon'><i class='icos-pencil'></i></div>
	<h2>Others </h2></div>
	 <div class="block-fluid editor">
	<textarea id="others"   style="height: 80px;" class="  "  name="others"  /><?php echo set_value('others', (isset($result->others)) ? htmlspecialchars_decode($result->others) : ''); ?></textarea>
	<?php echo form_error('others'); ?>
</div>
</div>

<div class='form-group'><div class="col-md-3"></div><div class="col-md-6">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo anchor('admin/favourite_hobbies','Cancel','class="btn  btn-default"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
            </div>