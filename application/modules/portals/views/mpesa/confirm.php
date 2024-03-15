<div class="col-md-7 d-flex">
					<div class="card ctm-border-radius shadow-sm grow flex-fill">
						<div class="card-header">
							<h4 class="card-title mb-0 text-center">
								Payment processed on <?php echo date('d M Y',$p->payment_date); ?>
								<a href="<?php echo base_url();?>" class="float-right text-primary"><i class="fa fa-times" aria-hidden="true"></i></a>
							</h4>
						</div>
						<div class="card-body">
							<div class="row">
							<?php 
								
									$u = $this->portal_m->find($p->reg_no);  
									$pays = $this->portal_m->payment_options('payment_options', 'id', 'account');
								
								?>
								<table class="table">
									<tr><td class="text-primary">Student : </td> <td><?php echo $u->first_name.' '.$u->last_name?></td></tr>
								
									<tr><td class="text-primary">Account paid to : </td> <td>0560299737497</td></tr>
									
									<tr><td class="text-primary">Amount (Ksh): </td> <td><?php echo number_format($p->amount,2)?></td></tr>
									
									<tr><td class="text-primary">Phone : </td> <td><?php echo $p->phone?></td></tr>
									
									<tr><td class="text-primary">Status : </td> <td> 
									
									<?php 
										if($p->status==0) echo '<span class="badge custom-badge badge-danger"> Pending</span>';
										elseif($p->status==1) echo '<span class="badge custom-badge badge-success"> Paid</span>';
										
									 ?>
									</td>
									</tr>
									
								</table>
								
							</div>
							<div class="text-center mt-3">
								<a class="btn btn-info btn-sm" href="<?php echo base_url('fee_payment/statement/'.$p->reg_no)?>"><i class="fa fa-file"></i> &nbsp;&nbsp; View statement</a>
								<a class="btn btn-success btn-sm pull-right" href="<?php echo current_url()?>"> <i class="fa fa-sync-alt"></i> &nbsp;&nbsp;Refresh</a>
							</div>
						</div>
					</div>
				</div>
		
 <script type="text/javascript">
        $(document).ready(function(){
	  
			swal({
			  title: "M-Pesa Payment!",
			  text: "M-Pesa push notification has been sent to <?php echo $phone; ?> kindly enter password to make payment.",
			  icon: "success",
			  button:'Close',
			  dangerMode: true,
			});
		 });
</script>