<div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h2>  Sales Items Stock  </h2>
             <div class="right">  
             <?php echo anchor( 'admin/sales_items_stock/create/'.$page, '<i class="glyphicon glyphicon-plus"></i> '.lang('web_add_t', array(':name' => 'Sales Items Stock')), 'class="btn btn-primary"');?>
			 
			 <?php echo anchor( 'admin/sales_items_stock' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Sales Items Stock')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
              
                 <?php if ($sales_items_stock): ?>
                 <div class="block-fluid">
				<table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
	 <thead>
                <th>#</th>
				<th>Date</th>
				<th>Item</th>
				<th>Quantity</th>
				<th>Unit Price</th>
				<th>Total</th>
				<th>Receipt</th>
				<th>Person<br>Responsible</th>
				<th>Description</th>
				<th ><?php echo lang('web_options');?></th>
		</thead>
		<tbody>
		<?php 
                             $i = 0;
                                if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                                {
                                    $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                                }
                
            foreach ($sales_items_stock as $p ): 
			$u = $this->ion_auth->get_user($p->person_responsible);
                 $i++;
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>					
				<td><?php echo date('d M Y',$p->purchase_date);?></td>
				<td><?php echo $item[$p->item_id];?></td>
				<td><?php echo $p->quantity;?></td>
				
					<td><?php echo number_format($p->unit_price,2);?></td>
					<td><?php echo number_format($p->total,2);?></td>
					<td>
					<?php if(!empty($p->receipt)){?>
					<a href="<?php echo base_url('uploads/files/'.$p->receipt);?>"> Download</a>
					<?php } else{ echo '<i>No attachment</i>'; } ?>
					</td>
					<td><?php echo $u->first_name.' '.$u->last_name;?></td>
					<td><?php echo $p->description;?></td>

			 <td width='20%'>
						 <div class='btn-group'>
							<button class='btn dropdown-toggle' data-toggle='dropdown'>Action <i class='glyphicon glyphicon-caret-down'></i></button>
							<ul class='dropdown-menu pull-right'>
								
								<li><a  href='<?php echo site_url('admin/sales_items_stock/edit/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-edit'></i> Edit Details</a></li>
							  
								<li><a  onClick="return confirm('<?php echo lang('web_confirm_delete')?>')" href='<?php echo site_url('admin/sales_items_stock/delete/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-trash'></i> Trash</a></li>
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