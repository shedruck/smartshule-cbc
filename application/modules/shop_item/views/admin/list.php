<?php
// print_r($this->admission_m->get_stds());die();
?>
<div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h2>  Shop Item  </h2>
             <div class="right">  
				 <a href="<?php echo base_url()?>admin/shop_item/requested_items" class="btn btn-success"><i class="glyphicon glyphicon-shopping-cart"></i>Shopped Items</a>
             <?php echo anchor( 'admin/shop_item/create/'.$page, '<i class="glyphicon glyphicon-plus"></i> '.lang('web_add_t', array(':name' => 'Shop Item')), 'class="btn btn-primary"');?>
			 
			 <?php echo anchor( 'admin/shop_item' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Shop Item')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
              
                 <?php if ($shop_item): ?>
                 <div class="block-fluid">
				<table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
	 <thead>
                <th>#</th><th>Name</th><th>Size From</th><th>Size To</th><th>Bp</th><th>Sp</th><th>Quantity</th><th>Description</th>	<th ><?php echo lang('web_options');?></th>
		</thead>
		<tbody>
		<?php 
                             $i = 0;
                                if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                                {
                                    $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                                }
                
            foreach ($shop_item as $p ): 
                 $i++;
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>					<td><?php echo $p->name;?></td>
					<td><?php echo $p->size_from;?></td>
					<td><?php echo $p->size_to;?></td>
					<td><?php echo $p->bp;?></td>
					<td><?php echo $p->sp;?></td>
					<td><?php echo $p->quantity;?></td>
					<td><?php echo $p->description;?></td>

			 <td width='30'>
						 <div class='btn-group'>
							<button class='btn dropdown-toggle' data-toggle='dropdown'>Action <i class='glyphicon glyphicon-caret-down'></i></button>
							<ul class='dropdown-menu pull-right'>
								 <li><a href='<?php echo site_url('admin/shop_item/edit/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-eye-open'></i> View</a></li>
								<li><a  href='<?php echo site_url('admin/shop_item/edit/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-edit'></i> Edit</a></li>
							  
								<li><a  onClick="return confirm('<?php echo lang('web_confirm_delete')?>')" href='<?php echo site_url('admin/shop_item/delete/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-trash'></i> Trash</a></li>
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