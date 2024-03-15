<div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h2>  Return Book  </h2>
             <div class="right">  
             <?php echo anchor( 'admin/return_book/create/'.$page, '<i class="glyphicon glyphicon-plus"></i> Return Book', 'class="btn btn-primary"');?>
			 
			 <?php echo anchor( 'admin/return_book' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Returned Books')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
              
                 <?php if ($return_book): ?>
                 <div class="block-fluid">
				<table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
	 <thead>
                <th>#</th>
				<th>Student</th>
				<th>Pending Books</th>
				<th>Last Borrow Date</th>
				<th>Remarks</th>
				<th ><?php echo lang('web_options');?></th>
		</thead>
		<tbody>
		<?php 
                             $i = 0;
                                if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                                {
                                    $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                                }
                
            foreach ($return_book as $p ): 
                 $i++;
				  $st = $this->ion_auth->list_student($p->student);
				       $class = $this->ion_auth->list_classes();
                   
					  $t_borrowed=$this->return_book_m->count_borrowed_per_student($p->student);
        
            $ccc = isset($class[$st->class])? $class[$st->class] : ' - ';
		
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>					
				<td><?php echo $st->first_name.' '.$st->last_name.'<br><span style="color:blue"> '.$ccc.'</span>';?></td>
					<td><?php 
					if($t_borrowed==1){ echo $t_borrowed.' Book';}
					else{ echo $t_borrowed.' Books';}?>
					</td>
					<td><?php echo date('d/m/Y',$p->borrow_date);?></td>
					<td><?php echo $p->remarks;?></td>

			 <td width='130'>
	<a class='btn btn-primary' href='<?php echo site_url('admin/return_book/create/'.$p->student.'/'.$page);?>'><i class='glyphicon glyphicon-edit'></i> Return Book</a>
						 
					</td>
				</tr>
 			<?php endforeach ?>
		</tbody>

	</table>

	
</div>

<?php else: ?>
 	<p class='text'><?php echo lang('web_no_elements');?></p>
 <?php endif ?>