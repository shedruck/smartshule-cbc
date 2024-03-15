<div class="head"> 
    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2>  Exams  </h2>
    <div class="right">  
        <?php echo anchor('admin/exams/create/' . $page, '<i class="glyphicon glyphicon-plus"></i> ' . lang('web_add_t', array(':name' => 'Exams')), 'class="btn btn-primary"'); ?>
        <?php echo anchor('admin/exams', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Exams')), 'class="btn btn-primary"'); ?> 
    </div>
</div>

<?php if ($exams): ?>
        <div class="block-fluid">
            <table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
                <thead>
                <th>#</th>
                <th>Title</th>
                <th>Term</th>
                <th>Year</th>
                <th>Start</th>
                <th>End</th>
                <th>Recording Final Day</th>
                <th><?php echo lang('web_options'); ?></th>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                    {
                            $i = ($this->uri->segment(4) - 1) * $per;
                    }

                    foreach ($exams as $p):
                            $i++;
                            ?>
                            <tr>
                                <td><?php echo $i . '.'; ?></td>	
                                <td><?php echo $p->title; ?></td>
                                <td> <?php echo isset($this->terms[$p->term]) ? $this->terms[$p->term] : ' '; ?></td>
                                <td><?php echo $p->year; ?></td>
                                <td><?php echo $p->start_date ? date('d M Y', $p->start_date) : ''; ?></td>
                                <td><?php echo $p->end_date ? date('d M Y', $p->end_date) : ''; ?> </td>
                                <td><?php echo $p->recording_end_date ? date('d M Y', $p->recording_end_date) : ''; ?> </td>
                                <td width='40%'>
                                    
                                    <div class="btn-group">
                                        <button class="btn btn-success">Record</button>
                                        <button class="btn  btn-success dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
                                        <ul class="dropdown-menu">
                                            <?php
                                            foreach ($classes as $xid => $c)
                                            {
                                                    if ($c->rec == 2)
                                                    {
                                                            ?>    
                                                            <li><?php echo anchor('admin/exams/rec_lower/' . $p->id . '/' . $xid, $c->name); ?></li>
                                                            <?php
                                                    }
                                                    else
                                                    {
                                                            ?>    
                                                            <li><?php echo anchor('admin/exams/rec_upper/' . $p->id . '/' . $xid, $c->name); ?></li>
                                                            <?php
                                                    }
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                    <div class="btn-group">
                                        <button class="btn btn-success">Edit Marks</button>
                                        <button class="btn  btn-success dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
                                        <ul class="dropdown-menu">
                                            <?php
                                            foreach ($classes as $xid => $cl)
                                            {
                                                    if ($cl->rec == 2)
                                                    {
                                                            ?>    
                                                            <li><?php echo anchor('admin/exams/rec_lower/' . $p->id . '/' . $xid, $cl->name); ?></li>
                                                            <?php
                                                    }
                                                    else
                                                    {
                                                            ?>    
                                                            <li><?php echo anchor('admin/exams/bulk_edit/' . $p->id . '/' . $xid, $cl->name); ?></li>
                                                            <?php
                                                    }
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                    <?php echo anchor('admin/exams/bulk/' . $p->id, 'Report Forms', 'class="btn btn-success"'); ?>  
                                    <div class="btn-group">
                                        <a  class="btn btn-primary " href="<?php echo site_url('admin/exams/edit/' . $p->id . '/' . $page); ?>"><span class="glyphicon glyphicon-pencil"></span></a>
                                        <?php
                                        if ($this->ion_auth->is_in_group($this->user->id, 1))
                                        {
                                                ?>
                                                <a  class='btn btn-danger' onClick="return confirm('<?php echo lang('web_confirm_delete') ?>')" href='<?php echo site_url('admin/exams/delete/' . $p->id . '/' . $page); ?>'><span class="glyphicon glyphicon-remove"></span> </a>
                                        <?php } ?>
                                    </div>
                                </td>
                            </tr>
                    <?php endforeach ?>
                </tbody>

            </table>
        </div>

<?php else: ?>
        <p class='text'><?php echo lang('web_no_elements'); ?></p>
<?php endif; 