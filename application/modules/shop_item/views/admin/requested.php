<?php
// print_r($this->admission_m->get_stds());die();
?>
<div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h2>  Requested Items  </h2>
             <div class="right">  
				
			 
			 <?php echo anchor( 'admin/shop_item' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Shop Item')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
              
                 <?php if ($items): ?>
                 <div class="block-fluid">
				<table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
	 <thead>
                <th>#</th>
                <th>Item</th>
                <th>Requested By</th>
                <th>Requested On</th>
                <th>Requested For</th>
                
                <th>Status</th>
                <th><?php echo lang('web_options');?></th>
		</thead>
		<tbody>
		<?php 
                             $i = 0;
                                if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                                {
                                    $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                                }
                
            foreach ($items as $p ): 
                $u = $this->ion_auth->get_user($p->created_by);
                $stu = $this->worker->get_student($p->student);
                 $i++;
                     ?>
	 <tr>
                    <td><?php echo $i . '.'; ?></td>				
                	<td><?php echo $p->name.' '.$p->size_from. ' '.$p->size_to;?></td>
                    <td><?php echo $u->first_name.' '. $u->last_name.'('.$u->admission_number.')'?></td>
		            <td><?php echo date('d-M-Y',$p->created_on);?></td>
                    <td><?php echo $stu->first_name . ' ' . $stu->last_name; ?> </td>
                    <td>
                        <?php echo $p->status?>
                    </td>

			 <td width='30'>
						 <div class='btn-group'>
							<button class='btn dropdown-toggle' data-toggle='dropdown'>Action <i class='glyphicon glyphicon-caret-down'></i></button>
							<ul class='dropdown-menu pull-right'>
								 <li><a href='<?php echo site_url('admin/shop_item/edit/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-eye-open'></i> View</a></li>
								<li><a  href='<?php echo site_url('admin/shop_item/edit/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-edit'></i> Edit</a></li>
							  
								<li><a  onClick="return confirm('<?php echo lang('web_confirm_delete')?>')" href='<?php echo site_url('admin/shop_item/delete/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-trash'></i> Trash</a></li>
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