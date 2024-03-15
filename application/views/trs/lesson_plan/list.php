<div class="card-box table-responsive"> 
<div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h3> My Lesson Plan  
             <div class="pull-right">  
             <?php echo anchor( 'trs/add_plan/'.$page, '<i class="mdi  mdi-plus"></i> NewLesson Plan', 'class="btn btn-primary"');?>
             <?php echo anchor( 'trs/add_plan/'.$page, '<i class="fa fa-search"></i> Filter Lesson Plan', 'class="btn btn-success"');?>
			 
			
             
                </div>
			</h3>	
	<hr>			
   </div>
         	                    
              
                 <?php if ($lesson_plan): ?>
                 <div class="block-fluid">
				   <table id="datatable-buttons" class="table table-striped table-bordered">
	 <thead>
                <th>#</th>
			
				<th>Class</th>
				<th>Term</th>
				<th>Year</th>
				<th>Week</th>
				<th>Day</th>
				<th>Subject</th>
				<th>Lesson</th>
				
				<th ><?php echo lang('web_options');?></th>
		</thead>
		<tbody>
		<?php 
                             $i = 0;
           $classes = $this->ion_auth->fetch_classes();                       
                
            foreach ($lesson_plan as $p ): 
                 $i++;
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>					
				
				<td><?php echo isset($p->class) ? $classes[$p->class]: '';?></td>
				<td><?php echo $p->term;?></td>
				<td><?php echo $p->year;?></td>
				<td><?php echo $p->week;?></td>
				<td><?php echo $p->day;?></td>
				<td><?php echo $p->subject;?></td>
				<td><?php echo $p->lesson;?></td>
				

			 <td width='250'>
						 <div class='btn-group'>
							
						<a class="btn btn-success btn-sm" href='<?php echo site_url('trs/view_plan/'.$p->id.'/'.$this->session->userdata['session_id']);?>'><i class='fa  fa-share'></i> View</a>
						<a class="btn btn-primary btn-sm" href='<?php echo site_url('trs/edit_plan/'.$p->id.'/'.$this->session->userdata['session_id']);?>'><i class='fa fa-edit'></i> Edit</a>
					  
						<a class="btn btn-danger btn-sm" onClick="return confirm('<?php echo lang('web_confirm_delete')?>')" href='<?php echo site_url('trs/delete_plan/'.$p->id.'/'.$this->session->userdata['session_id']);?>'><i class='fa  fa-times'></i> Trash</a>
					
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
 
 </div>