<div class="col-md-12">
                <div class="head">
                    <div class="icon"><span class="icosg-target1"></span></div>
                    <h2>Purchase Order</h2> 
                     <div class="right">                            
                       
             <?php echo anchor( 'admin/purchase_order/create/'.$page, '<i class="glyphicon glyphicon-plus"></i> New Order', 'class="btn btn-primary"');?>
			    <?php echo anchor( 'admin/purchase_order/' , '<i class="glyphicon glyphicon-list">
                </i> List All', 'class="btn btn-primary"');?>
				<?php echo anchor( 'admin/purchase_order/voided' , '<i class="glyphicon glyphicon-list">
                </i> Voided Purchase Orders', 'class="btn btn-warning"');?>
			
             
             
                     </div>    					
                </div>
				 <div class="toolbar-fluid">
                            <div class="information">
							<div class="item">
                                    <div class="rates">
                                        <div class="title"> <?php echo $this->currency.' '.number_format($months_lpo->total,2);?> </div>
                                        <div class="description">This month's orders 
										<span style="" class="caption blue">[ <?php echo $count_months_lpo;?> ]</span></div>
                                    </div>
                                </div>		
								 <div class="item">
                                    <div class="rates">
                                        <div class="title"><?php echo $this->currency.' '.number_format($total_unpaid->total+$total_balance->total,2);?> </div>
                                        <div class="description">Awaiting Payment [ <?php echo $count_unpaid;?> ]</div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="rates">
                                        <div class="title"><?php echo $this->currency.' '.number_format($total_overdue->total,2);?> </div>
                                        <div class="description">Overdue orders [ <?php echo $count_overdue;?> ]</div>
                                    </div>
                                </div>
                               
                               
                                <div class="item">
                                    <div class="rates">
                                        <div class="title"><?php echo $this->currency.' '.number_format($total_paid->total,2);?> </div>
                                        <div class="description">Total Paid Purchase order [ <?php echo $count_paid;?> ]</div>
                                    </div>
                                </div> 
                                						
                            </div>
                        </div>
				
       
              
                 <?php if ($purchase_order): ?>
               
   <div class="block-fluid">
    <table class="fpTable" cellpadding="0" cellspacing="0" width="100%">


	 <thead>
                <th>#</th>
				<th>Order Date</th>
				<th>Supplier</th>
				<th>Vat</th>
				<th>Total Due</th>
				<th>By</th>
				<th ><?php echo lang('web_options');?></th>
		</thead>
		<tbody>
		<?php 
                             $i = 0;
                                if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                                {
                                    $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                                }
                
            foreach ($purchase_order as $p ): 
				$u=$this->ion_auth->get_user($p->created_by);
                 $i++;
				 $payment =(object)$p->payment; 
				 $amount_paid =(object)$p->amount_paid; 
				
                     ?>
	 <tr>
                    <td><?php echo $i . '.'; ?></td>
					<td><?php echo date('d/m/Y',$p->purchase_date);?></td>
					<td><?php echo $address_book[$p->supplier];?></td>
					<td><?php if($p->vat==1) echo $tax->amount; else echo 0;?> %</td>
					<td>
					 <?php
                            $vat = $tax->amount;
                            if ($p->vat == 1)
                            {
                                $t = ($p->total * $vat) / 100; //echo $vat;
								 echo $this->currency.' '.number_format($t + $p->total, 2);
                            }
                            else{ echo $this->currency.' '.number_format($p->total, 2);}
							
							if($p->balance>0) echo '<br><b>Balance due</b> '.number_format($p->balance,2);
                            ?>
					
					<?php //echo number_format($p->total,2);?></td>
					<td><?php echo $u->first_name.' '.$u->last_name;?></td>
               <td width="20%">
			    <?php if($p->status==3):?>
			    
			   <a class="btn btn-primary" href="<?php echo site_url('admin/purchase_order/order/'.$p->id.'/'.$page);?>"><i class="glyphicon glyphicon-eye-open"></i> View</a>
			  <?php if($p->balance>0):?>
							 <a class="btn btn-success" href="<?php echo site_url('admin/purchase_order/make_pay/'.$p->id.'/'.$page);?>"><i class="glyphicon glyphicon-edit"></i> Pay </a>
							<?php endif;?>
					 <div class="btn-group">
							<button class="btn btn-inverse dropdown-toggle" data-toggle="dropdown">Payment Details <i class="glyphicon glyphicon-caret-down"></i></button>
							<ul class="dropdown-menu pull-right">
								<li><a href="#"><i class="glyphicon glyphicon-chevron-right"></i> <b>Date :</b> <?php echo date('d M Y',$payment->pay_date);?></a></li>
								<li><a href="#"><i class="glyphicon glyphicon-chevron-right"></i>  <b>Amount:</b>  <?php echo number_format($amount_paid->total,2);?></a></li>
								
								<li><a href="#"><i class="glyphicon glyphicon-chevron-right"></i>  <b>Type:</b>  <?php echo $payment->pay_type?></a></li>
								<li><a href='#'><i class="glyphicon glyphicon-chevron-right"></i>  <b>By:</b> <?php 
								 $us=$this->ion_auth->get_user($payment->created_by);
								echo $us->first_name.' '.$us->last_name;?></a></li>
							</ul>
							
					</div>
				  
			   <?php else:?>
			   <div class='btn-group'>
					   <a class="btn btn-primary" href="<?php echo site_url('admin/purchase_order/order/'.$p->id.'/'.$page);?>"><i class="glyphicon glyphicon-eye-open"></i> View</a>
					  
					   <a class="btn btn-success" href="<?php echo site_url('admin/purchase_order/make_pay/'.$p->id.'/'.$page);?>"><i class="glyphicon glyphicon-edit"></i> Make Payment</a>
						<a class="btn btn-danger" onClick="return confirm('<?php echo "Are you sure you want to void the purchase"?>')" href='<?php echo site_url('admin/purchase_order/void/'.$p->id.'/'.$page);?>'><i class="glyphicon glyphicon-trash"></i> Void</a>
					   <?php endif;?>
			  
				</div>
					
					
						</td></tr>
 			<?php endforeach ?>
		</tbody>

	</table>

	<?php echo $links; ?>
  </div>
            </div>
   

<?php else: ?>
 	<p class='text'><?php echo lang('web_no_elements');?></p>
 <?php endif ?>