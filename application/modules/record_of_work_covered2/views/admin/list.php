<div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h2>  Record Of Work Covered  </h2>
             <div class="right">  
             <?php echo anchor( 'admin/record_of_work_covered/create/'.$page, '<i class="glyphicon glyphicon-plus"></i> '.lang('web_add_t', array(':name' => 'Record Of Work Covered')), 'class="btn btn-primary"');?>
			 
			 <?php echo anchor( 'admin/record_of_work_covered' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Record Of Work Covered')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
              
                 <?php if ($record_of_work_covered): ?>
                 <div class="block-fluid">
				<table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
	 <thead>
                <th>#</th>
				
				<th>Level</th>
				<th>Period</th>
				<th>Week</th>
				<th>Learning Area</th>
				<th>Strand</th>
				<th>Substrand</th>
				<th>Work Covered</th>
				<th>Reflection</th>	<th ><?php echo lang('web_options');?></th>
		</thead>
		<tbody>
		<?php 
                             $i = 0;
                               $classes = $this->portal_m->get_class_options();  
                
            foreach ($record_of_work_covered as $p ): 
			$sub = $this->portal_m->get_subject($p->level);
                 $i++;
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>
                <td><?php echo $classes[$p->level];?></td>				
				<td>Term <?php echo $p->term;?> <br><?php echo $p->year;?> </td>

					<td><?php echo $p->week;?> <br><b>Date:</b> <?php echo date('d M Y', $p->date);?></td>
					<td><?php echo strtoupper($sub[$p->subject]);?></td>
					<td><?php echo $p->strand;?></td>
					<td><?php echo $p->substrand;?></td>
					<td><?php echo $p->work_covered;?></td>
					<td><?php echo $p->reflection;?></td>

			 <td width='30'>
						 <div class='btn-group'>
							<button class='btn dropdown-toggle' data-toggle='dropdown'>Action <i class='glyphicon glyphicon-caret-down'></i></button>
							<ul class='dropdown-menu pull-right'>
								 <li><a href='<?php echo site_url('admin/record_of_work_covered/edit/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-eye-open'></i> View</a></li>
								<li><a  href='<?php echo site_url('admin/record_of_work_covered/edit/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-edit'></i> Edit</a></li>
							  
								<li><a  onClick="return confirm('<?php echo lang('web_confirm_delete')?>')" href='<?php echo site_url('admin/record_of_work_covered/delete/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-trash'></i> Trash</a></li>
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