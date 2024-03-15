<div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h2>  Book Fund  </h2>
             <div class="right">  
             <?php echo anchor( 'admin/book_fund/create/'.$page, '<i class="glyphicon glyphicon-plus"></i> '.lang('web_add_t', array(':name' => 'Book Fund')), 'class="btn btn-primary"');?>
			 
			 <?php echo anchor( 'admin/book_fund' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Book Fund')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
              
                 <?php if ($book_fund): ?>
                 <div class="block-fluid">
				<table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
	 <thead>
                <th>#</th>
				<th>Title</th>
				<th>Pages</th>
				<th>Category</th>
				<th>Author</th>
				
				<th>Quantity</th>
				
				<th>Given Out</th>
				<th>Remaining<br> Books</th>
				
				<th ><?php echo lang('web_options');?></th>
		</thead>
		<tbody>
		<?php 
                             $i = 0;
                                if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                                {
                                    $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                                }
                
            foreach ($book_fund as $p ): 
                 $i++;
				  $q_totals=$this->book_fund_m->total_quantity($p->id);
				 
				 $brwd=$this->book_fund_m->borrowed($p->id);
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>					
				<td><?php echo $p->title;?></td>
					<td><?php echo $p->pages;?></td>
					<td><?php echo $category[$p->category];?></td>
					<td><?php echo $p->author;?></td>
					
					<td><?php 
					if(!empty($q_totals->t_quantity))echo $q_totals->t_quantity; else echo '0';
					?></td>
				
					<td style="color:red"><?php 
					if($brwd==0){echo 'None';}
					elseif($brwd==1){echo $brwd.' Book';}
					elseif($brwd>1){echo $brwd.' Books';}
					else{ //Nothing
					}
					?></td>
					<td><?php  
					$t=$q_totals->t_quantity-$brwd;
					if(!empty($q_totals->t_quantity)){
							if($t==0){echo 'None';}
					elseif($t==1){echo $t.' Book';}
					elseif($t>1){echo $t.' Books';}
					else{ //Nothing
					}
					 }
					 ?></td>
					

			 <td width='20%'>
						 <div class='btn-group'>
							<button class='btn dropdown-toggle' data-toggle='dropdown'>Action <i class='glyphicon glyphicon-caret-down'></i></button>
							<a class='btn btn-primary' href='<?php echo site_url('admin/book_fund_stock/create/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-edit'></i> Add Stock</a>
							<ul class='dropdown-menu pull-right'>
								 <li><a href='<?php echo site_url('admin/book_fund/view/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-eye-open'></i> View Details</a></li>
								<li><a  href='<?php echo site_url('admin/book_fund/edit/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-edit'></i> Edit Details</a></li>
							  
								<li><a  onClick="return confirm('<?php echo lang('web_confirm_delete')?>')" href='<?php echo site_url('admin/book_fund/delete/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-trash'></i> Trash</a></li>
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