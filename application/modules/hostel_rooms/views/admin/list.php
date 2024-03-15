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
         	        <?php if ($hostel_rooms): ?>              
               <div class="block-fluid">
				<table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
<thead>
                <th>#</th>
				<th>Hostel</th>
				<th>Room Name</th>
				<th>Beds</th>
				<th>Created on</th>
				<!--<th>Status</th>-->
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
                
            foreach ($hostel_rooms as $p ): 
			$beds=(int)$this->hostel_rooms_m->count_beds($p->id);
			$free=(int)$this->hostel_rooms_m->count_free_beds($p->id);
                 $i++;
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>					
				<td><?php echo $hostel[$p->hostel_id];?></td>
				<td><?php echo $p->room_name;?></td>
				<td><?php  if(!empty($beds)) echo $beds; else echo 0; ?></td>
				<td><?php echo date('d M, Y',$p->created_on);?></td>
				<!--<td><?php 
				$totals=$beds-$free;
				if(empty($free)){
					 if($totals==0){
							echo '<span class="label label-success">'.$free.' Bed(s)</span>';
						}
					else {echo '<span class="label label-warning" style="text-decoration:line-through">Fully Occupied</span>';}
				}
				?>
				
				</td>-->
				<td><?php echo $p->description;?></td>
				 <td width="20%">
					<div class="btn-group">
					<a class='btn btn-primary' href="<?php echo site_url('admin/hostel_rooms/edit/'.$p->id.'/'.$page);?>"><i class="glyphicon glyphicon-edit"></i> Edit</a>
					  
				<a class='btn btn-danger' onClick="return confirm('<?php echo lang('web_confirm_delete')?>')" href='<?php echo site_url('admin/hostel_rooms/delete/'.$p->id.'/'.$page);?>'><i class="glyphicon glyphicon-trash"></i> Trash</a>
							
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