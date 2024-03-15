<div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h2>  Students Projects  </h2>
             <div class="right">  
             <?php echo anchor( 'admin/students_projects/create/'.$page, '<i class="glyphicon glyphicon-plus"></i> '.lang('web_add_t', array(':name' => 'Students Projects')), 'class="btn btn-primary"');?>
			 
			 <?php echo anchor( 'admin/students_projects' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Students Projects')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
              
                 <?php if ($students_projects): ?>
                 <div class="block-fluid">
				<table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
	 <thead>
                <th>#</th>
				<th>IMG</th>
				<th>Level</th>
				<th>Student</th>
				<th>Period</th>
				<th>Subject</th>
				<th>Strand</th>
				
				<th>Remarks</th>	
				<th ><?php echo lang('web_options');?></th>
		</thead>
		<tbody>
		<?php 
			 $i = 0;
				$classes = $this->portal_m->get_class_options();  
              $data = $this->ion_auth->students_full_details();  
            foreach ($students_projects as $p ): 
			$sub = $this->portal_m->get_subject($p->level);
                 $i++;
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>
<td><img src='<?php echo base_url()?><?php echo $p->file_path?>/<?php echo $p->file_name?>' width="50" height="50" /> </a></td>				
				<td><?php echo $classes[$p->level];?></td>
					<td><?php echo $data[$p->student];?></td>
					<td>Term <?php echo $p->term;?>, <?php echo $p->year;?> </td>
					<td><?php echo strtoupper($sub[$p->subject]);?></td>
					<td><?php echo $p->strand;?></td>
					
					<td><?php echo $p->remarks;?></td>

			 <td width='30'>
						 <div class='btn-group'>
							<button class='btn dropdown-toggle' data-toggle='dropdown'>Action <i class='glyphicon glyphicon-caret-down'></i></button>
							<ul class='dropdown-menu pull-right'>
								
								<li><a  href='<?php echo site_url('admin/students_projects/edit/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-edit'></i> Edit</a></li>
							  
								<li><a  onClick="return confirm('<?php echo lang('web_confirm_delete')?>')" href='<?php echo site_url('admin/students_projects/delete/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-trash'></i> Trash</a></li>
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