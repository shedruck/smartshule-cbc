<div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h2>  Lesson Plan  </h2>
             <div class="right">  
             <?php echo anchor( 'admin/lesson_plan/create/'.$page, '<i class="glyphicon glyphicon-plus"></i> '.lang('web_add_t', array(':name' => 'Lesson Plan')), 'class="btn btn-primary"');?>
			 
			 <?php echo anchor( 'admin/lesson_plan' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Lesson Plan')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
              
                 <?php if ($lesson_plan): ?>
                 <div class="block-fluid">
				<table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
	 <thead>
                <th>#</th>
				<th>Teacher</th>
				<th>Week</th>
				<th>Day</th>
				<th>Subject</th>
				<th>Lesson</th>
				<th>Activity</th>
				<th>Objective</th>
				<th>Materials</th>
				
				<th ><?php echo lang('web_options');?></th>
		</thead>
		<tbody>
		<?php 
                             $i = 0;
                                if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                                {
                                    $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                                }
                
            foreach ($lesson_plan as $p ): 
			$u = $this->portal_m->get_teacher_details($p->teacher);
                 $i++;
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>				
				<td><?php echo $u->first_name.' '.$u->middle_name.' '.$u->last_name;?></td>
				<td><?php echo $p->week;?></td>
				<td><?php echo $p->day;?></td>
				<td><?php echo $p->subject;?></td>
				<td><?php echo $p->lesson;?></td>
				<td><?php echo $p->activity;?></td>
				<td><?php echo $p->objective;?></td>
				<td><?php echo $p->materials;?></td>

			 <td width='30'>
						 <div class='btn-group'>
							<a class="btn btn-sm btn-success" href='<?php echo site_url('admin/lesson_plan/view_plan/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-eye-open'></i> View</a>
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