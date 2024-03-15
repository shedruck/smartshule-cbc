<div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h2>  Emergency Contacts  </h2>
             <div class="right">  
          
                </div>
                </div>
         	                    
              
                 <?php if ($emergency_contacts): ?>
                 <div class="block-fluid">
				<table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
	 <thead>
                <th>#</th>
				<th>Name</th>
				<th>Phone</th>
				<th>Email</th>
				<th>Address</th>	
				<th ><?php echo lang('web_options');?></th>
		</thead>
		<tbody>
		<?php 
                             $i = 0;
                                if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                                {
                                    $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                                }
                
            foreach ($emergency_contacts as $p ): 
                 $i++;
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>					<td><?php echo $p->name;?></td>
					<td><?php echo $p->phone;?></td>
					<td><?php echo $p->email;?></td>
					<td><?php echo $p->address;?></td>

			 <td width=''>
						 <div class='btn-group'>
						 <a  class='btn btn-success' href='<?php echo site_url('admin/emergency_contacts/edit/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-edit'></i> Edit</a>
							
						<a  class='btn btn-danger' onClick="return confirm('<?php echo lang('web_confirm_delete')?>')" href='<?php echo site_url('admin/emergency_contacts/delete/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-trash'></i> Trash</a>
						
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