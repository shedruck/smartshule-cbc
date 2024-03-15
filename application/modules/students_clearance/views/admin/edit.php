<div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h2>  Students Clearance  </h2>
             <div class="right">  
             <?php echo anchor( 'admin/students_clearance/create/'.$page, '<i class="glyphicon glyphicon-plus"></i> '.lang('web_add_t', array(':name' => 'Students Clearance')), 'class="btn btn-primary"');?>
			 
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
				<th>Date</th>
				<th>Cleared</th>
				<th>Charge</th>
				<th>Description</th>
				<th ><?php echo lang('web_options');?></th>
		</thead>
		<tbody>
		<?php 
			 $i = 0;
				
               $stud = $this->ion_auth->students_full_details();  
            foreach ($students_clearance as $p ): 
                 $i++;
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>					
				<td><?php echo $stud[$p->student];?></td>
				<td><?php echo date('d M Y',$p->date);?></td>
				<td><?php echo $p->cleared;?></td>
				<td><?php echo number_format($p->charge);?></td>
				<td><?php echo $p->description;?></td>

			 <td width='30'>
						 <div class='btn-group'>
							<button class='btn dropdown-toggle' data-toggle='dropdown'>Action <i class='glyphicon glyphicon-caret-down'></i></button>
							<ul class='dropdown-menu pull-right'>
								 <li><a href='<?php echo site_url('admin/students_clearance/view/'.$p->student.'/'.$page);?>'><i class='glyphicon glyphicon-eye-open'></i> View</a></li>
								<li><a  href='<?php echo site_url('admin/students_clearance/edit/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-edit'></i> Edit</a></li>
							  
								<li><a  onClick="return confirm('<?php echo lang('web_confirm_delete')?>')" href='<?php echo site_url('admin/students_clearance/delete/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-trash'></i> Trash</a></li>
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