<div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h2>  Sales Items  </h2>
             <div class="right">  
             <?php echo anchor( 'admin/sales_items/create/'.$page, '<i class="glyphicon glyphicon-plus"></i> '.lang('web_add_t', array(':name' => 'Sales Items')), 'class="btn btn-primary"');?>
			 
			 <?php echo anchor( 'admin/sales_items' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Sales Items')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
              
                 <?php if ($sales_items): ?>
                 <div class="block-fluid">
				<table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
	 <thead>
                <th>#</th>
				<th>Item Name</th>
				<th>Category</th>
				<th>Quantity</th>
				<th>Total Sold</th>
				<th>Remaining <br> Stock</th>
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
                
            foreach ($sales_items as $p ): 
                 $i++;
				 $t_quantity = (object)$p->t_quantity;
				 $t_sold = (object)$p->t_sold;
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>					
				<td><?php echo $p->item_name;?></td>
				<td><?php echo $cats[$p->category];?></td>
				<td><?php if ($t_quantity->total ==0)echo 0; else echo $t_quantity->total;?></td>
				<td><?php if ($t_sold->total ==0)echo 0; else echo $t_sold->total; ?></td>
				<td><?php $rem =($t_quantity->total - $t_sold->total); echo $rem;?></td>
				<td><?php echo $p->description;?></td>

			 <td width='20%'>
						 <div class='btn-group'>
						 <a class='btn btn-primary' href='<?php echo site_url('admin/sales_items/edit/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-edit'></i> Edit</a>
						 <a class='btn btn-success' href='<?php echo site_url('admin/sales_items_stock/create/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-plus'></i> Add Stock</a>
							
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