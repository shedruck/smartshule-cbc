<div class="col-md-12">
        <div class="head"> 
             <div class="icon"><span class="icosg-target1"></span></div>		
            <h2>  Board Members  </h2>
             <div class="right"> 
             <?php echo anchor('admin/board_members/create/' . $page, '<i class="glyphicon glyphicon-plus"></i> ' . lang('web_add_t', array(':name' => 'Board Members')), 'class="btn btn-primary"'); ?>

			<?php echo anchor('admin/board_members', '<i class="glyphicon glyphicon-list">
                </i> Board Members Grid View', 'class="btn btn-success"'); ?> 
				
        <?php echo anchor('admin/board_members/list_view', '<i class="glyphicon glyphicon-list">
                </i> Board Members List View' , 'class="btn btn-info"'); ?>
				
				<?php echo anchor('admin/board_members/inactive', '<i class="glyphicon glyphicon-list">
                </i> Inactive Board Members' , 'class="btn btn-warning"'); ?>
             
                </div>
                </div>
         	                    
               
				   <div class="block-fluid">

<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>

<div class="col-md-12"><hr></div>

<div class="col-md-6">
	<div class='form-group'>
		 <div class="col-md-4" for='file'>Passport Photo</div>
		 <div class="col-md-4">
			<input id='file' type='file' name='file'  <?php if($updType == 'create'){ echo 'required="required';} ?>/>
		 </div>
		<div class="col-md-4">
			<?php if ($updType == 'edit'): ?>
			<img src='<?php echo base_url()?>uploads/files/<?php echo $result->file?>' height="40" width="40"/>
			<?php endif ?>

			<?php echo form_error('file'); ?>
			<?php  echo ( isset($upload_error['file'])) ?  $upload_error['file']  : ""; ?>
		</div>
	</div>
</div>

<div class="col-md-6">
	<div class='form-group'>
		<div class="col-md-4" for='file'>Copy of ID</div>
	 <div class="col-md-4">
		<input id='file' type='file' name='national_id'  <?php if($updType == 'create'){ echo 'required="required';} ?> />
	 </div>
	<div class="col-md-4">
		<?php if ($result->national_id): ?>
		<br/><a target="_blank" href='<?php echo base_url()?>uploads/files/<?php echo $result->national_id?>' height="40" width="40"/> Download actual file</a>
		<?php endif ?>

		<?php echo form_error('national_id'); ?>
		<?php  echo ( isset($upload_error['national_id'])) ?  $upload_error['national_id']  : ""; ?>
	</div>
	</div>
</div>

<div class="col-md-12"><hr></div>
<div class="col-md-12">
<div class="col-md-6">
			<div class='form-group'>
				<div class="col-md-3" for='title'>Title <span class='required'>*</span></div><div class="col-md-8">
				
				<?php echo form_input('title' ,$result->title , 'id="title"  class="form-control" ' );?>
				<?php echo form_error('title'); ?>
				
				
			</div>
			</div>

			<div class='form-group'>
				<div class="col-md-3" for='first_name'>First Name <span class='required'>*</span></div><div class="col-md-8">
				<?php echo form_input('first_name' ,$result->first_name , 'id="first_name_"  class="form-control" ' );?>
				<?php echo form_error('first_name'); ?>
			</div>
			</div>

			<div class='form-group'>
				<div class="col-md-3" for='last_name'>Other Name <span class='required'>*</span></div><div class="col-md-8">
				<?php echo form_input('last_name' ,$result->last_name , 'id="last_name_"  class="form-control" ' );?>
				<?php echo form_error('last_name'); ?>
			</div>
			</div>

			<div class='form-group'>
				<div class="col-md-3" for='gender'>Gender <span class='required'>*</span></div>
				<div class="col-md-8">
								<?php $items = array('' =>'Select Option', 
				"Male"=>"Male",
				"Female"=>"Female",
				);		
					 echo form_dropdown('gender', $items,  (isset($result->gender)) ? $result->gender : ''     ,   ' class="chzn-select" data-placeholder="Select Options..." ');
					 echo form_error('gender'); ?>
				</div>
			</div>

			<div class='form-group'>
				<div class="col-md-3" for='phone'>Phone <span class='required'>*</span></div><div class="col-md-8">
				<?php echo form_input('phone' ,$result->phone , 'id="phone_"  class="form-control" ' );?>
				<?php echo form_error('phone'); ?>
			</div>
			</div>
	</div>
	<div class="col-md-6">

			<div class='form-group'>
				<div class="col-md-3" for='email'>Email </div><div class="col-md-8">
				<?php echo form_input('email' ,$result->email , 'id="email_"  class="form-control" ' );?>
				<?php echo form_error('email'); ?>
			</div>
			</div>

			<div class='form-group'>
				<div class="col-md-3" for='position'>Position <span class='required'>*</span></div><div class="col-md-8">
				<?php $items = $this->ion_auth->populate('positions','id','name');
					 echo form_dropdown('position', array(''=>'Select position')+$items,  (isset($result->position)) ? $result->position : ''     ,   ' class="chzn-select" data-placeholder="Select Options..." ');
					 echo form_error('position'); ?>
					 
				
			</div>
			</div>

			<div class='form-group'>
				<div class="col-md-3" for='date_joined'>Date Joined <span class='required'>*</span></div><div class="col-md-8">
				<input id='date_joined' type='text' name='date_joined' maxlength='' class='form-control datepicker' value="<?php echo $result->date_joined ? date('d M Y',$result->date_joined) : ''; ?>"  />
				<?php echo form_error('date_joined'); ?>
			</div>
			</div>

			<div class='form-group'>
				<div class="col-md-3" for='work_place'>Work Place </div><div class="col-md-8">
				<?php echo form_input('work_place' ,$result->work_place , 'id="position_"  class="form-control" ' );?>
				<?php echo form_error('work_place'); ?>
			</div>
			</div>
 </div>
 </div>
<div class="col-md-12">
<div class='widget' >
  <div class='head dark'>
        <div class='icon'><i class='icos-pencil'></i></div>
	<h2>Profile Details </h2></div>
	 <div class="block-fluid editor"  >
	<textarea id="profile"   class=" wysiwyg "  name="profile"  placeholder="Write brief Profile details"/>
	<?php echo set_value('profile', (isset($result->profile)) ? htmlspecialchars_decode($result->profile) : ''); ?>
	
	</textarea>
	<?php echo form_error('profile'); ?>
</div>
</div>
</div>

<div class='form-group'><div class="col-md-3"></div><div class="col-md-8">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo anchor('admin/board_members','Cancel','class="btn  btn-default"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
            </div>