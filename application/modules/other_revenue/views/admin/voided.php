<div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h2>  Other Revenue  </h2>
             <div class="right">  
             <?php echo anchor( 'admin/other_revenue/create/'.$page, '<i class="glyphicon glyphicon-plus"></i> '.lang('web_add_t', array(':name' => 'Other Revenue')), 'class="btn btn-primary"');?>
             
             <?php echo anchor( 'admin/other_revenue' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Other Revenue')), 'class="btn btn-primary"');?>
                 
                 <?php echo anchor( 'admin/other_revenue/voided/'.$page, '<i class="glyphicon glyphicon-list"></i> '.lang('web_list_all', array(':name' => 'Voided')), 'class="btn btn-warning"');?>
             
                </div>
                </div>
         	                    
              
                 <?php if ($other_revenue): ?>
                 <div class="block-fluid">
				<table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
	 <thead>
                <th>#</th>
                <th width="10%">Date</th>
                <th width="10%">Item</th>
                <th width="10%">Category</th>
                <th width="10%">Amount</th>
                <th width="10%">Bank</th>
                <th width="12%">Transaction Code</th>
                <th width="27%">Description</th>
                <th width="10%">Created By</th>

             <!--    <th ><?php echo lang('web_options');?></th> -->
		</thead>
		<tbody>
		<?php 
                             $i = 0;
                                if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                                {
                                    $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                                }
                
            foreach ($other_revenue as $p ): 
                 $i++;
                  $banks =  $this->fee_payment_m->list_banks();
                  $categories =  $this->other_revenue_m->list_categories();
                     $user = $this->ion_auth->get_user($p->created_by);

                    
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>	
                <td><?php echo date('d M Y', $p->payment_date) ;?></td>
                <td><?php echo $p->item; ?></td>
                <td><?php echo isset($categories[$p->category]) ? $categories[$p->category] : '' ;  ?></td>
                <td><?php echo $p->amount; ?></td>
                <td><?php echo isset($banks[$p->bank_id]) ? $banks[$p->bank_id] : '' ; ?></td>
                <td><?php echo $p->transaction_code; ?></td>
                <td><?php echo $p->description; ?></td>
                <td><?php echo $user->username; ?></td>



			 <!-- <td width='30'>
						 <div class='btn-group'>
							<button class='btn dropdown-toggle' data-toggle='dropdown'>Action <i class='glyphicon glyphicon-caret-down'></i></button>
							<ul class='dropdown-menu pull-right'>
								 <li><a href='<?php echo site_url('admin/other_revenue/edit/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-eye-open'></i> View</a></li>
								<li><a  href='<?php echo site_url('admin/other_revenue/edit/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-edit'></i> Edit</a></li>
							  
								<li><a  onClick="return confirm('<?php echo lang('web_confirm_delete')?>')" href='<?php echo site_url('admin/other_revenue/delete/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-trash'></i> Trash</a></li>
							</ul>
						</div>
					</td> -->
				</tr>
 			<?php endforeach ?>
		</tbody>

	</table>

	
</div>

<?php else: ?>
 	<p class='text'><?php echo lang('web_no_elements');?></p>
 <?php endif ?>