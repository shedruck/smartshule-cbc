<?php
// print_r($fee_arrears);die;
?>
<div class="head"> 
    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2>  Fee Arrears  </h2>
    <div class="right">  
        <?php echo anchor('admin/fee_arrears/create/' . $page, '<i class="glyphicon glyphicon-plus"></i> ' . lang('web_add_t', array(':name' => 'Fee Arears')), 'class="btn btn-primary"'); ?>

        <?php echo anchor('admin/fee_arrears', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Fee Arears')), 'class="btn btn-primary"'); ?> 

    </div>
</div>


<?php if ($fee_arrears): ?>
    <div class="block-fluid">
        <table class="fpTable" cellpadding="0" cellspacing="0" width="100%" id="arears_tbl">
            <thead>
                <tr>
                    <th width="3">#</th>
                    <th>Student</th>
                    <th>Amount (<?php echo $this->currency; ?>)</th>
                    <th>Term</th>
                    <th>Year</th>	
                    <th width="20%" ><?php echo lang('web_options'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                {
                    $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                }
                foreach ($fee_arrears as $p):
                    $st = $this->worker->get_student($p->student);
                    $cc = '';
                    if (isset($this->classlist[$st->class]))
                    {
                            $cro = $this->classlist[$st->class];
                            $cc = isset($cro['name']) ? $cro['name'] : '';
                    }
                    $i++;
                    ?>
                    <tr>
                        <td><?php echo $i . '.'; ?></td>					
                        <td><?php echo $st->first_name . ' ' . $st->last_name; ?> (<?php echo $cc ?>)</td>
                        <td><?php echo isset($p->amount) ? number_format($p->amount, 2) : ''; ?></td>
                        <td>Term <?php echo $p->term; ?></td>
                        <td><?php echo $p->year; ?></td>

                        <td width='20%'>
                            <div class='btn-group'>
                                <a class='btn btn-success' onClick="return confirm('You are about to edit this record.Are you sure of this action?')" href='<?php echo site_url('admin/fee_arrears/edit/' . $p->id . '/' . $page); ?>'>Edit</a>
                                <a class='btn btn-info' href='<?php echo site_url('admin/fee_payment/statement/' . $p->student); ?>'>Statement</a>
                                <a class='btn btn-danger' onClick="return confirm('<?php echo lang('web_confirm_delete') ?>')" href='<?php echo site_url('admin/fee_arrears/delete/' . $p->id . '/' . $page); ?>'>Trash</a>
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