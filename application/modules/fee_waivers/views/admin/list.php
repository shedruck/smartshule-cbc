<div class="head"> 
    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2>  Fee Waivers  </h2>
    <div class="right">  
        <?php echo anchor('admin/fee_waivers/create/' . $page, '<i class="glyphicon glyphicon-plus"></i> ' . lang('web_add_t', array(':name' => 'Fee Waivers')), 'class="btn btn-primary"'); ?>

        <?php echo anchor('admin/fee_waivers', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Fee Waivers')), 'class="btn btn-primary"'); ?> 
    </div>
</div>


<?php if ($fee_waivers): ?>
    <div class="block-fluid">
        <table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
            <thead>
            <th>#</th>
            <th>Date</th>
            <th>Student</th>
            <th>Amount (<?php echo $this->currency;?>)</th>
            <th>Term</th>
            <th>Year</th>
            <th>Remarks</th>	
            <th ><?php echo lang('web_options'); ?></th>
            </thead>
            <tbody>
                <?php
                $i = 0;
                if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                {
                    $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                }

                foreach ($fee_waivers as $p):
                    $st = $this->worker->get_student($p->student);
                    if (empty($st))
                    {
                        $st = new stdClass();
                        $st->first_name = '';
                        $st->last_name = '';
                    }
                    $i++;
                    ?>
                    <tr>
                        <td><?php echo $i . '.'; ?></td>					
                        <td><?php echo date('d M Y', $p->date); ?></td>
                        <td><?php echo $st->first_name . ' ' . $st->last_name; ?></td>
                        <td><?php echo number_format($p->amount, 2); ?></td>
                        <td><?php echo $p->term; ?></td>
                        <td><?php echo $p->year; ?></td>
                        <td><?php echo $p->remarks; ?></td>

                        <td width='24%'>
                            <div class='btn-group'>
                                <a class='btn btn-primary' href='<?php echo site_url('admin/fee_waivers/edit/' . $p->id . '/' . $page); ?>'><i class='glyphicon glyphicon-edit'></i> Edit</a>
                                <a class='btn btn-danger' onClick="return confirm('<?php echo lang('web_confirm_delete') ?>')" href='<?php echo site_url('admin/fee_waivers/delete/' . $p->id . '/' . $page); ?>'><i class='glyphicon glyphicon-trash'></i> Trash</a>

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