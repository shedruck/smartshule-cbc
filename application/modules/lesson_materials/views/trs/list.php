<div class="portlet mt-2">
    <div class="portlet-heading portlet-default border-bottom">
        <h3 class="portlet-title text-dark">
           <b> Lesson Materials    </b>
        </h3>
		 <a class="btn btn-sm btn-danger pull-right" onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
		 <?php echo anchor( 'lesson_materials/trs/new_lesson_materials/'.$this->session->userdata['session_id'], '<i class="fa fa-plus"></i> New Lesson Material', 'class="btn btn-primary btn-sm pull-right"');?>
      
        <div class="clearfix"></div>
        <hr>
    </div>
         	                    
              
	 <?php if ($lesson_materials): ?>
	 <div class="block-fluid">
	<table id="datatable-buttons" class="table table-striped table-bordered">
	 <thead>
                <th>#</th>
				<th>Class</th>
				<th>Subject</th>
				<th>Topic</th>
				<th>Subtopic</th>
				<th>File</th>
				<th>Status</th>
			
				<th ><?php echo lang('web_options');?></th>
		</thead>
		<tbody>
		<?php 
                             $i = 0;

               $classes = $this->portal_m->get_class_options();                    
            foreach ($lesson_materials as $p ): 
			$sub = $this->portal_m->get_subject($p->class);
                 $i++;
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>					
				 <td><?php echo $classes[$p->class];?></td>
					<td><?php echo strtoupper($sub[$p->subject]);?></td>
					<td><?php echo $p->topic;?></td>
					<td><?php echo $p->subtopic;?></td>
					<td><a class="btn btn-sm btn-info" target="_blank" href='<?php echo base_url()?><?php echo $p->file_path?><?php echo $p->file_name;?>' /><i class='fa fa-arrow-down'></i> Download</a></td>
					
							<td>
						<?php 
						if($p->status==1){
						?>
						<a class="btn btn-sm btn-danger" onClick="return confirm('Are you sure you want to unpublish this lesson material?')" href='<?php echo site_url('lesson_materials/trs/update_status/'.$p->id.'/0');?>'><i class='fa fa-download'></i> Unpublish</a>
							
						<?php }else{?>
						
						<a class="btn btn-sm btn-success" onClick="return confirm('Are you sure you want to publish this lesson material?')" href='<?php echo site_url('lesson_materials/trs/update_status/'.$p->id.'/1');?>'><i class='fa fa-upload'></i> Publish</a>
						<?php }?>
						</td>
					
					

			 <td width='250'>
						 <div class='btn-group center text-center'>
							 <a class="btn btn-sm btn-success" href='<?php echo site_url('lesson_materials/trs/view/'.$p->id.'/'.$this->session->userdata['session_id']);?>'><i class='fa fa-share'></i> View</a>
							<a class="btn btn-sm btn-primary" href='<?php echo site_url('lesson_materials/trs/edit/'.$p->id.'/'.$this->session->userdata['session_id']);?>'><i class='fa fa-edit'></i> Edit</a>
							<a  class="btn btn-sm btn-danger" onClick="return confirm('<?php echo lang('web_confirm_delete')?>')" href='<?php echo site_url('lesson_materials/trs/delete/'.$p->id.'/'.$this->session->userdata['session_id']);?>'><i class='fa fa-trash'></i> Trash</a>
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