<div class="head">
    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2>  Record Salaries  </h2>
    <div class="right">
        <?php echo anchor('admin/record_salaries/create/' . $page, '<i class="glyphicon glyphicon-plus"></i> Process Salary', 'class="btn btn-primary"'); ?>
        <?php echo anchor('admin/record_salaries', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => ' Salary Records')), 'class="btn btn-primary"'); ?>
    </div>
</div>
<?php if ($record_salaries): ?>
        <div class="block-fluid">
            <table class="table" cellpadding="0" cellspacing="0" width="100%">
                <thead>
                <th>#</th>
                <th>Salary For</th>
                <th>Date Processed</th>
                <th>Number of <br>Employees Paid</th>
                <th>Total Basic<br> Salary</th>	
                <th>Processed By</th>
                <th width="23%"><?php echo lang('web_options'); ?></th>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                    {
                            $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                    }
                    foreach ($record_salaries as $p):
                            $i++;
                            $u = $this->ion_auth->get_user($p->created_by);
                            $emp = $this->record_salaries_m->count_employees($p->salary_date);
                            $tots = $this->record_salaries_m->total_salo($p->salary_date);
                            ?>
                            <tr>
                                <td><?php echo $i . '.'; ?></td>
                                <td><?php echo $p->month . ' ' . $p->year; ?></td>
                                <td><?php echo date('l d F, Y', $p->salary_date); ?></td>
                                <td><?php
                                    if ($emp == 1)
                                            echo $emp . ' Employee';
                                    else
                                            echo $emp . ' Employees';
                                    ?> </td>
                                <td><?php echo $this->currency; ?> <?php echo number_format($tots->total, 2); ?></td>
                                <td><?php echo $u->first_name . ' ' . $u->last_name; ?></td>
                                <td >
                                    <div class='btn-group'>
                                        <a class="btn btn-success" href='<?php echo site_url('admin/record_salaries/employees/' . $p->salary_date); ?>'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                                        <a class="btn btn-primary" href='<?php echo site_url('admin/record_salaries/export/' . $p->salary_date); ?>'><i class='glyphicon glyphicon-file'></i> Export</a>
                                        <a class="btn btn-danger" href='<?php echo site_url('admin/record_salaries/void/' . $p->salary_date); ?>' onClick="return confirm('<?php echo lang('web_confirm_delete') ?>')"><i class='glyphicon glyphicon-trash'></i> Void</a>
                                    </div>
                                </td>
                            </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
<?php else: ?>
        <p class='text'>
            <?php echo lang('web_no_elements'); ?>
        </p>
                                        <?php endif ?>
