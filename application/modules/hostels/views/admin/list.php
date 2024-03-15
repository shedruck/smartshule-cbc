<div class="head">
                    <div class="icon"><span class="icosg-target1"></span></div>
                    <h2> Hostels/Domitories </h2> 
                     <div class="right">                            
                <?php echo anchor( 'admin/hostels/create/'.$page, '<i class="glyphicon glyphicon-plus"></i> '.lang('web_add_t', array(':name' => 'Hostels')), 'class="btn btn-primary"');?>
				<?php echo anchor( 'admin/hostels/', '<i class="glyphicon glyphicon-list"></i> List All Hostels', 'class="btn btn-primary"');?>
			
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
         	        <?php if ($hostels): ?>              
               <div class="block-fluid">
				<table class="fpTable" cellpadding="0" cellspacing="0" width="100%">

	 <thead>
                <th>#</th>
				<th>Title</th>
				<th>Capacity</th>
				<th>Janitor</th>
				<th>Created on</th>
				<th>Description</th>	
				<th ><?php echo lang('web_options');?></th>
		</thead>
		<tbody>
		<?php 
                             $i = 0;
                                if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                                {
                                    $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                                }
                
            foreach ($hostels as $p ): 
                 $i++;
				 $u=$this->ion_auth->get_user($p->janitor);
				 $capacity=(int)$p->capacity;
				 $room="Room";
				 if($capacity>2){
				    $room="Rooms";
				 }
				
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>					
				<td><?php echo $p->title;?></td>
				<td><?php echo $p->capacity.' '.$room;?></td>
				<td><?php echo ucwords($u->first_name.' '.$u->last_name);?></td>
				<td><?php echo date('d M, Y',$p->created_on);?></td>
				<td><?php echo $p->description;?></td>
				 <td width="20%">
					<div class="btn-group">
							<a class='btn btn-primary' href="<?php echo site_url('admin/hostels/edit/'.$p->id.'/'.$page);?>"><i class="glyphicon glyphicon-edit"></i> Edit</a>
							  
							<a class='btn btn-danger' onClick="return confirm('<?php echo lang('web_confirm_delete')?>')" href='<?php echo site_url('admin/hostels/delete/'.$p->id.'/'.$page);?>'><i class="glyphicon glyphicon-trash"></i> Trash</a>
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