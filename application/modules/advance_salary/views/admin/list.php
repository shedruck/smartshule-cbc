<div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h2>  Advance Salary  </h2>
             <div class="right">  
             <?php echo anchor( 'admin/advance_salary/create/'.$page, '<i class="glyphicon glyphicon-plus"></i> '.lang('web_add_t', array(':name' => 'Advance Salary')), 'class="btn btn-primary"');?>
			 
			 <?php echo anchor( 'admin/advance_salary' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Advance Salary')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
              
                 <?php if ($advance_salary): ?>
                 <div class="block-fluid">
				<table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
	 <thead>
                <th>#</th>
				<th>Advance Date</th>
				<th>Employee</th>
				<th>Amount (<?php echo $this->currency;?>)</th>
				<th>Comment</th>	
				<th>Processed By</th>	
				<th ><?php echo lang('web_options');?></th>
		</thead>
		<tbody>
		<?php 
                             $i = 0;
                                if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                                {
                                    $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                                }
                
            foreach ($advance_salary as $p ): 
			$u=$this->ion_auth->get_user($p->created_by);
                 $i++;
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>					
				<td><?php echo date('d M Y',$p->advance_date);?></td>
				<td><?php echo $employees[$p->employee];?></td>
					<td><?php echo number_format($p->amount,2);?></td>
					<td><?php echo $p->comment;?></td>
					<td><?php echo $u->first_name.' '.$u->last_name;?></td>

			 <td width='20%'>
						 <div class='btn-group'>
							<button class='btn dropdown-toggle' data-toggle='dropdown'>Action <i class='glyphicon glyphicon-caret-down'></i></button>
							<ul class='dropdown-menu pull-right'>
								 
								<li><a  href='<?php echo site_url('admin/advance_salary/edit/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-edit'></i> Edit</a></li>
							  
								<li><a  onClick="return confirm('<?php echo lang('web_confirm_delete')?>')" href='<?php echo site_url('admin/advance_salary/delete/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-trash'></i> Trash</a></li>
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