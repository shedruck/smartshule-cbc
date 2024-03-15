<div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h2>  Schemes Of Work  </h2>
             <div class="right">  
             <?php echo anchor( 'admin/schemes_of_work/create/'.$page, '<i class="glyphicon glyphicon-plus"></i> '.lang('web_add_t', array(':name' => 'Schemes Of Work')), 'class="btn btn-primary"');?>
			 
			 <?php echo anchor( 'admin/schemes_of_work' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Schemes Of Work')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
              
                 <?php if ($schemes_of_work): ?>
                 <div class="block-fluid">
				<table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
	 <thead>
                <th>#</th>
				
				<th>Level</th>
				<th>Week</th>
				<th>Period</th>
				
				<th>subject</th>
				<th>Lesson</th>
				<th>Strand</th>
				<th>Specific Learning Outcomes</th>
				<th>Key Inquiry Question</th>
				<th>Learning Experiences</th>
				<th>Learning Resources</th>
				<th>Assessment</th>
				<th>Reflection</th>	
				<th ><?php echo lang('web_options');?></th>
		</thead>
		<tbody>
		<?php 
                             $i = 0;
                                  $classes = $this->portal_m->get_class_options();  
            foreach ($schemes_of_work as $p ): 
			$sub = $this->portal_m->get_subject($p->level);
                 $i++;
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>
<td><?php echo $classes[$p->level];?></td>				
				<td>Term  <?php echo $p->term;?> <?php echo $p->year;?></td>
					
					<td><?php echo $p->week;?></td>
					<td><?php echo strtoupper($sub[$p->subject]);?></td>
					<td><?php echo $p->lesson;?></td>
					<td><?php echo $p->strand;?><br> <b>Sub-strand:</b> <?php echo $p->substrand;?></td>
					<td><?php echo $p->specific_learning_outcomes;?></td>
					<td><?php echo $p->key_inquiry_question;?></td>
					<td><?php echo $p->learning_experiences;?></td>
					<td><?php echo $p->learning_resources;?></td>
					<td><?php echo $p->assessment;?></td>
					<td><?php echo $p->reflection;?></td>

			 <td width='30'>
						 <div class='btn-group'>
							<button class='btn dropdown-toggle' data-toggle='dropdown'>Action <i class='glyphicon glyphicon-caret-down'></i></button>
							<ul class='dropdown-menu pull-right'>
								 <li><a href='<?php echo site_url('admin/schemes_of_work/edit/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-eye-open'></i> View</a></li>
								<li><a  href='<?php echo site_url('admin/schemes_of_work/edit/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-edit'></i> Edit</a></li>
							  
								<li><a  onClick="return confirm('<?php echo lang('web_confirm_delete')?>')" href='<?php echo site_url('admin/schemes_of_work/delete/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-trash'></i> Trash</a></li>
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