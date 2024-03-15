<div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h2>  Fee Statements  </h2>
             
                </div>
         	                    
              
                 <?php if ($fee_payment): ?>
                 <div class="block-fluid">
				<table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
	 <thead>
                <th>#</th>
				<th>Student</th>
				<th>Total Paid</th>
				<th>Last Payment Date</th>
				<th>Last Recorded By</th>
				<th ><?php echo lang('web_options');?></th>
		</thead>
		<tbody>
		<?php 
                             $i = 0;
                                if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                                {
                                    $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                                }
                
			$data=$this->ion_auth->students_full_details(); 
            foreach ($fee_payment as $p ): 
			$amt=$this->fee_payment_m->total_paid($p->reg_no);
			$user=$this->ion_auth->get_user($p->created_by);
                 $i++;
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>
				<td><?php echo $data[$p->reg_no];?></td>
				<td>KES. <?php echo number_format($amt->amount,2);?></td>
				<td><?php echo date('d/m/Y',$p->created_on);?></td>
				<td><?php echo $user->first_name.' '.$user->last_name;?></td>
				

			 <td width='20%'>
						 <div class='btn-group'>
							<button class='btn dropdown-toggle' data-toggle='dropdown'>Action <i class='glyphicon glyphicon-caret-down'></i></button>
							<ul class='dropdown-menu pull-right'>
								 <li><a href='<?php echo site_url('admin/fee_payment/view/'.$p->reg_no);?>'><i class='glyphicon glyphicon-eye-open'></i> View Details</a></li>
								 <li><a href='<?php echo site_url('admin/fee_payment/view/'.$p->reg_no);?>'><i class='glyphicon glyphicon-eye-open'></i> View Statement</a></li>
								<li><a  href='<?php echo site_url('admin/fee_payment/data_edit/'.$p->reg_no);?>'><i class='glyphicon glyphicon-edit'></i> Edit Payments</a></li>
								<li><a  href='<?php echo site_url('admin/fee_payment/pdf/'.$p->id);?>'><i class='glyphicon glyphicon-download'></i> Download Statement</a></li>
							  
								<!--<li><a  onClick="return confirm('<?php echo lang('web_confirm_delete')?>')" href='<?php echo site_url('admin/fee_payment/void/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-trash'></i> Void</a></li>-->
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