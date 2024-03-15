<div class="head"> 
    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2>  Expense Items  </h2>
    <div class="right">  
        <?php echo anchor('admin/expense_items/create/' . $page, '<i class="glyphicon glyphicon-plus"></i> ' . lang('web_add_t', array(':name' => 'Expense Items')), 'class="btn btn-primary"'); ?>
         <?php echo anchor('admin/expense_items', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Expense Items')), 'class="btn btn-primary"'); ?> 

    </div>
</div>
 
<?php if ($expense_items): ?>
    <div class="block-fluid">
        <table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
            <thead>
            <th>#</th><th>Name</th><th>Description</th>	<th ><?php echo lang('web_options'); ?></th>
            </thead>
            <tbody>
                <?php
                $i = 0;
                if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                {
                    $i = ($this->uri->segment(4) - 1) * $per; 
                }

                foreach ($expense_items as $p):
                    $i++;
                    ?>
                    <tr>
                        <td><?php echo $i . '.'; ?></td>					
                        <td><?php echo $p->name.' <strong>'.$p->id.'</strong>'; ?></td>
                        <td><?php echo $p->description; ?></td>

                        <td width='20%'>
                            <div class='btn-group'>
                                <button class='btn dropdown-toggle' data-toggle='dropdown'>Action <i class='glyphicon glyphicon-caret-down'></i></button>
                                <ul class='dropdown-menu pull-right'>
                                    <li><a href='<?php echo site_url('admin/expense_items/edit/' . $p->id . '/' . $page); ?>'><i class='glyphicon glyphicon-eye-open'></i> View</a></li>
                                    <li><a  href='<?php echo site_url('admin/expense_items/edit/' . $p->id . '/' . $page); ?>'><i class='glyphicon glyphicon-edit'></i> Edit</a></li>

                                    <li><a  onClick="return confirm('<?php echo lang('web_confirm_delete') ?>')" href='<?php echo site_url('admin/expense_items/delete/' . $p->id . '/' . $page); ?>'><i class='glyphicon glyphicon-trash'></i> Trash</a></li>
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