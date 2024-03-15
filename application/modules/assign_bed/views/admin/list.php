<div class="head"> 
    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2>  Assign Bed  </h2>
    <div class="right">  
        <?php echo anchor('admin/assign_bed/create/' . $page, '<i class="glyphicon glyphicon-plus"></i> Assign Bed', 'class="btn btn-primary"'); ?>

        <?php echo anchor('admin/assign_bed', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Assign Bed')), 'class="btn btn-primary"'); ?> 

    </div>
</div>


<?php if ($assign_bed): ?>
    <div class="block-fluid">
        <table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
            <thead>
            <th>#</th>
            <th>Date Assigned</th>
            <th>Term</th>
            <th>Year</th>
            <th>Student</th>
            <th>Bed</th>
            <th>Comment</th>
            <th>Assigned By</th>
            <th width="20%"><?php echo lang('web_options'); ?></th>
            </thead>
            <tbody>
                <?php
                $i = 0;
                if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                {
                    $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                }

                foreach ($assign_bed as $p):
                    $st = $this->worker->get_student($p->student);
                    if (empty($st))
                    {
                        $st = new stdClass();
                        $st->first_name = '';
                        $st->last_name = '';
                    } 
                    $u = $this->ion_auth->get_user($p->created_by);
                     $i++;
                    ?>
                    <tr>
                        <td><?php echo $i . '.'; ?></td>					
                        <td><?php echo date('d M Y', $p->date_assigned); ?></td>
                        <td><?php echo $this->terms[$p->term]; ?></td>
                        <td><?php echo $p->year; ?></td>
                        <td><?php echo $st->first_name . ' ' . $st->last_name; ?></td>

                        <td><?php echo $beds[$p->bed]; ?></td>
                        <td><?php echo $p->comment; ?></td>
                        <td><?php echo ucwords($u->first_name . ' ' . $u->last_name); ?></td>

                        <td width='20%'>
                            <div class='btn-group'>
                                <a class='btn btn-primary' href='<?php echo site_url('admin/assign_bed/edit/' . $p->id . '/' . $page); ?>'><i class='glyphicon glyphicon-edit'></i> Edit</a>
                                <a class='btn btn-danger' onClick="return confirm('<?php echo lang('web_confirm_delete') ?>')" href='<?php echo site_url('admin/assign_bed/delete/' . $p->id . '/' . $page); ?>'><i class='glyphicon glyphicon-trash'></i> Trash</a>
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