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
				<th> Quantity</th>
				<th>Unit Price</th>				
				<th>Total Cost</th>
				<th>Description</th>
				<th>Voided On</th>
				<th>Voided By</th>
				
		</thead>
		<tbody>
		<?php 
                             $i = 0;
                                if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                                {
                                    $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                                }
                
            foreach ($record_sales as $p ): 
			$u = $this->ion_auth->get_user($p->modified_by);
                 $i++;
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>					
				<td><?php echo date('d M Y',$p->sales_date);?></td>
				<td><?php 
				
				echo $items[$p->item_id];
				
				?></td>
					<td><?php echo  $p->quantity;?></td>
					<td><?php echo  $p->unit_price;?></td>
					
					<td><?php echo number_format($p->total,2);?></td>
					<td><?php echo $p->description;?></td>
					<td><?php echo date('d M Y',$p->modified_on);?></td>
					<td><?php echo $u->first_name.' '.$u->last_name;?></td>

				</tr>
 			<?php endforeach ?>
		</tbody>

	</table>

	
</div>

<?php else: ?>
 	<p class='text'><?php echo lang('web_no_elements');?></p>
 <?php endif ?>