<div class="head"> 
    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2>  Activities  </h2>
    <div class="right">  
        <?php echo anchor('admin/activities/create/' . $page, '<i class="glyphicon glyphicon-plus"></i> ' . lang('web_add_t', array(':name' => 'Activities')), 'class="btn btn-primary"'); ?>
        <?php echo anchor('admin/activities', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Activities')), 'class="btn btn-primary"'); ?> 
    </div>
</div>
<?php if ($activities): ?>
        <div class="block-fluid">
            <table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>#</th><th>Name</th>
                        <th>Teacher</th>
                        <th><?php echo lang('web_options'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                    {
                            $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                    }

                    foreach ($activities as $p):
                            $i++;
                            //$tt = $this->ion_auth->get_user($p->teacher);
                            ?>
                            <tr>
                                <td><?php echo $i . '.'; ?></td>		
                                <td><?php echo $p->name; ?></td>
                                <td><?php echo $p->teacher; ?></td>
                                <td width='20%'>
                                    <div class='btn-group'>
                                        <button class='btn dropdown-toggle' data-toggle='dropdown'>Action <i class='glyphicon glyphicon-caret-down'></i></button>
                                        <ul class='dropdown-menu pull-right'>
                                            <li><a href='<?php echo site_url('admin/activities/assign_teacher/' . $p->id . '/'); ?>'><i class='glyphicon glyphicon-eye-open'></i> Assign Teacher</a></li>
                                            <li><a href='<?php echo site_url('admin/activities/edit/' . $p->id . '/' . $page); ?>'><i class='glyphicon glyphicon-edit'></i> Edit</a></li>
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