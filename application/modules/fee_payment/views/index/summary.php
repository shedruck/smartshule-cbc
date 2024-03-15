
                    <div class="row mb-32pt">
                       
                        <div class="col-lg-12 d-flex align-items-center">
                            <div class="flex"
                                 style="max-width: 100%">

                                <div class="card dashboard-area-tabs p-relative o-hidden mb-0">
                                    <div class="card-header p-0 nav">
                                        <div class="row no-gutters"
                                             role="tablist">
                                            <div class="col-auto">
                                                <a  id="payments-tab"  href="#payments-tab-home"
                                                   data-toggle="tab"
                                                   role="tab"
                                                   aria-selected="true"
                                                   class="dashboard-area-tabs__tab card-body d-flex flex-row align-items-center justify-content-start active">
                                                    <span class="h2 mb-0 mr-3">1</span>
                                                    <span class="flex d-flex flex-column">
                                                        <strong class="card-title">Fee Statements</strong>
                                                         <small class="card-subtitle text-50">Click to view</small>
                                                    </span>
                                                </a>
                                            </div>
                                            <div class="col-auto border-left border-right">
                                                <a  id="receipt-tab"  href="#receipt-tab-home" 
                                                   data-toggle="tab"
                                                   role="tab"
                                                   aria-selected="false"
                                                   class="dashboard-area-tabs__tab card-body d-flex flex-row align-items-center justify-content-start">
                                                    <span class="h2 mb-0 mr-3">2</span>
                                                    <span class="flex d-flex flex-column">
                                                        <strong class="card-title">Receipts</strong>
                                                         <small class="card-subtitle text-50">Click to view</small>
                                                    </span>
                                                </a>
                                            </div>
											<div class="col-auto border-left border-right">
                                                <a id="waivers-tab" href="#waivers-tab-home" 
                                                   data-toggle="tab"
                                                   role="tab"
                                                   aria-selected="false"
                                                   class="dashboard-area-tabs__tab card-body d-flex flex-row align-items-center justify-content-start">
                                                    <span class="h2 mb-0 mr-3">3</span>
                                                    <span class="flex d-flex flex-column">
                                                        <strong class="card-title">Fee Waivers</strong>
                                                         <small class="card-subtitle text-50">Click to view</small>
                                                    </span>
                                                </a>
                                            </div>
											<div class="col-auto border-left border-right">
                                                <a id="pledges-tab" href="#pledges-tab-home" 
                                                   data-toggle="tab"
                                                   role="tab"
                                                   aria-selected="false"
                                                   class="dashboard-area-tabs__tab card-body d-flex flex-row align-items-center justify-content-start">
                                                    <span class="h2 mb-0 mr-3">4</span>
                                                    <span class="flex d-flex flex-column">
                                                        <strong class="card-title">Fee Pledges</strong>
                                                         <small class="card-subtitle text-50">Click to view</small>
                                                    </span>
                                                </a>
                                            </div>
											<div class="col-auto border-left border-right">
                                                <a  id="p-options-tab"  href="#p-options-tab-home"
                                                   data-toggle="tab"
                                                   role="tab"
                                                   aria-selected="false"
                                                   class="dashboard-area-tabs__tab card-body d-flex flex-row align-items-center justify-content-start">
                                                    <span class="h2 mb-0 mr-3">5</span>
                                                    <span class="flex d-flex flex-column">
                                                        <strong class="card-title">Payment Options</strong>
                                                        <small class="card-subtitle text-50">Click to view</small>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body tab-content">
                                         <div class="tab-pane active text-70" id="payments-tab-home"  >
										
											<div class="table-responsive">

													<?php
													$ct = count($this->parent->kids);
													$bal = 0;
													foreach ($this->parent->kids as $pp)
													{
															$bal += $pp->balance;
													}
													?>  
													<div class="table-responsive">

														<table class="display table bordered">
															<tr >
																<th>#</th>
																<th>Student</th>
																<th title="Fee For Current Term">Term's Fee</th>
																<th>Paid</th>
																<th title="Overall Balance">Balance</th>
																<td></td>
															</tr>
															<tbody>
																<?php
																$i = 0;
																$bl = 0;
																foreach ($this->parent->kids as $k)
																{
																		$std = $this->worker->get_student($k->student_id);
																		$i++;
																		$bl += $k->balance;
																		?>
																		<tr >
																			<td><?php echo $i . '.'; ?></td>
																			<td><?php echo $std->first_name . ' ' . $std->last_name; ?></td>
																			<td class="rttx"><?php echo number_format($k->invoice_amt, 2); ?></td>
																			<td class="rttx"><?php echo number_format($k->paid, 2); ?></td>
																			<td class="rttx"><?php echo number_format($k->balance, 2); ?></td>
																			<td><a  class="btn btn-sm btn-info" href="<?php echo base_url('fee_payment/statement/' . $k->student_id); ?>" ><i class="fa fa-caret-right"></i><i class="fa fa-caret-right"></i>&nbsp; View Full Statement</a></td>
																		</tr>
																		<?php
																}
																if ($i > 1)
																{
																		?>
																		<tr >
																			<td> </td>
																			<td> </td>
																			<td class="rttx"> </td>
																			<td class="rttx">TOTAL:  </td>
																			<td class="rttb"><?php echo number_format($bl, 2); ?></td>
																			<td> </td>
																		</tr>
																<?php } ?>

															</tbody>
														</table>
													</div><!-- End .row -->
											</div><!-- End .row -->
									</div>
											
											
								  <div class="tab-pane text-70" id="receipt-tab-home"  >
										<div class="table-responsive">
					
															<table class="table bordered custom-table table-hover">
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
															$j = count($this->parent->kids);
																$i=0;
																
																$banks = $this->ion_auth->populate('bank_accounts','id','bank_name');
																$fee = $this->ion_auth->populate('fee_extras','id','title');
															
														
																
															foreach($rec as $re){
																
																foreach($re as $p){
																	
																	$st = $this->portal_m->find($p->reg_no);
																	
																	//if($i==8) break;
																
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
																			<a href="<?php echo base_url('fee_payment/receipt/'.$p->receipt_id)?>" class="btn btn-sm btn-info">
																				<span class="fa fa-print"></span> &nbsp; Receipt
																			</a>
																		
																		</div>
																	</td>
																</tr>
															
															<?php } ?>
															<?php } ?>
															</tbody>
														</table>

													</div>
									  
								      </div>
									  
									   <div class="tab-pane text-70" id="waivers-tab-home"  >
									  		<div class="table-responsive">
					
													<table class="table bordered custom-table table-hover">
													<thead>
														<tr>
															<th>Date</th>
															<th>Student</th>
															<th>Amount</th>
															<th>Term</th>
															<th>Year</th>
															<th>Remarks</th>
														</tr>
													</thead>
													<tbody>
													<?php 
													$j = count($this->parent->kids);
														$i=0;
										
													foreach($waivers as $re){
														
														foreach($re as $p){
															
															$st = $this->portal_m->find($p->student);
															
															//if($i==8) break;
														
														?>
														<tr>
															<td><?php echo date('d M Y',$p->date);?></td>
															<td>
																<?php echo $st->first_name.' '.$st->last_name;?>
															</td>
															<td ><span class="pull-right"><?php echo number_format($p->amount,2);?></span></td>
															<td class="text-center"><?php echo $p->term;?></td>
															<td class="text-center"><?php echo $p->year;?></td>
															<td><?php echo $p->remarks;?></td>

														</tr>
													
													<?php } ?>
													<?php } ?>
													</tbody>
												</table>

											</div>
									   
								      </div>
									  
									  
									   <div class="tab-pane text-70" id="pledges-tab-home" >
									   
												<div class="table-responsive">
					
														 <?php
															if (!count($pledges))
															{
																	?>
																	<div class="alert alert-warning alert-dismissable">
																		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
																		<strong>No</strong> Pledges found.
																	</div>
																	<?php
															}
															else
															{
																	?>
																			
																<table class="table bordered custom-table table-hover">
																<thead>
																	 <tr>
																		<td>#</td>
																		<td >Due Date</td>
																		<td>Student</td>
																		<td class="text-center">Amount</td>
																		<td title="">Status</td>
																	</tr>
																</thead>
														<tbody>
																<?php
																$i = 0;
																$bl = 0;
																foreach ($pledges as $k)
																{
																		$std = $this->worker->get_student($k->student);
																		$i++;
																		$bl += $k->amount;
																		?>
																		<tr >
																			<td><?php echo $i . '.'; ?></td>
																			<td class=""><?php echo date('d M Y', $k->pledge_date); ?></td>
																			<td><?php echo $std->first_name . ' ' . $std->last_name; ?></td>
																			<td class="rttx"><?php echo number_format($k->amount, 2); ?></td>
																			<td class="">
																			<?php if($k->status =='pending') echo '<span class="btn btn-sm btn-danger">Pending</span>'; else  if($k->status =='paid') echo '<span class="btn btn-sm btn-success">Paid</span>';?>
																			</td>
																		</tr>
																		<?php
																}
																if ($i > 1)
																{
																		?>
																		<tr>
																			<td> </td>
																			<td> </td>
																			<td class="rttx"> </td>
																			<td class="rttx">TOTAL: </td>
																			<td class="rttb"><?php echo number_format($bl, 2); ?></td>
																			<td></td>
																		</tr>
																<?php } ?>
													   </tbody>
													</table>
										<?php } ?>
														</div>
				
				
								      </div>
									  
									   <div class="tab-pane text-70" id="p-options-tab-home">
									   <div class="table-responsive">
					
														 <?php
																if ($banks_acc)
																{
																		?>
																	  
																	   <table class="table bordered custom-table table-hover">
																			<tr >
																				<th  width="3%">#</th>
																				<th >Bank Name</th>
																				<th >Account Name</th>
																				<th>Branch</th>
																				<th >Account No.</th>
																				<th >Description.</th>
																			</tr>
																			<?php
																			$i = 0;
																			foreach ($banks_acc as $b)
																			{
																					$i++;
																					?>
																					<tr >
																						<td style=""><?php echo $i; ?></td>
																						<td style=""><?php echo $b->bank_name ?></td>
																						<td ><?php echo $b->account_name ?></td>
																						<td ><?php echo $b->branch ?></td>
																						<td ><?php echo $b->account_number ?></td>
																						<td ><?php echo $b->description ?></td>
																					</tr>
																			<?php } ?>
																	<?php } ?>
																	
																</table>
																	
													</div>
								      </div>

							<!--- END TAB ---->
						</div>
					</div>

				</div>
			</div>
		</div>
