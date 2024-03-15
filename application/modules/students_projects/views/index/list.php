
<div class="portlet mt-2">
    <div class="portlet-heading portlet-default border-bottom">
        <h3 class="portlet-title text-dark">
           <b>  Students Projects   </b>
        </h3>
		<div class="pull-right">
		
		 <?php echo anchor( 'students_projects/trs/create/'.$page, '<i class="glyphicon glyphicon-plus"></i> '.lang('web_add_t', array(':name' => 'Student Projects')), 'class="btn btn-primary"');?>
		 
		  <a class="btn btn-danger " onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
			</div> 
      
        <div class="clearfix"></div>
        <hr>
    </div>

                 <?php if ($students_projects): ?>
                 <div class="block-fluid">
				<table id="datatable-buttons" class="table table-striped table-bordered">
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
<td width='220'>
						 <div class='btn-group center text-center'>
							 <a class="btn btn-sm btn-success" href='<?php echo site_url('students_projects/trs/view/'.$p->id.'/'.$this->session->userdata['session_id']);?>'><i class='fa fa-share'></i> View</a>
							<a class="btn btn-sm btn-primary" href='<?php echo site_url('students_projects/trs/edit/'.$p->id.'/'.$this->session->userdata['session_id']);?>'><i class='fa fa-edit'></i> Edit</a>
							<a  class="btn btn-sm btn-danger" onClick="return confirm('<?php echo lang('web_confirm_delete')?>')" href='<?php echo site_url('students_projects/trs/delete/'.$p->id.'/'.$this->session->userdata['session_id']);?>'><i class='fa fa-trash'></i> Trash</a>
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