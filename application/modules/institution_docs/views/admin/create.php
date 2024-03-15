<div class="col-md-8">
        <div class="head"> 
             <div class="icon"><span class="icosg-target1"></span></div>		
            <h2>  Institution Docs  </h2>
             <div class="right"> 
             <?php echo anchor( 'admin/institution_docs/create' , '<i class="glyphicon glyphicon-plus">
                </i> '.lang('web_add_t', array(':name' => 'Institution Docs')), 'class="btn btn-primary"');?> 
              <?php echo anchor( 'admin/institution_docs' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Institution Docs')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
               
				   <div class="block-fluid">

<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>

<div class='form-group'>
	<div class="col-md-4" for='ownership_doc'> Ownership Document </div>
 <div class="col-md-6">
	<input id='ownership_doc' type='file' name='ownership_doc' />

	<?php if ($updType == 'edit'): ?>
	<a target="_blank" href='<?php echo base_url()?>uploads/files/<?php echo $result->ownership_doc?>' />Download actual file </a>
	<?php endif ?>

	<br/><?php echo form_error('ownership_doc'); ?>
	<?php  echo ( isset($upload_error['ownership_doc'])) ?  $upload_error['ownership_doc']  : ""; ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-4" for='institution_cert'>Institution Certificate </div>
 <div class="col-md-6">
	<input id='institution_cert' type='file' name='institution_cert' />

	<?php if ($updType == 'edit'): ?>
	<a target="_blank" href='<?php echo base_url()?>uploads/files/<?php echo $result->institution_cert?>' />Download actual file</a>
	<?php endif ?>

	<br/><?php echo form_error('institution_cert'); ?>
	<?php  echo ( isset($upload_error['institution_cert'])) ?  $upload_error['institution_cert']  : ""; ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-4" for='incorporation_doc'> Incorporation Certificate </div>
 <div class="col-md-6">
	<input id='incorporation_doc' type='file' name='incorporation_doc' />

	<?php if ($updType == 'edit'): ?>
	<a target="_blank" href='<?php echo base_url()?>uploads/files/<?php echo $result->incorporation_doc?>' />Download actual file </a>
	<?php endif ?>

	<br/><?php echo form_error('incorporation_doc'); ?>
	<?php  echo ( isset($upload_error['incorporation_doc'])) ?  $upload_error['incorporation_doc']  : ""; ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-4" for='ministry_approval'> Ministry Approval </div>
 <div class="col-md-6">
	<input id='ministry_approval' type='file' name='ministry_approval' />

	<?php if ($updType == 'edit'): ?>
	<a target="_blank" href='<?php echo base_url()?>uploads/files/<?php echo $result->ministry_approval?>' />Download actual file</a>
	<?php endif ?>

	<br/><?php echo form_error('ministry_approval'); ?>
	<?php  echo ( isset($upload_error['ministry_approval'])) ?  $upload_error['ministry_approval']  : ""; ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-4" for='title_deed'>Title Deed </div>
 <div class="col-md-6">
	<input id='title_deed' type='file' name='title_deed' />

	<?php if ($updType == 'edit'): ?>
	<a target="_blank" href='<?php echo base_url()?>uploads/files/<?php echo $result->title_deed?>' />Download actual file</a>
	<?php endif ?>

	<br/><?php echo form_error('title_deed'); ?>
	<?php  echo ( isset($upload_error['title_deed'])) ?  $upload_error['title_deed']  : ""; ?>
</div>
</div>

<div class='form-group'><div class="col-md-4"></div><div class="col-md-6">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo anchor('admin/institution_docs','Cancel','class="btn  btn-default"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
            </div>