<div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h2>  Record Sales  </h2>
             <div class="right">  
             <?php echo anchor( 'admin/record_sales/create/'.$page, '<i class="glyphicon glyphicon-plus"></i> Record Sales', 'class="btn btn-primary"');?>
			 
			 <?php echo anchor( 'admin/record_sales' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Record Sales')), 'class="btn btn-primary"');?> 
             <?php echo anchor( 'admin/record_sales/voided' , '<i class="glyphicon glyphicon-list">
                </i> All Voided Sales', 'class="btn btn-warning"');?> 
                </div>
                </div>
         	                    
              
                 <?php if ($record_sales): ?>
                 <div class="block-fluid">
				<table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
	 <thead>
                <th>#</th>
				<th>Date</th>
				<th>Item </th>
				<th>Total Quantity</th>
				
				<th>Total Cost</th>
				<th>Method</th>
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
                
            foreach ($record_sales as $p ): 
			 $t_qnty = (object)$p->t_qnty;
			 $t_totals = (object)$p->t_totals;
			 $all_items = (object)$p->all_items;
                 $i++;
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>					
				<td><?php echo date('d M Y',$p->sales_date);?></td>
				<td><?php 
				foreach( $all_items as $item){
				echo '<i class="glyphicon glyphicon-ok"></i> '.$items[$item->item_id].'<br>';
				}
				?></td>
					<td><?php echo  $t_qnty->t_quantity;?></td>
					
					<td><?php echo number_format($t_totals->t_totals,2);?></td>
					<td><?php echo $p->payment_method;?></td>
					<td><?php echo $p->description;?></td>

			 <td width='20%'>
						 <div class='btn-group'>
							<a class="btn btn-success" href='<?php echo base_url('admin/record_sales/receipt/'.$p->receipt_id);?>'><i class='glyphicon glyphicon-eye-open'></i> Receipt</a>
							
							<a class="btn btn-primary" href='<?php echo base_url('admin/record_sales/manipulate/'.$p->receipt_id);?>'><i class='glyphicon glyphicon-edit'></i> Manipulate</a>
							  
						
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