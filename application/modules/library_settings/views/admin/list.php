<div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h2>  Library Settings  </h2>
             <div class="right">  
             <?php echo anchor( 'admin/library_settings/create/'.$page, '<i class="glyphicon glyphicon-plus"></i> '.lang('web_add_t', array(':name' => 'Library Settings')), 'class="btn btn-primary"');?>
			 
			 <?php echo anchor( 'admin/library_settings' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Library Settings')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
              
                 <?php if ($library_settings): ?>
                 <div class="block-fluid">
				<table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
	 <thead>
                <th>#</th>
				<th>Fine</th>
				<th>Book Duration</th>	
				<th>Borrow Limit</th>	
				<th>Created By</th>	
				<th>Created On</th>	
				<th ><?php echo lang('web_options');?></th>
		</thead>
		<tbody>
		<?php 
                             $i = 0;
                                if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                                {
                                    $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                                }
                
            foreach ($library_settings as $p ): 
                 $i++;
				 $u=$this->ion_auth->get_user($p->created_by);
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>					
				<td><?php echo $p->fine;?></td>
					<td><?php echo $p->book_duration;?> Days</td>
					<td><?php echo $p->limit;?> Books</td>
					<td><?php echo $u->first_name.' '.$u->last_name;?></td>
					<td><?php echo date('d/m/Y',$p->created_on);?></td>

			 <td width='20%'>
						 <div class='btn-group'>
							<a class="btn btn-primary" href='<?php echo site_url('admin/library_settings/edit/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-edit'></i> Edit</a>
							  
						   <a class="btn btn-danger" onClick="return confirm('<?php echo lang('web_confirm_delete')?>')" href='<?php echo site_url('admin/library_settings/delete/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-trash'></i> Trash</a>
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