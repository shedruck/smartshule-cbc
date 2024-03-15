<div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h2>  Audit Logs  </h2>
             <div class="right">  
           
                </div>
                </div>
         	                    
              
                 <?php if ($audit_logs): ?>
                 <div class="block-fluid">
				<table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
	 <thead>
                <th>#</th>
				<th width="180">Transaction Type</th>
				<th style="width:200px" >Description</th>	
				<th>Details</th>
					<th>Recorded by</th>	
                <th width="150">Date </th>
                <th width="150">Time </th>
            			
				
		</thead>
		<tbody>
		<?php 
				 $i = 0;
					if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
					{
						$i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
					}
                
            foreach ($audit_logs as $p ): 
			$u = $this->ion_auth->get_user($p->created_by);
                 $i++;
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>					
				<td><b><?php echo ucwords($p->module);?></b> <br> <?php echo ucwords($p->transaction_type);?> - Item: <?php echo $p->item_id;?></td>
		
				<td style="width:200px !important;"><a href="<?php echo $p->description;?>" target="_blank"><?php echo substr($p->description,0,30);?>..</a> </td>
				<td><?php echo $p->details;?></td>
				
		  <td width='100'><?php echo $u->first_name.' '. $u->last_name;?></td>
		  <td><?php echo date('d-M-Y',$p->created_on);?></td>
		  <td><?php echo time_ago($p->created_on);?></td>

			
				</tr>
 			<?php endforeach ?>
		</tbody>

	</table>

	
</div>

<?php else: ?>
 	<p class='text'><?php echo lang('web_no_elements');?></p>
 <?php endif ?>