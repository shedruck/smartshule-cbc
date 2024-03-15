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
         	        <?php if ($hostel_beds): ?>              
               <div class="block-fluid">
				<table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
<thead>
                <th>#</th>
				<th>Hostel Room</th>	
				<th>Bed Number</th>	
				<th>Student</th>	
				<th>Created on</th>	
				<th>Status</th>	
				<th ><?php echo lang('web_options');?></th>
		</thead>
		<tbody>
		<?php 
                             $i = 0;
                                if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                                {
                                    $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                                }
			
                
			$u=$this->ion_auth->students_full_details();
            foreach ($hostel_beds as $p ): 
			$bed=$this->hostel_beds_m->get_student($p->id);
			if(!empty($bed->student)){
			}
                 $i++;
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>				
				<td><?php echo $hostel_rooms[$p->room_id];?></td>
				<td><?php echo $p->bed_number;?></td>
				<td><?php 
				if(!empty($bed->student)){
				echo $u[$bed->student];
				}else{
				echo '<i style="color:red">Vacant</i>';
				}
				?></td>
				<td><?php echo date('d M, Y',$p->created_on);?></td>
				<td>
				<?php if($p->status==0):?>
				<span class="label label-success">Not Occupied</span>
			<?php elseif($p->status==1):?>
				<span class="label label-warning" style="text-decoration:line-through">Occupied</span>
				<?php else:?>
				  <span class="label label-warning"><?php echo "No status";?></span>
				<?php endif;?>
				</td>
				 <td width="20%">
					<div class="btn-group">
							<button class="btn dropdown-toggle" data-toggle="dropdown">Action <i class="glyphicon glyphicon-caret-down"></i></button>
							<ul class="dropdown-menu pull-right">
							    <?php if($p->status==0){?>
								 <li><a href="<?php echo site_url('admin/assign_bed/assign/'.$p->id.'/'.$page);?>"><i class="glyphicon glyphicon-hand-right"></i> Assign Bed</a></li>
								 <?php }?>
								<li><a href="<?php echo site_url('admin/hostel_beds/edit/'.$p->id.'/'.$page);?>"><i class="glyphicon glyphicon-edit"></i> Edit Details</a></li>
							  
								<li><a onClick="return confirm('<?php echo lang('web_confirm_delete')?>')" href='<?php echo site_url('admin/hostel_beds/delete/'.$p->id.'/'.$page);?>'><i class="glyphicon glyphicon-trash"></i> Trash</a></li>
							</ul>
							</div>
						</td>
				</tr>
 			<?php endforeach ?>
		</tbody>

	</table>

</div>

<?php else: ?>
 	<p class='text'><?php echo lang('web_no_elements');?></p>
 <?php endif ?>