<div class="col-md-8">
  <div class="head">
                    <div class="icon"><span class="icosg-target1"></span></div>
                    <h2> Hostel Beds  </h2> 
                     <div class="right">                            
                <?php echo anchor( 'admin/hostel_beds/create/'.$page, '<i class="glyphicon glyphicon-plus"></i> '.lang('web_add_t', array(':name' => 'Hostel Bed')), 'class="btn btn-primary"');?>
				 <a class="btn btn-primary" href="<?php echo base_url('admin/hostel_beds'); ?>"><i class="glyphicon glyphicon-list"></i> List All Beds</a>
			
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
	<div class='col-md-2' for='room_id'>Hostel Room </div>
<div class="col-md-10">
                <?php 	
     echo form_dropdown('room_id', $hostel_rooms,  (isset($result->room_id)) ? $result->room_id : ''     ,   ' class="chzn-select" data-placeholder="Select Options..." ');
     echo form_error('room_id'); ?>
</div></div>

<div class='form-group'>
	<div class='col-md-2' for='bed_number'>Bed Number </div><div class="col-md-10">
	<?php echo form_input('bed_number' ,$result->bed_number , 'id="bed_number_"  class="form-control" ' );?>
 	<?php echo form_error('bed_number'); ?>
</div>
</div>

<div class='form-group'><div class="col-md-2"></div><div class="col-md-10">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo anchor('admin/hostel_beds','Cancel','class="btn  btn-default"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
            </div>
			
			
			  <div class="col-md-4">
	  
	       <div class="widget">
                    <div class="head dark">
                        <div class="icon"></div>
                        <h2>Add Hostel Room</h2>
                    </div>
					
                    <div class="block-fluid">
                       <?php echo form_open('admin/hostel_rooms/quick_add','class=""'); ?>
                        <div class="form-group">
                            <div class="col-md-3">Hostel:<span class='required'>*</span></div>
                            <div class="col-md-9">                                      
                                 <?php echo form_dropdown('hostel_id',$hostel, 'id="hostel_id" ' );?>
 	                           <?php echo form_error('hostel_id'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-3">Room Name:<span class='required'>*</span></div>
                            <div class="col-md-9">                                      
                                 <?php echo form_input('room_name','', 'id="room_name"  placeholder=" e.g Buffalo"' );?>
 	                           <?php echo form_error('room_name'); ?>
                            </div>
                        </div>
                                                    
                        <div class="form-group">
						 <div class="col-md-3">Description:</div>
                            <div class="col-md-9">
                                <textarea name="description"></textarea> 
                            </div>
                        </div>                        
                   
                    <div class="toolbar TAR">
                        <button class="btn btn-primary">Save </button>
                    </div>
					   <?php echo form_close(); ?> 
					   </div>
                </div>
                </div>
       