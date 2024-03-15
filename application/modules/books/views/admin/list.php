<div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h2>  Books  </h2>
             <div class="right">  
             <?php echo anchor( 'admin/books/create/'.$page, '<i class="glyphicon glyphicon-plus"></i> '.lang('web_add_t', array(':name' => 'Books')), 'class="btn btn-primary"');?>
			 
			 <?php echo anchor( 'admin/books' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Books')), 'class="btn btn-primary"');?> 
			<a class="btn  btn-warning" href="<?php echo base_url()?>admin/book_list">Manage Book Lists</a>
             
                </div>
                </div>
         	                    
              
                 <?php if ($books): ?>
                 <div class="block-fluid">
				<table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
	 <thead>
                <th>#</th>
				<th>Title</th>
				<th>Author</th>
				<th>Category</th>
				<th>Edition</th>
				<th>Quantity</th>
				
				<th>Borrowed</th>
				<th>Remaining <br> Books</th>
				<th ><?php echo lang('web_options');?></th>
		</thead>
		<tbody>
		<?php 
                             $i = 0;
                                if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                                {
                                    $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                                }
                
            foreach ($books as $p ): 
                 $i++;
				 $q_totals=$this->books_m->total_quantity($p->id);
				
				 $brwd=$this->books_m->borrowed($p->id);
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>					
				<td><a href='<?php echo site_url('admin/books/edit/'.$p->id.'/'.$page);?>'><?php echo $p->title;?></a></td>
					<td><?php echo $p->author;?></td>
					
					<td><?php echo $category[$p->category];?></td>
					<td><?php echo $p->edition;?></td>
					<td><?php 
					if(!empty($q_totals->t_quantity))echo $q_totals->t_quantity; else echo '0';
					?></td>
					
					<td><?php 
					if($brwd==0){echo 'None';}
					elseif($brwd==1){echo $brwd.' Book';}
					elseif($brwd>1){echo $brwd.' Books';}
					else{ //Nothing
					}
					?></td>
					</td>
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
					
					
			 <td width='240'>
						 <div class='btn-group'>
							<button class='btn dropdown-toggle' data-toggle='dropdown'>Action <i class='glyphicon glyphicon-caret-down'></i></button>
							<ul class='dropdown-menu pull-right'>
								 <li><a href='<?php echo site_url('admin/books/view/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-eye-open'></i> View Details</a></li>
								<li><a  href='<?php echo site_url('admin/books/edit/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-edit'></i> Edit Details</a></li>
							  
								<li><a  onClick="return confirm('<?php echo lang('web_confirm_delete')?>')" href='<?php echo site_url('admin/books/delete/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-trash'></i> Trash</a></li>
							</ul>
						</div>
						<a class='btn btn-primary' href='<?php echo site_url('admin/books_stock/create/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-edit'></i> Add Stock</a>
					</td>
				</tr>
 			<?php endforeach ?>
		</tbody>

	</table>

	
</div>

<?php else: ?>
 	<p class='text'><?php echo lang('web_no_elements');?></p>
 <?php endif ?>