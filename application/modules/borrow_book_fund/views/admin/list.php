<div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h2>  Give out  Book Fund  </h2>
             <div class="right">  
             <?php echo anchor( 'admin/borrow_book_fund/create/'.$page, '<i class="glyphicon glyphicon-plus"></i> Give out  Book Fund', 'class="btn btn-primary"');?>
			 
			 <?php echo anchor( 'admin/borrow_book_fund' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Borrowed Books')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
              
                 <?php if ($borrow_book_fund): ?>
                 <div class="block-fluid">
				<table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
	 <thead>
                <th>#</th>
				<th>Student</th>
				<th>Book</th>
				<th>Borrowed Date</th>
				<th>Status</th>
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
                
            foreach ($borrow_book_fund as $p ): 
                 $i++;
				  $st = $this->ion_auth->list_student($p->student);
				       $class = $this->ion_auth->list_classes();
                      $stream = $this->ion_auth->get_stream();
        
            $ccc = isset($class[$st->class])? $class[$st->class] : ' - ';
			
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>					
				<td><?php echo $st->first_name.' '.$st->last_name.'<br><span style="color:blue"> '.$classes_groups[$classes[$st->class]].' '.$stream_name[$class_str[$st->class]].'</span>';?></td>
					<td><?php echo $books[$p->book];?></td>
					<td><?php echo date('d/m/Y',$p->borrow_date);?></td>
					<td>
					<?php 
					
					if($p->status==2){
					
					 echo '<span style="color:green">Book Returned</span>';
					}
					elseif($p->status==1){
						 echo '<span style="color:red">Not Returned</span>';
					}
					
						elseif($dat<$now){
					//compute overdue days
					 $f_diff=abs($now-$dtm);
					 $days=floor($f_diff/(60*60*24));
					 //multiply overdue days by fine per day
					 $penalty=($days*$fine->fine);
					 echo '<span style="color:red">Book Overdue </span><br>Fine: KES.'.number_format($penalty,2);
					}
					else{//nothing
					}
					?> </td>
					<td><?php echo $p->remarks;?></td>

			 <td width='20%'>
						 <div class='btn-group'>
							<button class='btn dropdown-toggle' data-toggle='dropdown'>Action <i class='glyphicon glyphicon-caret-down'></i></button>
							<ul class='dropdown-menu pull-right'>
								 <li><a  href='<?php echo site_url('admin/borrow_book_fund/edit/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-edit'></i> Edit</a></li>
							  
								<li><a  onClick="return confirm('<?php echo lang('web_confirm_delete')?>')" href='<?php echo site_url('admin/borrow_book_fund/delete/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-trash'></i> Trash</a></li>
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