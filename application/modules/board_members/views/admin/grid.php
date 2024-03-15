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

<div class="block-fluid">

 <?php if ($board_members): ?>
 
      <?php 
		 $i = 0;
			if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
			{
				$i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
			}
                
            foreach ($board_members as $p ): 
                 $i++;
				 
				      $path = base_url('uploads/files/'.$p->file);
						$fake = base_url('uploads/files/member.png');
					
                        if (!empty($p->file)){
							$ppst = '<image src="'.$path.'"  class="img-polaroid img-thumbnail" style="width:200px; height:180px" >';
						}  
                        else{
							$ppst =  '<image src="'.$fake.'"  class="img-polaroid img-thumbnail" style="width:200px; height:190px"  >';
						} 
          ?>
   <div class="col-md-4">               
                <div class="userCard">
                    <div class="image col-md-12" style="text-align:center">
					   <?php echo $ppst;?>
                    </div>
                    <div class="">
                        <h4 style="text-align:center"><?php echo $p->title;?>. <?php echo  $p->first_name .' ' . $p->last_name?></h4>
                        <p style="text-align:center">
						
						<span class="glyphicon glyphicon-ok"></span> <?php $pos = $this->ion_auth->populate('positions','id','name'); echo $pos [$p->position];?> 
						<span class="glyphicon glyphicon-ok"></span> <?php echo $p->gender;?>
						 <i style="color:green"> <?php if($p->status==1) echo '<span class="label label-success">Active</span>'; else echo '<span class="label label-danger">Inactive</span>';?></i>
						
						</p>
						<p style="text-align:center">
						<b>From:</b>  <?php echo date('d M Y',$p->date_joined);?>
						<b>Phone:</b>  <?php echo $p->phone;?><br>
						<b>Email:</b>  <?php echo $p->email;?><br>
						
						<p style="text-align:center">
							<a href="<?php echo site_url('admin/board_members/profile/'.$p->id);?>" class="btn btn-success">Profile</a>
							<a href="<?php echo site_url('admin/board_members/edit/'.$p->id);?>" class="btn btn-primary">Edit</a>
							<?php if($p->status==1){?>
							<a onClick="return confirm('Are you sure you want to make this member inactive')" href="<?php echo site_url('admin/board_members/disable/'.$p->id.'/'.$page);?>"class="btn btn-danger">Disable</a>
							<?php }else{ ?>
							   	<a onClick="return confirm('Are you sure you want to make this member active')" href="<?php echo site_url('admin/board_members/enable/'.$p->id.'/'.$page);?>"class="btn btn-warning">Enable</a>
							<?php } ?>
							
                        </p>
                    </div>
                </div>
            </div>
<?php endforeach ?>

<?php else: ?>
 	<p class='text'><?php echo lang('web_no_elements');?></p>
 <?php endif ?>

</div>

