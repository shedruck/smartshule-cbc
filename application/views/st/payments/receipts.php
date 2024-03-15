					 
<div class="row">
    <div class="col-md-12">
        <div class="card recent-operations-card">
            <div class="card-block">
                <div class="page-header">
                    <div class="page-block">
                        <div class="row align-items-center">
                            <div class="col-md-4">
                                <h4 class="m-b-10">
								 Receipts
                                </h4>
                            </div>
                           <div class="col-md-8 " >
                                <div class="pull-right">
                             	<?php echo anchor( 'st' , '<i class="fa fa-home">
                </i> Exit', 'class="btn btn-sm btn-danger"');?> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>  
			
			
				
     <div class="block-fluid">
		  <?php $settings = $this->ion_auth->settings();?>
		  
  <div class="image text-center" >
			<img  src="<?php echo base_url('uploads/files/' . $settings->document); ?>" class="text-center" align="center" style="" width="120" height="120" />    
		</div>

                
				<h3 style="text-align: center;"><?php echo $settings->school;?></h3>

<p style="text-align: center;"><?php echo $settings->postal_addr;?></p>

<p style="text-align: center;">Tel: <?php echo $settings->tel;?> <?php echo $settings->cell;?>&nbsp; &nbsp;&nbsp;&nbsp; Email: <?php echo $settings->email;?></p>
<hr>

	<div class="table-responsive">
					
							  <table id="datatable-buttons" class="table table-striped table-bordered">
							<thead>
								<tr>
									<th>Date</th>
									<th>Student</th>
									<th>Amount</th>
									<th>Bank</th>
									<th>Reference</th>
									<th>Type</th>
									<th>Details</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
							<?php 
							
								$i=0;
								
								$banks = $this->ion_auth->populate('bank_accounts','id','bank_name');
								$fee = $this->ion_auth->populate('fee_extras','id','title');
							
						
								

								foreach($recs as $p){
									
									$st = $this->portal_m->find($p->reg_no);
							
								
								?>
								<tr>
									<td><?php echo date('d M Y',$p->payment_date);?></td>
									<td>
										<?php echo $st->first_name.' '.$st->last_name;?>
									</td>
									<td><?php echo $p->amount;?></td>
									<td><?php echo $banks[$p->bank_id];?></td>
									<td><?php echo $p->transaction_no;?></td>
									<td><?php echo $p->payment_method;?></td>
									<td><?php 
									if($p->description==0) echo 'Tuition Fee';
									else  echo $fee[$p->description];?></td>
									
									
									<td>
										<div class="table-action">
											<a href="<?php echo base_url('fee_payment/receipt/'.$p->receipt_id)?>" class="btn btn-sm btn-outline-success">
												<span class="fa fa-folder-open"></span> View Receipt
											</a>
										
										</div>
									</td>
								</tr>
							
							<?php } ?>
							</tbody>
						</table>

					</div>



</div>
</div>
</div>
</div>
</div>



