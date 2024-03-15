<div class="head">
                    <div class="icon"><span class="icosg-target1"></span></div>
                    <h2> Fee Structure  </h2> 
                     <div class="right">                            
                       
             <?php echo anchor( 'admin/fee_structure/create/', '<i class="glyphicon glyphicon-plus"></i> Add New Fee Structure', 'class="btn btn-primary"');?>
             
                <?php echo anchor( 'admin/fee_structure/' , '<i class="glyphicon glyphicon-list">
                </i> List All', 'class="btn btn-primary"');?>
			
                     </div>    					
                </div>
         	        <?php if ($post): ?>              
               <div class="block-fluid">
				<table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
 
	    <thead>
                <th>#</th>
				<th>Dated for</th>
				<th>Class</th>
				<th>Amount (<?php echo $this->currency;?>)</th>
				<th>Students</th>
				<th>Total Fees (<?php echo $this->currency;?>)</th>
				<th>Paid Fees (<?php echo $this->currency;?>)</th>
				<th ><?php echo lang('web_options');?></th>
		</thead>
		<tbody>
		<?php 
                             $i = 0;
                                if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                                {
                                    $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                                }
                
            foreach ($post as $p ): 
                 $i++;
				 $stds=$this->ion_auth->students_per_class($p->school_class)
                     ?>
	 <tr>
                      <td><?php echo $i . '.'; ?></td>					
				     <td><?php echo date('d/m/Y',$p->fee_structure_date);?></td>
				     <td><?php echo $class[$p->school_class];?></td>
				     <td style="color:blue">
					 <?php 
					 $totals=($p->tution_fee+$p->examination_fee+$p->medical_subscription+$p->academic_trips+$p->activity_fee+$p->registration+$p->computer_fee+$p->internet_fee+$p->library+$p->student_union);
					 echo number_format($totals,2);?>
					 </td>
					<td><?php echo $stds;?></td>
					<td style="color:green; font-weight:bold"><?php 
					$total_fees=$totals*$stds;
					echo number_format($total_fees,2);?></td>
					<td><?php //echo number_format($p->activity_fee,2);?></td>
					
					
					
			 <td width="150">
			<a class="btn btn-success" href="<?php echo site_url('admin/fee_structure/view/'.$p->id);?>"><i class="glyphicon glyphicon-eye-open"></i> View Structure</a>
				</td>
				</tr>
 			<?php endforeach ?>
		</tbody>

	</table>
	</div>

	

<?php else: ?>
 	<p class='text'><?php echo lang('web_no_elements');?></p>
 <?php endif ?>