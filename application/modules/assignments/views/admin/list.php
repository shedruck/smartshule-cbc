<div class="head"> 
    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2>  Assignments  </h2>
    <div class="right">  
        <?php echo anchor('admin/assignments/create/' . $page, '<i class="glyphicon glyphicon-plus"></i> ' . lang('web_add_t', array(':name' => 'Assignments')), 'class="btn btn-primary"'); ?>
        <?php echo anchor('admin/assignments', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Assignments')), 'class="btn btn-primary"'); ?>
    </div>
</div>
<?php if ($assignments): ?>
        <div class="block-fluid">
            <table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
                <thead>
                <th>#</th>
                <th>Title</th>
                <th>Class</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Attachment</th>
                <th ><?php echo lang('web_options'); ?></th>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                    {
                            $i = ($this->uri->segment(4) - 1) * $per;
                    }

                    foreach ($assignments as $p):
                            $class_id = $this->assignments_m->get_classes($p->id);
                            $class = $this->ion_auth->classes_and_stream();
                            $i++;
                            ?>
                            <tr>
                                <td><?php echo $i . '.'; ?></td>					
                                <td><?php echo $p->title; ?></td>
                                <td>
                                    <?php
                                    $i = 0;
                                    foreach ($class_id as $c)
                                    {
                                            $i++;
                                            echo $i . '. ' . $class[$c->class] . '<br>';
                                    }
                                    ?>
                                </td>
                                <td><?php echo date('d/m/Y', $p->start_date); ?></td>
                                <td><?php echo date('d/m/Y', $p->end_date); ?></td>
                                <td width="180" style="text-align:center">
                                    <?php
                                    if (!empty($p->document))
                                    {
                                            ?>
                                            <a href="<?php echo base_url('uploads/files/' . $p->document); ?>"><i class="glyphicon glyphicon-download"></i> Download Attachment</a>
                                            <?php
                                    }
                                    else
                                    {
                                            ?>
                                            <b>---------</b>
                                    <?php } ?>
                                </td>
                                <td width='20%'>
                                    <div class='btn-group'>
                                        <button class='btn dropdown-toggle' data-toggle='dropdown'>Action <i class='glyphicon glyphicon-caret-down'></i></button>
                                        <ul class='dropdown-menu pull-right'>
                                            <li><a href='<?php echo site_url('admin/assignments/view/' . $p->id . '/' . $page); ?>'><i class='glyphicon glyphicon-eye-open'></i> Full Details</a></li>

											<li><a href='<?php echo site_url('admin/assignments/edit/' . $p->id . '/' . $page); ?>'><i class='glyphicon glyphicon-edit'></i> Edit Details</a></li>
											
                                            <li><a  onClick="return confirm('<?php echo lang('web_confirm_delete') ?>')" href='<?php echo site_url('admin/assignments/delete/' . $p->id . '/' . $page); ?>'><i class='glyphicon glyphicon-trash'></i> Move To Trash</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                    <?php endforeach ?>
                </tbody>
            </table> 
        </div>

<?php else: ?>
        <p class='text'><?php echo lang('web_no_elements'); ?></p>
<?php endif ?>