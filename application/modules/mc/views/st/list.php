 <div class="portlet mt-2">
    <div class="portlet-heading portlet-default border-bottom">
        <h3 class="portlet-title text-dark">
           <b> Multiple Choices   </b>
        </h3>
		 <a class="btn btn-sm btn-danger pull-right" onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
		
        <div class="clearfix"></div>
        <hr>
    </div>
         	                    
              
	 <?php if ($mc): ?>
	 <div class="block-fluid">
	 <div class="table-responsive" >
	  <table id="datatable-buttons" class="table table-striped table-bordered">
	      <thead>
                <th>#</th>
				
				<th>Title</th>
				<th>Duration</th>
				<th>Subject</th>
				<th>Topic</th>
				<th>Questions</th>
				<th>Status</th>
			
				<th><?php echo lang('web_options');?></th>
		</thead>
		<tbody>
		<?php 
                             $i = 0;

          $classes = $this->portal_m->get_class_options();      
            foreach ($mc as $p ): 
			
			
			$done = $this->portal_m->mc_done($p->id,$this->student->id);
			$mcs = $this->portal_m->count_records('mc',$p->id,'mc_questions');
                 $i++;
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>					
			
				<td> <a  href='<?php echo site_url('mc/st/mc_view/'.$p->id.'/'.$this->session->userdata['session_id']);?>'><?php echo $p->title;?></a></td>
				<td> <a  href='<?php echo site_url('mc/st/mc_view/'.$p->id.'/'.$this->session->userdata['session_id']);?>'><?php echo isset($p->hours) ? $p->hours : '0';?>hrs : <?php echo isset($p->minutes) ? $p->minutes : '00';?> mins</a></td>
				<td> <a  href='<?php echo site_url('mc/st/mc_view/'.$p->id.'/'.$this->session->userdata['session_id']);?>'><?php echo $p->subject;?></a></td>
				<td><?php echo $p->topic;?></td>
				<td><span class="label label-info"><?php echo $mcs;?></span></td>
				<td>
				<?php if($done->done==1){?>
				<span class="label label-success">Done</span>
				<?php }else{ ?>
				
				<span class="label label-danger">Pending</span>
				<?php }?>
				</td>
				

			<td width=''>
						 <div class='btn-group pull-right'>
						
					  <?php if($mcs > 0){?>
							  <?php if($done->done==1){?>
							  
							  <a class="btn btn-success btn-sm" href='<?php echo site_url('mc/st/mc_result/'.$p->id.'/'.$this->session->userdata['session_id']);?>'><i class='fa fa-file'></i> View Results</a>
							  
								<?php }else{ ?>
								
								  <a class="btn btn-primary btn-sm" href='<?php echo site_url('mc/st/mc_view/'.$p->id.'/'.$this->session->userdata['session_id']);?>'><i class='fa fa-share'></i> View Details</a>
								  
								<?php }?>
					
					  <?php }?>
						
						</div>
					</td>
				</tr>
 			<?php endforeach ?>
		</tbody>

	</table>

	
</div>
</div>

<?php else: ?>
 	<p class='text'><?php echo lang('web_no_elements');?></p>
 <?php endif ?>