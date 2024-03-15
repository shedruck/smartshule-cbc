<div class="head">
    <div class="icon"><span class="icosg-target1"></span></div>
    <h2> Subjects </h2>
    <div class="right">
        <?php echo anchor('admin/subjects/create/' . $page, '<i class="glyphicon glyphicon-plus"></i> ' . lang('web_add_t', array(':name' => 'Subjects')), 'class="btn btn-primary"'); ?>
        <?php echo anchor('admin/subjects', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Subjects')), 'class="btn btn-primary"'); ?>
        <?php echo anchor('admin/subjects/per_class', '  Allocation Report ', 'class="btn btn-primary"'); ?>
    </div>
</div>
<?php if ($subjects): ?>
        <div class="block-fluid">
            <table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Short Name</th>
                        <th>Priority</th>
                        <th>Custom</th>
                        <th><?php echo lang('web_options'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    if ($this->uri->segment(4) && ((int) $this->uri->segment(4) > 0))
                    {
                            $i = ($this->uri->segment(4) - 1) * $per;
                    }
                    foreach ($subjects as $p):
                            $i++;
                            ?>
                            <tr>
                                <td><?php echo $i . '.'; ?></td>
                                <td><?php echo $p->name; ?></td>
                                <td width="30%"><?php
                                    foreach ($p->subs as $snid => $ops)
                                    {
                                            $ps = (object) $ops;
                                            echo '<span class="label label-info">' . $ps->title . '</span> ';
                                    }
                                    ?></td>
                                <td><?php echo $p->short_name; ?></td>
                                <td><?php echo $p->priority; ?></td>
                                <td><?php echo $p->custom; ?></td>
                                <td width='20%'>
                                    <div class='btn-group'>
                                        <button class='btn dropdown-toggle' data-toggle='dropdown'>Action <i class='glyphicon glyphicon-caret-down'></i></button>
                                        <ul class='dropdown-menu pull-right'>
                                            <li><a href='<?php echo site_url('admin/subjects/units/' . $p->id . '/' . $page); ?>'><i class='glyphicon glyphicon-share-alt'></i> Sub Units</a></li>
                                            <li><a href='<?php echo site_url('admin/subjects/view/' . $p->id . '/' . $page); ?>'><i class='glyphicon glyphicon-eye-open'></i> View</a></li>
                                            <li><a href='<?php echo site_url('admin/subjects/edit/' . $p->id . '/' . $page); ?>'><i class='glyphicon glyphicon-edit'></i> Edit</a></li>
                                            <li><a onClick="return confirm('<?php echo lang('web_confirm_delete') ?>')"
                                                   href='<?php echo site_url('admin/subjects/delete/' . $p->id . '/' . $page); ?>'><i class='glyphicon glyphicon-trash'></i> Trash</a>
                                            </li>
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