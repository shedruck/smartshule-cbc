<div class="portlet mt-2">
    <div class="portlet-heading portlet-default border-bottom">
        <h3 class="portlet-title text-dark">
           <b> Question and Answers </b>
        </h3>
		 <a class="btn btn-sm btn-danger pull-right" onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
		 <?php echo anchor( 'qa/trs/new_qa/'.$page, '<i class="fa fa-plus"></i> New Q & A', 'class="btn btn-primary btn-sm pull-right"');?>
      
        <div class="clearfix"></div>
        <hr>
    </div>
         	              
              
		 <?php if ($qa): ?>
	  <div class="table-rep-plugin">
		<div class="table-responsive" data-pattern="priority-columns">
		 
		 <table id="datatable-buttons" class="table table-striped table-bordered">
	 <thead>
                <th>#</th>
				<th>Title</th>
				<th>Level</th>
				<th>Subject</th>
				<th>Duration</th>
				<th>Topic</th>
				<th>Questions</th>
				
				<th ><?php echo lang('web_options');?></th>
		</thead>
		<tbody>
		<?php 
			 $i = 0;
		$classes = $this->portal_m->get_class_options();
            foreach ($qa as $p ): 
			$qs = $this->portal_m->count_records('qa',$p->id,'qa_questions');
                 $i++;
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>					
				<td><?php echo $p->title;?></td>
				<td><?php echo $classes[$p->level];?></td>
				<td><?php echo $p->subject;?></td>
					<td><?php echo isset($p->hours) ? $p->hours : '0';?>hrs : <?php echo isset($p->minutes) ? $p->minutes : '00';?> mins</td>
				<td><?php echo $p->topic;?></td>
				<td><span class="label label-info"><?php echo $qs;?></span></td>
				
			 <td width=''>
						 <div class='btn-group'>
							<a class="btn btn-success btn-sm" href='<?php echo site_url('qa/trs/manage/'.$p->id.'/'.$this->session->userdata['session_id']);?>'><i class='fa  fa-share'></i> Manage Q&A </a>
						<a class="btn btn-primary btn-sm" href='<?php echo site_url('qa/trs/edit/'.$p->id.'/'.$this->session->userdata['session_id']);?>'><i class='fa fa-edit'></i> Edit</a>
					  <?php if($qs > 0){?>
					  <a class="btn btn-warning btn-sm" href='<?php echo site_url('qa/trs/view_qa/'.$p->id.'/'.$this->session->userdata['session_id']);?>'><i class='fa fa-list'></i> View </a>
					  <?php }else{?>
						<a class="btn btn-danger btn-sm" onClick="return confirm('<?php echo lang('web_confirm_delete')?>')" href='<?php echo site_url('qa/trs/delete/'.$p->id.'/'.$this->session->userdata['session_id']);?>'><i class='fa  fa-times'></i> Trash</a>
					  <?php } ?>
						</div>
					</td>
				</tr>
 			<?php endforeach ?>
		</tbody>

	</table>

	<table id="tech-companies-1" class="table table-striped table-bordered" style="display:none">
					
	 <thead>
                <th>#</th>
				<th>Title</th>
				<th>Level</th>
				<th>Subject</th>
				<th>Duration</th>
				<th>Topic</th>
				<th>Questions</th>
				
				<th ><?php echo lang('web_options');?></th>
		</thead>
		<tbody>
		<?php 
			 $i = 0;
		$classes = $this->portal_m->get_class_options();
            foreach ($qa as $p ): 
			$qs = $this->portal_m->count_records('qa',$p->id,'qa_questions');
                 $i++;
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>					
				<td><?php echo $p->title;?></td>
				<td><?php echo $classes[$p->level];?></td>
				<td><?php echo $p->subject;?></td>
					<td><?php echo isset($p->hours) ? $p->hours : '0';?>hrs : <?php echo isset($p->minutes) ? $p->minutes : '00';?> mins</td>
				<td><?php echo $p->topic;?></td>
				<td><span class="label label-info"><?php echo $qs;?></span></td>
				
			 <td width=''>
						 <div class='btn-group'>
							<a class="btn btn-success btn-sm" href='<?php echo site_url('qa/trs/manage/'.$p->id.'/'.$this->session->userdata['session_id']);?>'><i class='fa  fa-share'></i> Manage Q&A </a>
						<a class="btn btn-primary btn-sm" href='<?php echo site_url('qa/trs/edit/'.$p->id.'/'.$this->session->userdata['session_id']);?>'><i class='fa fa-edit'></i> Edit</a>
					  <?php if($qs > 0){?>
					  <a class="btn btn-warning btn-sm" href='<?php echo site_url('qa/trs/view_qa/'.$p->id.'/'.$this->session->userdata['session_id']);?>'><i class='fa fa-list'></i> View </a>
					  <?php }else{?>
						<a class="btn btn-danger btn-sm" onClick="return confirm('<?php echo lang('web_confirm_delete')?>')" href='<?php echo site_url('qa/trs/delete/'.$p->id.'/'.$this->session->userdata['session_id']);?>'><i class='fa  fa-times'></i> Trash</a>
					  <?php } ?>
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
 
 
 
 