<div class="portlet mt-2">
    <div class="portlet-heading portlet-default border-bottom">
        <h3 class="portlet-title text-dark">
           <b>  Record Of Work Covered    </b>
        </h3>
		<div class="pull-right">
		
		 <?php echo anchor( 'record_of_work_covered/trs/create/'.$page, '<i class="glyphicon glyphicon-plus"></i> '.lang('web_add_t', array(':name' => 'Record Of Work Covered')), 'class="btn btn-primary"');?>
		 
		  <a class="btn btn-danger " onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
			</div> 
      
        <div class="clearfix"></div>
        <hr>
    </div>
           
              
                 <?php if ($record_of_work_covered): ?>
                 <div class="block-fluid">
				<table id="datatable-buttons" class="table table-striped table-bordered">
	 <thead>
                <th>#</th>
				
				<th>Level</th>
				<th>Period</th>
				<th>Week</th>
				<th>Learning Area</th>
				<th>Strand</th>
				<th>Sub-strand</th>
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
					
					<td width='220'>
						 <div class='btn-group center text-center'>
							 <a class="btn btn-sm btn-success" href='<?php echo site_url('record_of_work_covered/trs/view/'.$p->id.'/'.$this->session->userdata['session_id']);?>'><i class='fa fa-share'></i> View</a>
							<a class="btn btn-sm btn-primary" href='<?php echo site_url('record_of_work_covered/trs/edit/'.$p->id.'/'.$this->session->userdata['session_id']);?>'><i class='fa fa-edit'></i> Edit</a>
							<a  class="btn btn-sm btn-danger" onClick="return confirm('<?php echo lang('web_confirm_delete')?>')" href='<?php echo site_url('record_of_work_covered/trs/delete/'.$p->id.'/'.$this->session->userdata['session_id']);?>'><i class='fa fa-trash'></i> Trash</a>
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