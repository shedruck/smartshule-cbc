<div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h2>  Students Clearance  </h2>
             <div class="right">  
             <?php //echo anchor( 'admin/students_clearance/create/'.$page, '<i class="glyphicon glyphicon-plus"></i> '.lang('web_add_t', array(':name' => 'Students Clearance')), 'class="btn btn-primary"');?>
			 
			 <?php echo anchor( 'admin/students_clearance/bulk' , '<i class="glyphicon glyphicon-plus">
                </i> '.lang('web_add_t', array(':name' => 'Bulk Clearance')), 'class="btn btn-warning"');?> 
			 
			 <?php echo anchor( 'admin/students_clearance' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Students Clearance')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
              
                 <?php if ($students_clearance): ?>
                 <div class="block-fluid">
				<table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
	 <thead>
                <th>#</th>
				<th>Student</th>
				<th>Created On</th>
                <th>Created By</th>
				<th ><?php echo lang('web_options');?></th>
		</thead>
		<tbody>
		<?php 
			 $i = 0;
				if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
				{
					$i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
				}
               $stud = $this->ion_auth->students_full_details();  
            foreach ($students_clearance as $p ): 
                 $i++;
				   $usr = $this->ion_auth->get_user($p->created_by);
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>					
				<td><?php echo $stud[$p->student];?></td>
				<td><?php echo date('d M Y',$p->created_on); ?></td> 
			    <td><?php echo $usr->first_name . ' ' . $usr->last_name; ?></td>

			 <td width='20%'>
						 <div class='btn-group'>
							
							<a class='btn btn-primary' href='<?php echo site_url('admin/students_clearance/manage_records/'.$p->student);?>'><i class='glyphicon glyphicon-edit'></i> Manage</a>
							<a class='btn btn-success' href='<?php echo site_url('admin/students_clearance/view/'.$p->student.'/'.$page);?>'><i class='glyphicon glyphicon-share'></i> View</a>
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