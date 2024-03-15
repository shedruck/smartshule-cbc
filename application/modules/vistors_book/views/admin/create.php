<div class="col-md-8">
        <div class="head"> 
             <div class="icon"><span class="icosg-target1"></span></div>		
            <h2>  Visitors Book  </h2>
             <div class="right"> 
             <?php echo anchor( 'admin/vistors_book/create' , '<i class="glyphicon glyphicon-plus">
                </i> '.lang('web_add_t', array(':name' => 'Vistors Book')), 'class="btn btn-primary"');?> 
              <?php echo anchor( 'admin/vistors_book' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Vistors Book')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
               
				   <div class="block-fluid">

<?php 

 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>

<div class="form-group">
    <div class="col-md-3" for=''>Type of Vistor </div><div class="col-md-6">
    <?php echo form_dropdown('category', array('' => 'Select Type here') + $category, $this->input->post('category'), 'class ="select select-2" '); ?>
</div>
</div>
<div class='form-group'>
	<div class="col-md-3" for='name'>Name </div><div class="col-md-6">
	<?php echo form_input('name' ,$result->name , 'id="name_"  class="form-control" placeholder="Vistors Name"' );?>
 	<?php echo form_error('name'); ?>
</div>
</div>

<div class='form-group'>
    <div class="col-md-3" for='phone'>Phone Number </div><div class="col-md-6">
    <?php echo form_input('phone' ,$result->phone , 'id="phone_"  class="form-control"  placeholder="Vistors Phone Number" ' );?>
    <?php echo form_error('phone'); ?>
</div>
</div>


<div class='form-group'>
    <div class="col-md-3" for='email'>Email Address </div><div class="col-md-6">
    <?php echo form_input('email' ,$result->email , 'id="email_"  class="form-control"  placeholder="Vistors Email"' );?>
    <?php echo form_error('email'); ?>
</div>
</div>

<div class='form-group'>
    <div class="col-md-3" for='n_id'>National Id/ Passport </div><div class="col-md-6">
    <?php echo form_input('n_id' ,$result->n_id , 'id="n_id_"  class="form-control"  placeholder="Vistors National ID" ' );?>
    <?php echo form_error('n_id'); ?>
</div>
</div>

<div class='form-group'>
    <div class="col-md-3" for='person'>Person To Visit </div><div class="col-md-6">
    <?php echo form_dropdown('person', array('' => 'Select Person') + $users, $this->input->post('person'), 'class ="select select-2" '); ?>
    <?php echo form_error('person'); ?>
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
	<?php echo anchor('admin/vistors_book','Cancel','class="btn  btn-default"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
            </div>