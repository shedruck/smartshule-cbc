<div class="card-box table-responsive"> 
<div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h3> Class Assignments
             <div class="pull-right">  
              <a class="btn btn-sm btn-danger pull-right" onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
             
                </div>
			</h3>	
	<hr>			
   </div>
         	                    
              
	 <?php if ($class_assignments): ?>
	 <div class="block-fluid">
	   <table id="datatable-buttons" class="table table-striped table-bordered">
	       <thead>
                <th>#</th>
				<th>Title</th>
				<th>Duration</th>
				<th>Subject</th>
				<th>Attachment</th>
				<th>Given By</th>
				<th>Status</th>
				<th ><?php echo lang('web_options');?></th>
	    	</thead>
		<tbody>
		<?php 
		
           $i = 0;
		   
            foreach ($class_assignments as $p ): 
			$u = $this->ion_auth->get_user($p->created_by);
			 $done = $this->st_m->get_done_assgn($this->student->id,$p->id);
			  $sub = $this->portal_m->get_subject($p->class);
                 $i++;
                     ?>
	      <tr>
                <td><?php echo $i . '.'; ?></td>					
				<td><?php echo $p->title;?></td>
				<td>Start: <?php echo date('d M Y',$p->start_date);?><br>
				End:<span class="text-red"><?php echo date('d M Y',$p->end_date);?></span></td>
			
				<td><?php echo isset($sub[$p->subject]) ? $sub[$p->subject] : '';?></td>
				
				<td>
				  <?php
							if (!empty($p->document))
							{
									?>
									<a target="_blank" class="label label-info" href="<?php echo base_url('uploads/files/' . $p->document); ?>"><i class="fa fa-download"></i> Download </a>
									<?php
							}
							else
							{
									?>
									<b>---------</b>
					<?php } ?>
				</td>
				<td><?php echo $u->first_name.' '.$u->last_name;?></td>
				<td><?php if( $done  )echo '<span class="label label-success">Done</span>'; else echo '<span class="label label-danger">Pending</span>';?></td>

			      <td width=''>
						 <div class='btn-group'>
							
						<a class="btn btn-primary btn-sm" href='<?php echo site_url('st/assignments_view/'.$p->id.'/'.$p->class.'/'.$this->session->userdata['session_id']);?>'><i class='fa  fa-share'></i> View</a>

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