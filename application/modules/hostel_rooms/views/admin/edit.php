<div class="col-md-8">
<div class="head">
                    <div class="icon"><span class="icosg-target1"></span></div>
                    <h2> Hostel Rooms </h2> 
                     <div class="right">                            
                <?php echo anchor( 'admin/hostel_rooms/create/'.$page, '<i class="glyphicon glyphicon-plus"></i> '.lang('web_add_t', array(':name' => 'Hostel Rooms')), 'class="btn btn-primary"');?>
			 <a class="btn btn-primary"  href="<?php echo base_url('admin/hostel_rooms'); ?>"><i class="glyphicon glyphicon-list"></i> Hostel Rooms</a>
			
			 <div class="btn-group">
					<button class="btn dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-cog"></i> Options</button>
					
					<ul class="dropdown-menu pull-right">
					  <li><a class=""  href="<?php echo base_url('admin/hostel_rooms'); ?>"><i class="glyphicon glyphicon-check"></i> Manage Hostel Rooms</a></li>
					
					  <li><a href="<?php echo base_url('admin/hostel_beds'); ?>"><i class="glyphicon glyphicon-share"></i> Manage Hostel Beds</a></li>
					<li class="divider"></li>
					  <li><a href="<?php echo base_url('admin/hostels'); ?>"><i class="glyphicon glyphicon-home"></i> Back to Hostels</a></li>
					   
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
	<div class="col-md-2" for='hostel_id'>Hostel </div>
<div class="col-md-10">
                <?php 		
     echo form_dropdown('hostel_id', $hostel,  (isset($result->hostel_id)) ? $result->hostel_id : ''     ,   ' class="chzn-select" data-placeholder="Select Options..." ');
     echo form_error('hostel_id'); ?>
</div></div>

<div class='form-group'>
	<div class="col-md-2" for='room_name'>Room Name </div><div class="col-md-10">
	<?php echo form_input('room_name' ,$result->room_name , 'id="room_name_"  class="form-control" ' );?>
 	<?php echo form_error('room_name'); ?>
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

<div class='form-group'><div class="control-div"></div><div class="col-md-10">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo anchor('admin/hostel_rooms','Cancel','class="btn btn-danger"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
            </div>
      