<div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h2>  Grants  </h2>
             <div class="right">  
             <?php echo anchor( 'admin/grants/create/'.$page, '<i class="glyphicon glyphicon-plus"></i> '.lang('web_add_t', array(':name' => 'Grants')), 'class="btn btn-primary"');?>
			 
			 <?php echo anchor( 'admin/grants' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Grants')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
              
                 <?php if ($grants): ?>
                 <div class="block-fluid">
				<table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
	 <thead>
                <th>#</th>
				
				<th>Grant Type</th>
				<th>Date</th>
				<th>Amount</th>
				<th>Purpose</th>
				<th>School Rep.</th>
				<th>File</th>
				<th>Contact Person</th>
				<th ><?php echo lang('web_options');?></th>
		</thead>
		<tbody>
		<?php 
                             $i = 0;
                                if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                                {
                                    $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                                }
                
            foreach ($grants as $p ): 
                 $i++;
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>					
				<td><?php echo $p->grant_type;?></td>
				<td><?php echo date('d M Y',$p->date);?></td>
				<td>
				    <?php echo number_format($p->amount);?><br>
				    <?php echo $p->payment_method;?><br>
				    <?php echo $bank[$p->bank];?>
				</td>
					<td><?php echo $p->purpose;?></td>
					<td><?php echo $p->school_representative;?></td>
					<td> <?php if($p->file){?><a href='<?php echo base_url()?>uploads/files/<?php echo $p->file?>' />Download file (file)</a><?php } else{?><i>No File Attached</i><?php } ?></td>
					<td><?php echo $p->contact_person;?><br><?php echo $p->contact_details;?></td>

			 <td width='30'>
						 <div class='btn-group'>
							<button class='btn dropdown-toggle' data-toggle='dropdown'>Action <i class='glyphicon glyphicon-caret-down'></i></button>
							<ul class='dropdown-menu pull-right'>
								
								<li><a  href='<?php echo site_url('admin/grants/edit/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-edit'></i> Edit</a></li>
							  
								<li><a  onClick="return confirm('<?php echo lang('web_confirm_delete')?>')" href='<?php echo site_url('admin/grants/delete/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-trash'></i> Trash</a></li>
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