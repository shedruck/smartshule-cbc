<div class="head"> 
    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2>  Transport Buses  </h2>
    <div class="right">  
        <?php echo anchor('admin/transport_buses/create/' . $page, '<i class="glyphicon glyphicon-plus"></i> ' . lang('web_add_t', array(':name' => 'Buses')), 'class="btn btn-primary"'); ?>
        <?php echo anchor('admin/transport_buses', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Buses')), 'class="btn btn-primary"'); ?> 
    </div>
</div>
<?php if ($transport_buses): ?>
    <div class="block-fluid">
        <table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Reg No</th>
                    <th>Capacity</th>
                    <th>Description</th>
                    <th ><?php echo lang('web_options'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                {
                    $i = ($this->uri->segment(4) - 1) * $per;
                }

                foreach ($transport_buses as $p):
                    $i++;
                    ?>
                    <tr>
                        <td><?php echo $i . '.'; ?></td>
                        <td><?php echo $p->reg_no; ?></td>
                        <td><?php echo $p->capacity; ?></td>
                        <td><?php echo $p->description; ?></td>

                        <td width='30'>
                            <div class='btn-group'>
                                <button class='btn dropdown-toggle' data-toggle='dropdown'>Action <i class='glyphicon glyphicon-caret-down'></i></button>
                                <ul class='dropdown-menu pull-right'>
                                    <li><a href='<?php echo site_url('admin/transport_buses/edit/' . $p->id . '/' . $page); ?>'><i class='glyphicon glyphicon-eye-open'></i>  Edit</a></li>
                                    <li><a  href='<?php echo site_url('admin/transport_buses/assign_staff/' . $p->id . '/' . $page); ?>'><i class='glyphicon glyphicon-plus'></i> Assign Staff</a></li>
                                    <li><a  onClick="return confirm('<?php echo lang('web_confirm_delete') ?>')" href='<?php echo site_url('admin/transport_buses/delete/' . $p->id . '/' . $page); ?>' class="hidden"><i class='glyphicon glyphicon-trash'></i> Trash</a></li>
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