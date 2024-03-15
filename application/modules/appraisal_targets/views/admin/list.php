<div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h2>  Appraisal Targets  </h2>
             <div class="right">  
             <?php echo anchor( 'admin/appraisal_targets/create/'.$page, '<i class="glyphicon glyphicon-plus"></i> '.lang('web_add_t', array(':name' => 'Appraisal Targets')), 'class="btn btn-primary"');?>
			 
			 <?php echo anchor( 'admin/appraisal_targets' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Appraisal Targets')), 'class="btn btn-primary"');?> 
             <!-- <button class="btn btn-primary"  onClick="window.location='<?php echo base_url()?>admin/appraisal_targets/appraise'" ><i class="glyphicon glyphicon-check"></i>Appraise</button> -->
            
			 <button class="btn btn-primary"  onClick="window.location='<?php echo base_url()?>admin/appraisal_targets/appraisalResults'" ><i class="glyphicon glyphicon-check"></i>Appraisal Results</button>
			
			</div>
                </div>
         	                    
              
                 <?php if ($appraisal_targets): ?>
                 <div class="block-fluid">
				<table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
	 <thead>
                <th>#</th>
				<th>Year</th>
				<th>Target</th>
				<th>Description</th>	
				<th>Start Date</th>	
				<th>End Date</th>	
				<th ><?php echo lang('web_options');?></th>
		</thead>
		<tbody>
		<?php 
                             $i = 0;
                                if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                                {
                                    $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                                }
                
            foreach ($appraisal_targets as $p ): 
				
				$date_started=date_create($p->start_date);
				$start_date= date_format($date_started, "d/M/Y");

				$date_ending=date_create($p->end_date);
				$stop_date= date_format($date_ending, "d/M/Y");
			
                 $i++;
                     ?>
					
	 <tr>
                <td><?php echo $i . '.'; ?></td>					
				<td><?php echo $p->year;?></td>
					<td><?php echo $p->target;?></td>
					<td><?php echo $p->description;?></td>
					<td><?php echo $start_date;?></td>
					<td><?php echo $stop_date;?></td>

			 <td width='30'>
						 <div class='btn-group'>
							<button class='btn dropdown-toggle' data-toggle='dropdown'>Action <i class='glyphicon glyphicon-caret-down'></i></button>
							<ul class='dropdown-menu pull-right'>
								 <li><a href='<?php echo site_url('admin/appraisal_targets/edit/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-eye-open'></i> View</a></li>
								<li><a  href='<?php echo site_url('admin/appraisal_targets/edit/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-edit'></i> Edit</a></li>
							  
								<li><a  onClick="return confirm('<?php echo lang('web_confirm_delete')?>')" href='<?php echo site_url('admin/appraisal_targets/delete/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-trash'></i> Trash</a></li>
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