<div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h2>  Staff Clearance  </h2>
             <div class="right">  
             <?php echo anchor( 'admin/staff_clearance/create/'.$page, '<i class="glyphicon glyphicon-plus"></i> '.lang('web_add_t', array(':name' => 'Staff Clearance')), 'class="btn btn-primary"');?>
			 
			 <?php echo anchor( 'admin/staff_clearance/bulk' , '<i class="glyphicon glyphicon-plus">
                </i> '.lang('web_add_t', array(':name' => 'Bulk Clearance')), 'class="btn btn-warning"');?> 
			 
			 <?php echo anchor( 'admin/staff_clearance' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Staff Clearance')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
              
                 <?php if ($staff_clearance): ?>
                 <div class="block-fluid">
				<table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
	 <thead>
                <th>#</th>
				<th>Staff</th>
				<th>Date</th>
				<th>Cleared</th>
				<th>Charge</th>
				<th>Description</th>	
				<th ><?php echo lang('web_options');?></th>
		</thead>
		<tbody>
		<?php 
                             $i = 0;
                                if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                                {
                                    $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                                }
                
            foreach ($staff_clearance as $p ): 
                 $i++;
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>					
				<td><?php 
				if($p->group==1) echo $teachers[$p->staff];
				if($p->group==2) echo $non_teaching[$p->staff];
				if($p->group==3) echo $subordinate[$p->staff];
				
				?></td>
				<td><?php echo date('d M Y',$p->date);?></td>
				<td><?php echo $p->cleared;?></td>
				<td><?php echo $p->charge;?></td>
				<td><?php echo $p->description;?></td>

			 <td width='30'>
						 <div class='btn-group'>
							<button class='btn dropdown-toggle' data-toggle='dropdown'>Action <i class='glyphicon glyphicon-caret-down'></i></button>
							<ul class='dropdown-menu pull-right'>
								 <li><a href='<?php echo site_url('admin/staff_clearance/view/'.$p->staff.'/'.$page);?>'><i class='glyphicon glyphicon-eye-open'></i> View</a></li>
								<li><a  href='<?php echo site_url('admin/staff_clearance/edit/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-edit'></i> Edit</a></li>
							  
								<li><a  onClick="return confirm('<?php echo lang('web_confirm_delete')?>')" href='<?php echo site_url('admin/staff_clearance/delete/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-trash'></i> Trash</a></li>
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