<div class="head"> 
    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2>  Permissions  </h2>
    <div class="right">  
        <?php echo anchor('admin/permissions/create/' . $page, '<i class="glyphicon glyphicon-plus  glyphicon glyphicon-white"></i> ' . lang('web_add_t', array(':name' => 'Permissions')), 'class="btn btn-primary"'); ?>

        <?php echo anchor('admin/permissions', '<i class="glyphicon glyphicon-list glyphicon glyphicon-white">
                </i> ' . lang('web_list_all', array(':name' => 'Permissions')), 'class="btn btn-primary"'); ?> 

    </div>
</div>


<?php if ($permissions): ?>
        <div class="block-fluid">
            <table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
                <thead>
                <th>#</th><th>Name</th> 
                <th>Description</th>
                <th ><?php echo lang('web_options'); ?></th>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                    {
                            $i = ($this->uri->segment(4) - 1) * $per;
                    }

                    foreach ($permissions as $p):
                            $i++;
                            ?>
                            <tr>
                                <td><?php echo $i . '.'; ?></td>					
                                <td><?php echo $p->resource; ?></td>
                                <td><?php echo $p->description; ?></td>

                                <td width='20%'>
                                    <div class='btn-group'>
                                        <button class='btn dropdown-toggle' data-toggle='dropdown'>Action <i class='glyphicon glyphicon-caret-down'></i></button>
                                        <ul class='dropdown-menu pull-right'>
                                            <li><a href='<?php echo site_url('admin/permissions/edit/' . $p->id . '/' . $page); ?>'><i class='glyphicon glyphicon-eye-open'></i> View</a></li>
                                            <li><a  href='<?php echo site_url('admin/permissions/edit/' . $p->id . '/' . $page); ?>'><i class='glyphicon glyphicon-edit  glyphicon glyphicon-white  glyphicon glyphicon-white  glyphicon glyphicon-white'></i> Edit</a></li>

                                            <li><a  onClick="return confirm('<?php echo lang('web_confirm_delete') ?>')" href='<?php echo site_url('admin/permissions/delete/' . $p->id . '/' . $page); ?>'><i class='glyphicon glyphicon-trash'></i> Trash</a></li>
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