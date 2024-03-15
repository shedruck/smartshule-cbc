<div class="head"> 
    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2>  Non Teaching Staff  </h2>
    <div class="right">  
         <?php echo anchor('admin/non_teaching/create/' . $page, '<i class="glyphicon glyphicon-plus"></i> ' . lang('web_add_t', array(':name' => 'Non Teaching')), 'class="btn btn-primary"'); ?>

			<?php echo anchor('admin/non_teaching', '<i class="glyphicon glyphicon-list">
                </i> Non Teaching Grid View', 'class="btn btn-success"'); ?> 
				
        <?php echo anchor('admin/non_teaching/list_view', '<i class="glyphicon glyphicon-list">
                </i> Non Teaching List View', 'class="btn btn-info"'); ?>
			<?php echo anchor('admin/non_teaching/inactive', '<i class="glyphicon glyphicon-list">
                </i> Inactive Non Teaching', 'class="btn btn-warning"'); ?>		
    </div>
</div>

<div class="block-fluid">
 <?php if ($non_teaching): ?>
 
      <?php 
		 $i = 0;
			if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
			{
				$i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
			}
                
        $preff = "<div class=\"col-md-12\">\n\r";
        $suff = "</div>\n\r";
        $j = 0;
        foreach ($non_teaching as $p):
                 $i++;
            $j++;
            if ($j == 1)
            {
                echo $preff;
            }
            $path = base_url('uploads/files/' . $p->passport);
						$fake = base_url('uploads/files/member.png');
					
            if (!empty($p->passport))
            {
                $ppst = '<image src="' . $path . '"  class="img-polaroid img-thumbnail" style="width:200px; height:180px" >';
						}  
            else
            {
                $ppst = '<image src="' . $fake . '"  class="img-polaroid img-thumbnail" style="width:200px; height:190px"  >';
						} 
          ?>
   <div class="col-md-3">               
                <div class="userCard">
                    <div class="image col-md-12" style="text-align:center">
                        <?php echo $ppst; ?>
                    </div>
                    <div class="">
                        <h4 style="text-align:center"><?php echo $p->first_name . ' ' . $p->middle_name . ' ' . $p->last_name ?></h4>
                        <p style="text-align:center">
						
                            <i style="color:green"> <?php
                                if ($p->status == 1)
                                    echo '<span class="label label-success">Active</span>';
                                else
                                    echo '<span class="label label-danger">Inactive</span>';
                                ?></i>
						
						</p>
						<p style="text-align:center">
                            <a href="<?php echo site_url('admin/non_teaching/profile/' . $p->id); ?>" class="btn btn-success">Profile</a>
                            <a href="<?php echo site_url('admin/non_teaching/edit/' . $p->id); ?>" class="btn btn-primary">Edit</a>
							
                            <?php
                            if ($p->status == 1)
                            {
                                ?>
                                <a onClick="return confirm('Are you sure you want to make this member inactive')" href="<?php echo site_url('admin/non_teaching/disable/' . $p->id . '/' . $page); ?>"class="btn btn-danger">Disable</a>
                                <?php
                            }
                            else
                            {
                                ?>
                                <a onClick="return confirm('Are you sure you want to make this member active')" href="<?php echo site_url('admin/non_teaching/enable/' . $p->id . '/' . $page); ?>"class="btn btn-warning">Enable</a>
							<?php } ?>
							
                        </p>
                    </div>
                </div>
            </div>
            <?php
            if (($j % 4) == 0)
            {
                echo $suff . $preff;
            }

        endforeach
        ?>

<?php else: ?>
        <p class='text'><?php echo lang('web_no_elements'); ?></p>
 <?php endif ?>

</div>

