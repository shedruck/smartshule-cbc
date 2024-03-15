<div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h2>  Payment History For 
			<?php $data=$this->ion_auth->students_full_details(); echo '<span style="color:#54A1E6">'.$data[$post->reg_no].'</span>';?> 
			</h2>
             <div class="right">  
             <?php echo anchor( 'admin/fee_payment/create/', '<i class="glyphicon glyphicon-plus"></i> '.lang('web_add_t', array(':name' => 'Fee Payment')), 'class="btn btn-primary"');?> 
			 <?php echo anchor( 'admin/fee_payment/data_edit/'.$post->reg_no, '<i class="glyphicon glyphicon-eye-open"></i> View Payment History', 'class="btn btn-primary"');?>
			 
			 <?php echo anchor( 'admin/fee_payment' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Fee Payment')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>        
              
                 <div class="block-fluid">
                      <table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="3%">#</th>
                                    <th width="">Payment Date</th>
                                    <th width="">Description</th>
                                    <th width="">Payment Method</th>
                                    <th width="">Transaction No.</th>
                                    <th width="">Bank.</th>
                                    <th width="">Amount</th>
                                    <th width="">Actions</th>
                                   
                                </tr>
                            </thead>
                            <tbody>
							<?php 
                             $i = 0;
					foreach ($p as $p ): 
								$amt=$this->fee_payment_m->total_paid($p->reg_no);
								$user=$this->ion_auth->get_user($p->created_by);
								
									 $i++;
									?>
                                <tr>
                                    <td><?php echo $i;?></td>
                                    <td><?php echo date('d/m/Y',$p->payment_date);?></td>
									<td><?php echo $p->description;?></td>
									<td><?php echo $p->payment_method;?></td>
									<td><?php echo $p->transaction_no;?></td>
									<td><?php 
									if(!empty($p->bank_id)){
									echo $banks[$p->bank_id];}?></td>
									<td><?php echo number_format($p->amount,2);?></td>
									 <td width='20%'>
						 <div class='btn-group'>
							<button class='btn dropdown-toggle' data-toggle='dropdown'>Action <i class='glyphicon glyphicon-caret-down'></i></button>
							<ul class='dropdown-menu pull-right'>
								
								<li><a  href='<?php echo site_url('admin/fee_payment/edit/'.$p->id);?>'><i class='glyphicon glyphicon-edit'></i> Edit Payments</a></li>
								<li><a  onClick="return confirm('<?php echo 'Are you sure you want to void this?';?>')" href='<?php echo site_url('admin/fee_payment/void/'.$p->id);?>'><i class='glyphicon glyphicon-trash'></i> Void Payment</a></li>
							</ul>
						</div>
					</td>
                                </tr>
                               	<?php endforeach ?>
                                                                        
                            </tbody>
                        </table>
                     
                        
                    </div>
                    
             
    		