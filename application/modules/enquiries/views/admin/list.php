<div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h2> Admission  Enquiries   </h2>
             <div class="right">  
             <?php echo anchor( 'admin/enquiries/create/'.$page, '<i class="glyphicon glyphicon-plus"></i> '.lang('web_add_t', array(':name' => 'Enquiries')), 'class="btn btn-primary"');?>
			 
			 <?php echo anchor( 'admin/enquiries' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Enquiries')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
              
                 <?php if ($enquiries): ?>
                 <div class="block-fluid">
				<table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
	 <thead>
                <th>#</th>
				<th>Date</th>
				<th>Name</th>
				
				<th>Gender</th>
				<th>DOB</th>
				<th>Contacts</th>
				<th>Class</th>
				<th>Know About</th>
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
                $classes = $this->ion_auth->fetch_classes(); 
            foreach ($enquiries as $p ): 
                 $i++;
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>					
                <td><?php echo date('d M Y',$p->date); ?></td>					
				<td><?php echo $p->first_name;?> <?php echo $p->last_name;?></td>
					<td><?php echo ucwords($p->gender);?></td>
				 <td><?php echo date('d M Y',$p->dob); ?></td>
				 
				<td><?php echo $p->phone;?><br><?php echo $p->email;?></td>
				<td><?php echo $classes[$p->class];?></td>
				<td><?php echo $p->know_about;?></td>
				<td>
				<?php 
				if($p->status=='pending') echo '<span class="label label-warning">'.ucwords($p->status).'</span>';
				elseif($p->status=='active') echo '<span class="label label-success"> Admitted</span>';
				elseif($p->status=='disabled') echo '<span class="label label-danger"> Disabled</span>';
				
				?>
				
				</td>
				
			 <td width='30'>
						 <div class='btn-group'>
							<button class='btn dropdown-toggle' data-toggle='dropdown'>Action <i class='glyphicon glyphicon-caret-down'></i></button>
							<ul class='dropdown-menu pull-right'>
								
								<li><a  href='<?php echo site_url('admin/enquiries/edit/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-edit'></i> Edit Details</a></li>
								
								<li><a  href='<?php echo site_url('admin/enquiries/edit/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-edit'></i> Admit As Student</a></li>
								
								<li><a  href='<?php echo site_url('admin/enquiries/disable/'.$p->id.'/'.$page);?>' onClick="return confirm('Are you sure you want to disable this?')" ><i class='glyphicon glyphicon-remove'></i> Disable</a></li>
							  
								<li><a  onClick="return confirm('<?php echo lang('web_confirm_delete')?>')" href='<?php echo site_url('admin/enquiries/delete/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-trash'></i> Trash</a></li>
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