<div class="col-md-12">
    <div class="panel panel-primary" >
        <div class="panel-heading">   
            Counties  
            <span class="tools pull-right">
                <a class="fa fa-chevron-down" href="javascript:;"></a>
            </span>
        </div>

        <div class="panel-body" >  
            <div class="widget-main">
                <div class="bs-example pull-right">
                    <?php echo anchor('admin/counties/create/' . $page, '<i class="fa fa-plus"></i> ' . lang('web_add_t', array(':name' => 'Counties')), 'class="btn btn-info btn-icon icon-left"'); ?>                    </div> 

                <?php if ($counties): ?>
                    <div class='space-6'></div>

    <table id="ModeTable" cellpadding="0" cellspacing="0" width="100%">
                        <thead>
                        <th>#</th>
						<th>Name</th>
						<th>Description</th>	
						<th ><?php echo lang('web_options'); ?></th>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                            {
                                $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                            }

                            foreach ($counties as $p):
                                $i++;
                                ?>
                                <tr>
                                    <td><?php echo $i . '.'; ?></td>					
									<td><?php echo $p->name; ?></td>
                                    <td><?php echo $p->description; ?></td>
									
                                    <td width='150'>
									<a class=' btn-info btn btn-small' href='<?php echo site_url('admin/counties/edit/' . $p->id . '/' . $page); ?>'><?php echo lang('web_edit'); ?></a>
									
									<a class='btn btn-danger' onClick="return confirm('<?php echo lang('web_confirm_delete') ?>')" href='<?php echo site_url('admin/counties/delete/' . $p->id . '/' . $page); ?>'><?php echo lang('web_delete') ?></a>
									</td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>

                    </table>

                    <?php echo $links; ?>
               
                </div>
            </div>
        </div>
    </div>

    </div>

<?php else: ?>
    <p class='text'><?php echo lang('web_no_elements'); ?></p>
         <?php endif ?>