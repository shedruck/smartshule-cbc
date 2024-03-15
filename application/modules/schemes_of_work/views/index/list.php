<div class="portlet mt-2">
    <div class="portlet-heading portlet-default border-bottom">
        <h3 class="portlet-title text-dark">
           <b>  Schemes of Work    </b>
        </h3>
		<div class="pull-right">
		
		 <?php echo anchor( 'schemes_of_work/trs/create/'.$page, '<i class="glyphicon glyphicon-plus"></i> '.lang('web_add_t', array(':name' => 'Schemes of work')), 'class="btn btn-primary"');?>
		 
		  <a class="btn btn-danger " onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
			</div> 
      
        <div class="clearfix"></div>
        <hr>
    </div>

         	                    
              
                 <?php if ($schemes_of_work): ?>
                 <div class="block-fluid">
			<table id="datatable-buttons" class="table table-striped table-bordered">
	 <thead>
                <th>#</th>
				
				<th>Level</th>
				
				<th>subject</th>
				<th>Lesson</th>
				<th>Strand</th>
				<th>Specific Learning Outcomes</th>
				<th>Key Inquiry Question</th>
				
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
<td><?php echo $classes[$p->level];?> <br> Term  <?php echo $p->term;?> <?php echo $p->year;?><br> <b>Week:</b><?php echo $p->week;?></td>
					<td><?php echo strtoupper($sub[$p->subject]);?></td>
					<td><?php echo $p->lesson;?></td>
					<td><?php echo $p->strand;?><br> <b>Sub-strand:</b> <?php echo $p->substrand;?></td>
					<td><?php echo $p->specific_learning_outcomes;?></td>
					<td><?php echo $p->key_inquiry_question;?></td>
					
					
					<td width='220'>
						 <div class='btn-group center text-center'>
							 <a class="btn btn-sm btn-success" href='<?php echo site_url('schemes_of_work/trs/view_scheme/'.$p->id.'/'.$this->session->userdata['session_id']);?>'><i class='fa fa-share'></i> View</a>
							<a class="btn btn-sm btn-primary" href='<?php echo site_url('schemes_of_work/trs/edit/'.$p->id.'/'.$this->session->userdata['session_id']);?>'><i class='fa fa-edit'></i> Edit</a>
							<a  class="btn btn-sm btn-danger" onClick="return confirm('<?php echo lang('web_confirm_delete')?>')" href='<?php echo site_url('schemes_of_work/trs/delete/'.$p->id.'/'.$this->session->userdata['session_id']);?>'><i class='fa fa-trash'></i> Trash</a>
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