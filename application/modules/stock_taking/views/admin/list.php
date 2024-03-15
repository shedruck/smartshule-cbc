<div class="head">
                    <div class="icon"><span class="icosg-target1"></span></div>
                    <h2> Stock Taking </h2> 
                     <div class="right">                            
						 <?php echo anchor( 'admin/stock_taking/create/' , '<i class="glyphicon glyphicon-plus">
                </i> Take Stock ', 'class="btn btn-primary"');?> 
			
             <?php echo anchor( 'admin/stock_taking/' , '<i class="glyphicon glyphicon-list">
                </i> List All', 'class="btn btn-primary"');?> 
			  <div class="btn-group">
					<button class="btn dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-cog"></i> Options</button>
					
					<ul class="dropdown-menu pull-right">
					  <li><a class=""  href="<?php echo base_url('admin/items'); ?>"><i class="glyphicon glyphicon-list-alt"></i> Manage Items</a></li>
					   <li class="divider"></li>
					  <li><a href="<?php echo base_url('admin/items_category'); ?>"><i class="glyphicon glyphicon-fullscreen"></i> Manage Items Category</a></li>
					  <li class="divider"></li>
					  <li><a href="<?php echo base_url('admin/add_stock/create'); ?>"><i class="glyphicon glyphicon-plus"></i> Add Stock</a></li>
					    <li class="divider"></li>
					  <li><a href="<?php echo base_url('admin/stock_taking'); ?>"><i class="glyphicon glyphicon-edit"></i> Stock Taking</a></li>
					   <li class="divider"></li>
					  <li><a href="<?php echo base_url('admin/inventory'); ?>"><i class="glyphicon glyphicon-folder-open"></i> Inventory Listing</a></li>
					</ul>
				</div>
			
                     </div>    					
                </div>
				
				
				
				
         	        <?php if ($stock_taking): ?>              
               <div class="block-fluid">
				<table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
<thead>
		    <th>No.</th>
		    <th>Stock Date</th>
		    <th>Product Name</th>
		    <th>Closing Stock</th>
		    <th>Taken On</th>
		    <th>Taken by</th>
			
			<th>Options</th>
		</thead>
		<tbody>
		<?php $i=1;foreach ($stock_taking as $stock_taking_m):  $user=$this->ion_auth->get_user($stock_taking_m->created_by); ?>
		<tr class="gradeX">	
                    <td><?php echo $i;?></td>
					<td><?php echo date('d M Y',$stock_taking_m->stock_date);?></td>
                    <td><?php echo $product[$stock_taking_m->product_id];?></td>					
		         <td><?php echo $stock_taking_m->closing_stock;?> Units</td>
					
				 <td><?php echo date('d M, Y',$stock_taking_m->created_on);?></td>
					 <td ><?php echo $user->first_name.' '.$user->last_name; ?></td>
					<td width="20%">
						 <div class="btn-group">
							<a class='btn btn-primary'  href="<?php echo site_url('admin/stock_taking/edit/'.$stock_taking_m->id.'/'.$page);?>"><i class="glyphicon glyphicon-edit"></i> Edit</a>
							  
						    <a class='btn btn-danger' onClick="return confirm('<?php echo lang('web_confirm_delete')?>')" href='<?php echo site_url('admin/stock_taking/delete/'.$stock_taking_m->id.'/'.$page);?>'><i class="glyphicon glyphicon-trash"></i> Trash</a>
						</div>
					</td>
				</tr>
 			<?php $i++; endforeach ?>
		</tbody>

	</table>
       

	
  </div>     

<?php else: ?>
 	<p class='text'><?php echo lang('web_no_elements');?></p>
 <?php endif ?> 
 
        
  