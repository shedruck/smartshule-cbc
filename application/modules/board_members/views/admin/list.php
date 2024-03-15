<div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h2>  Board Members  </h2>
             <div class="right">  
             <?php echo anchor('admin/board_members/create/' . $page, '<i class="glyphicon glyphicon-plus"></i> ' . lang('web_add_t', array(':name' => 'Board Members')), 'class="btn btn-primary"'); ?>

			<?php echo anchor('admin/board_members', '<i class="glyphicon glyphicon-list">
                </i> Board Members Grid View', 'class="btn btn-success"'); ?> 
				
        <?php echo anchor('admin/board_members/list_view', '<i class="glyphicon glyphicon-list">
                </i> Board Members List View' , 'class="btn btn-info"'); ?> 
				
				<?php echo anchor('admin/board_members/inactive', '<i class="glyphicon glyphicon-list">
                </i> Inactive Board Members' , 'class="btn btn-warning"'); ?>
             
                </div>
                </div>
         	                    
              
                 <?php if ($board_members): ?>
                 <div class="block-fluid">
				<table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
	 <thead>
                <th>#</th>
				<th>Passport</th>
				<th>Name</th>
				<th>Gender</th>
				<th>Date Joined</th>
				<th>Position</th>
				<th>Phone</th>
				<th>Email</th>
				
				<th>Profile</th>
				<th ><?php echo lang('web_options');?></th>
		</thead>
		<tbody>
		<?php 
                             $i = 0;
                                if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                                {
                                    $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                                }
             
            $pos = $this->ion_auth->populate('positions','id','name');			
            foreach ($board_members as $p ): 
                 $i++;
                     ?>
	 <tr>
					<td><?php echo $i . '.'; ?></td>					
					<td>
					    <?php
                        if (!empty($p->file)):
                             
						?> 
						<image src="<?php echo base_url('uploads/files/' . $p->file); ?>" width="40" height="40" class="img-polaroid" >
                       
                        <?php else: ?>   
                              <image src="<?php echo base_url('uploads/files/member.png'); ?>" width="40" height="40" class="img-polaroid" >
                        <?php endif; ?> 
					</td>
					<td><?php echo $p->title;?>. <?php echo $p->first_name;?> <?php echo $p->last_name;?></td>
				
					<td><?php echo $p->gender;?></td>
					<td><?php echo date('d M Y',$p->date_joined);?></td>
					<td><?php  echo $pos [$p->position];?> </td>
					<td><?php echo $p->phone;?></td>
					<td><?php echo $p->email;?></td>
					
					<td><?php echo $p->profile;?></td>

			 <td width='30'>
						 <div class='btn-group'>
							<button class='btn dropdown-toggle' data-toggle='dropdown'>Action <i class='glyphicon glyphicon-caret-down'></i></button>
							<ul class='dropdown-menu pull-right'>
								
								<li><a  href='<?php echo site_url('admin/board_members/edit/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-edit'></i> Edit</a></li>
							  
								<li><a  onClick="return confirm('<?php echo lang('web_confirm_delete')?>')" href='<?php echo site_url('admin/board_members/delete/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-trash'></i> Trash</a></li>
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