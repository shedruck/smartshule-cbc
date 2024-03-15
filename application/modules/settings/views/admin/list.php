<div class="head"> 
    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2>  Settings  </h2>
    <div class="right">  
        <?php echo anchor('admin/settings', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Settings')), 'class="btn btn-primary"'); ?> 
    </div>
</div>

<?php if ($settings): ?>
    <div class="block-fluid">
        <table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
            <thead>
            <th>#</th><th>School</th><th>Postal Addr</th><th>Email</th><th>Website</th><th>Fax</th><th>Town</th><th>School Code</th>	<th ><?php echo lang('web_options'); ?></th>
            </thead>
            <tbody>
                <?php
                $i = 0;
                if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                {
                    $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                }

                foreach ($settings as $p):
                    $i++;
                    ?>
                    <tr>
                        <td><?php echo $i . '.'; ?></td>					
                        <td><?php echo $p->school; ?></td>
                        <td><?php echo $p->postal_addr; ?></td>
                        <td><?php echo $p->email; ?></td>
                        <td><?php echo $p->website; ?></td>
                        <td><?php echo $p->fax; ?></td>
                        <td><?php echo $p->town; ?></td>
                        <td><?php echo $p->school_code; ?></td>

                        <td width='20%'>
                            <div class='btn-group'>
                                <button class='btn dropdown-toggle' data-toggle='dropdown'>Action <i class='glyphicon glyphicon-caret-down'></i></button>
                                <ul class='dropdown-menu pull-right'>
                                    <li><a href='<?php echo site_url('admin/settings/edit/' . $p->id . '/' . $page); ?>'><i class='glyphicon glyphicon-eye-open'></i> View</a></li>
                                    <li><a  href='<?php echo site_url('admin/settings/edit/' . $p->id . '/' . $page); ?>'><i class='glyphicon glyphicon-edit'></i> Edit</a></li>

                                    <li><a  onClick="return confirm('<?php echo lang('web_confirm_delete') ?>')" href='<?php echo site_url('admin/settings/delete/' . $p->id . '/' . $page); ?>'><i class='glyphicon glyphicon-trash'></i> Trash</a></li>
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