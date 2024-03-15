<div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h2>  Online Verifiers  </h2>
           
                </div>
         	                    
              
                 <?php if ($verifiers): ?>
                 <div class="block-fluid">
				<table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
	 <thead>
                <th>#</th>
				<th>UPI Number</th>
				<th>Name</th>
				<th>Phone</th>
				<th>Email</th>
				<th>Code</th>
				<th>Reason</th>	
		</thead>
		<tbody>
		<?php 
                             $i = 0;
                                if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                                {
                                    $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                                }
                
            foreach ($verifiers as $p ): 
                 $i++;
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>					
				<td><?php echo $p->upi_number;?></td>
					<td><?php echo $p->name;?></td>
					<td><?php echo $p->phone;?></td>
					<td><?php echo $p->email;?></td>
					<td><?php echo $p->code;?></td>
					<td><?php echo $p->reason;?></td>

			 
				</tr>
 			<?php endforeach ?>
		</tbody>

	</table>

	
</div>

<?php else: ?>
 	<p class='text'><?php echo lang('web_no_elements');?></p>
 <?php endif ?>