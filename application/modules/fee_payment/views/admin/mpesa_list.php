<div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h2> M-Pesa Payment Logs   </h2>
        
                </div>
         	                    
              
                 <?php if ($payments): ?>
                 <div class="block-fluid">
				<table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
	 <thead>
                <th>#</th>
				<th>Date</th>
				<th>Student</th>
				<th>Amount</th>
				<th>Phone</th>
				<th>Account</th>
				<th>Transaction No</th>
				<th>Status</th>
				<th>Time Ago</th>
				
		</thead>
		<tbody>
		<?php 
				 $i = 0;
				if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
				{
					$i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
				}
            $classes = $this->ion_auth->fetch_classes(); 
			
            foreach ($payments as $p ): 
			$u = $this->portal_m->find($p->reg_no);
                 $i++;
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>					
                <td><?php echo date('d M Y',$p->payment_date); ?></td>					
				<td>
					<?php echo $u->first_name;?> <?php echo $u->last_name; ?> 
					<br><small><b>Admission No:</b> <?php echo isset($u->old_adm_no) ? $u->old_adm_no : $u->admission_number;?></small>
					<br><small><b>Class:</b> <?php echo $classes[$u->class];?></small>
				</td>
				<td><?php echo number_format($p->amount,2);?></td>
				<td><?php echo $p->phone; ?></td> 
				<td><?php echo $pays[$p->account];?></td>
				<td><?php echo $p->transaction_no;?></td>
				<td>
				<?php 
				if($p->status==0) echo '<span class="label label-warning"> Pending</span>';
				elseif($p->status==1) echo '<span class="label label-success"> Paid</span>';
				
				?>
				
				</td>
				 <td><i><?php echo time_ago($p->payment_date); ?></i></td>	
			
				</tr>
 			<?php endforeach ?>
		</tbody>

	</table>

	
</div>

<?php else: ?>
 	<p class='text'><?php echo lang('web_no_elements');?></p>
 <?php endif ?>