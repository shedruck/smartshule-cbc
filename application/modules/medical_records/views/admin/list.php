<div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h2>  Medical Records  </h2>
             <div class="right">  
             <?php echo anchor( 'admin/medical_records/create/'.$page, '<i class="glyphicon glyphicon-plus"></i> '.lang('web_add_t', array(':name' => 'Medical Records')), 'class="btn btn-primary"');?>
			 
			 <?php echo anchor( 'admin/medical_records' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Medical Records')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
              
                 <?php if ($medical_records): ?>
                 <div class="block-fluid">
				<table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
	 <thead>
                <th>#</th>
				<th width="115">Date</th>
				<th>Student</th>
				<th>Sickness Reported</th>
				<th>Action Taken</th>
				<th>Comment</th>	
				<th>Recorded by</th>	
				<th ><?php echo lang('web_options');?></th>
		</thead>
		<tbody>
		<?php 
                             $i = 0;
                                if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                                {
                                    $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                                }
                
				 $stud=$this->ion_auth->students_full_details();
            foreach ($medical_records as $p ): 
                 $i++;
				 $u = $this->ion_auth->get_user($p->created_by);
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>					
				<td><?php echo date('d M Y',$p->date);?></td>
				<td><?php echo $stud[$p->student];?></td>
				<td><?php echo $p->sickness;?></td>
					<td><?php echo $p->action_taken;?></td>
					<td><?php echo $p->comment;?></td>
					<td><?php echo $u->first_name.' '.$u->last_name;?></td>

			 <td width='22%'>
						 <div class='btn-group'>
						 
						 <a class="btn btn-success" href='<?php echo site_url('admin/medical_records/edit/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-eye-open'></i> View</a>
						<a  class="btn btn-info" href='<?php echo site_url('admin/medical_records/edit/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-edit'></i> Edit</a>
							  
							<a  class="btn btn-danger" onClick="return confirm('<?php echo lang('web_confirm_delete')?>')" href='<?php echo site_url('admin/medical_records/delete/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-trash'></i> Trash</a>
								
							
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