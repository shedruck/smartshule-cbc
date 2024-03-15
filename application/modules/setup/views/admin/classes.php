<div class="head"> 
    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2>  Classes  </h2>
    <div class="right">  
    </div>
</div>

<?php if ($class_groups): ?>
    <div class="block-fluid">
        <table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
            <thead>
            <th>#</th>
            <th>Name</th>
            <th>Total Students</th>
            <th>Streams</th>
            <th>Status</th>	
            <th>Description</th>	
            <th><?php echo lang('web_options'); ?></th>
            </thead>
            <tbody>
                <?php
                $i = 0;
                if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                {
                    $i = ($this->uri->segment(4) - 1) * $per;
                }

                foreach ($class_groups as $p):
                    $i++;
                    ?>
                    <tr>
                        <td><?php echo $i . '.'; ?></td>					
                        <td><?php echo $p->name; ?></td>
                        <td><?php echo $p->size; ?></td>
                        <td><?php
                            foreach ($p->streams as $st)
                            {
                                ?> 
                                <span class="label label-info">  <?php echo $st; ?></span>
                            <?php } ?>
                        </td>
                        <td><?php if( $p->status==1)echo '<b style="color:green">Active</b>'; else echo '<b style="color:red">Disabled</b>'; ?></td>
                        <td><?php echo $p->description; ?></td>

                        <td width='20%'>
                            <div class='btn-group'>
							  <?php if( $p->status==1): ?>
									<a class="btn btn-success" href='<?php echo site_url('admin/setup/add_stream/' . $p->id . '/' . $page); ?>'><i class='glyphicon glyphicon-plus'></i>Add Streams</a>
                                    
									 
									<?php endif;?>
                              
                            </div>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>

        </table>

    </div>

<?php else: ?>
    <p class='text'><?php echo lang('web_no_elements'); ?></p>
                                                     <?php endif; ?>
													 
		<div class="pagination pagination-centered pagination-large">
    <?php echo anchor('admin/setup/teachers/', '<i class="glyphicon glyphicon-circle-arrow-left"></i> Previous', 'class="btn btn-primary  btn-large"'); ?> 
    <?php echo anchor('admin/setup/subjects', '<i class="glyphicon glyphicon-circle-arrow-right"></i> Next', 'title="3" id="nexti" class="btn btn-success  btn-large"'); ?>    
</div>