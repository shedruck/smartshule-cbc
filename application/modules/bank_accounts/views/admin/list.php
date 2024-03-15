<div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h2>  Bank Accounts  </h2>
             <div class="right">  
             <?php echo anchor( 'admin/bank_accounts/create/'.$page, '<i class="glyphicon glyphicon-plus"></i> '.lang('web_add_t', array(':name' => 'Bank Accounts')), 'class="btn btn-primary"');?>
			 
			 <?php echo anchor( 'admin/bank_accounts' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Bank Accounts')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
              
                 <?php if ($bank_accounts): ?>
                 <div class="block-fluid">
				<table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
	 <thead>
                <th>#</th>
				<th>Bank</th>
				<th>Account Name</th>
				<th>Account Number</th>
				<th>Branch</th>
				<th>API</th>
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
                
            foreach ($bank_accounts as $p ): 
                 $i++;
                     ?>
	 		<tr>
					<td><?php echo $i . '.'; ?></td>					
					<td><?php echo $p->bank_name;?></td>
					<td><?php echo $p->account_name;?></td>
					<td><?php echo $p->account_number;?></td>
					<td><?php echo $p->branch;?></td>
					<td>
						<!-- <small> -->
						api_key <u><?php echo $p->api_key;?></u><br>
						api_username <u><?php echo $p->api_username;?></u><br>
						api_secret key <u><?php echo $p->secret_key;?></u><br>
						<!-- </small> -->
					</td>
					<td><?php echo $p->description;?></td>

					 <td width='20%'>
						 <div class='btn-group'>
							
							<a class='btn btn-primary' href='<?php echo site_url('admin/bank_accounts/edit/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-edit'></i> Edit</a>
							 <a class='btn btn-danger' onClick="return confirm('<?php echo lang('web_confirm_delete')?>')" href='<?php echo site_url('admin/bank_accounts/delete/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-trash'></i> Trash</a>
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