<div class="head"> 
    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2>  Extra Curricular Activities  </h2>
    <div class="right">  
        <?php echo anchor('admin/extra_curricular/create/', '<i class="glyphicon glyphicon-plus"></i> Add Student To Activity', 'class="btn btn-primary"'); ?>
        <?php echo anchor('admin/activities/', '<i class="glyphicon glyphicon-pencil">  </i> Manage Activities', 'target="blank" class="btn btn-primary"'); ?>
        <?php echo anchor('admin/reports/activities/', '<i class="glyphicon glyphicon-list">  </i> Filter Activities', 'target="blank" class="btn btn-success"'); ?>
    </div>
</div>
<?php if ($extras): ?>
        <div class="block-fluid">
            <table class="table" cellpadding="0" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Activity</th>
                        <th>Current Students</th>
                        <th><?php echo lang('web_options'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                    {
                            $i = ($this->uri->segment(4) - 1) * $per;
                    }

                    foreach ($extras as $ex):
                            $p = (object) $ex;
                            $i++;
                            ?>
                            <tr>
                                <td><?php echo $i . '.'; ?></td>					
                                <td><?php echo $p->title; ?></td>
                                <td><b><?php echo $p->count; ?></b> Student(s)</td>
                                <td width='25%'>
                                    <div class="btn-group">
                                        <button class="btn btn-default">Action</button>
                                        <button class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
                                        <ul class="dropdown-menu">
                                            <li class="divider"></li>
                                            <li> <a href="<?php echo site_url('admin/extra_curricular/remove/' . $p->id); ?>"><i class="glyphicon glyphicon-edit"></i> Remove Students</a></li> 
                                            <li class="divider"></li>
                                            <li> <a href="<?php echo site_url('admin/extra_curricular/contacts/' . $p->id); ?>"><i class="glyphicon glyphicon-edit"></i> Parent Emails</a></li> 
                                            <li class="divider"></li>
                                        </ul>
										
										<a class="btn btn-success" href="<?php echo site_url('admin/extra_curricular/view_students/' . $p->id); ?>"><i class="glyphicon glyphicon-share"></i> View Students</a>
                                    </div>
                                </td>
                            </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>


        </div>

<?php else: ?>
        <p class='text'><?php echo lang('web_no_elements'); ?></p>
                                                                                     <?php endif ?>