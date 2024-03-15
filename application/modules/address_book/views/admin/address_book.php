
                <div class="head">
                    <div class="icon"><span class="icosg-target1"></span></div>
                    <h2><?php echo $title; ?></h2> 
                     <div class="right">                            
                       
             <?php echo anchor( 'admin/address_book/create/', '<i class="glyphicon glyphicon-plus"></i>'.lang('web_add_t', array(':name' => 'New Contact')), 'class="btn btn-primary"');?>
			    <?php echo anchor( 'admin/address_book/' , '<i class="glyphicon glyphicon-list">
                </i> List All Contacts', 'class="btn btn-primary"');?>
			   
                     </div>    					
                </div>


 <?php if ($address_book): ?>
  <div class="block-fluid">
    <table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
	
	 <thead>
                <th>#</th>
				<th>Title</th>
				<th>Company</th>
				<th>Website</th>
				<th>Address</th>
				<th>Email</th>
				<th>Phone</th>
				<th>Landline</th>
				<th>City</th>
			
				<th ><?php echo lang('web_options');?></th>
		</thead>
		<tbody>
		<?php 
                             $i = 0;
                                if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                                {
                                    $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                                }
                
            foreach ($address_book as $p ): 
                 $i++;
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>					<td><?php echo $p->title;?></td>
					<td><?php echo $p->company_name;?></td>
					<td><?php echo $p->website;?></td>
					<td><?php echo $p->address;?></td>
					<td><?php echo $p->email;?></td>
					<td><?php echo $p->phone;?></td>
					<td><?php echo $p->landline;?></td>
					<td><?php echo $p->city;?></td>
					<td>
						 <div class="btn-group">
							<button class="btn dropdown-toggle" data-toggle="dropdown">Action <i class="glyphicon glyphicon-caret-down"></i></button>
							<ul class="dropdown-menu pull-right">
								
								<li><a href="<?php echo site_url('admin/address_book/edit/'.$p->id);?>"><i class="glyphicon glyphicon-edit"></i> Edit</a></li>
							  
								<li><a onClick="return confirm('<?php echo lang('web_confirm_delete')?>')" href='<?php echo site_url('admin/address_book/delete/'.$p->id);?>'><i class="glyphicon glyphicon-trash"></i> Trash</a></li>
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