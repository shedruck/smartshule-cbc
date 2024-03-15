<div class="head"> 
    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2> Student Ledger </h2>
</div>

<div class="block-fluid">
    <div class="row hidden-print">
        <?php
        echo form_open(current_url());
        $data = $this->ion_auth->students_full_details();
        echo form_dropdown('student', array('' => 'Select Student') + $data, $this->input->post('student'), 'class ="select" ');
        ?>
        <?php
        $items = ['1' => 'Invoices', '2' => 'Fee Extras', '3' => 'Payments'];
        echo form_dropdown('item', array('' => 'Select Item') + $items, $this->input->post('item'), 'class ="select" ');
        ?>

        <?php
        $terms = ['1' => 'Term 1', '2' => 'Term 2', '3' => 'Term 3'];
        echo form_dropdown('term', array('' => 'Term') + $terms, $this->input->post('term'), 'class ="select" ');
        ?>

        <?php echo form_dropdown('year', array('' => 'Year') + $yrs, $this->input->post('year'), 'class ="select" '); ?>
        <button class="btn btn-primary" type="submit">List</button>
    </div>
    <?php echo form_close() ?>
    <?php
    if ($this->input->post('student'))
    {
        ?>
        <center>
            <h2>
                Student Ledger for 
                <?php
                $st = $this->worker->get_student($this->input->post('student'));
                echo ucwords($st->first_name . ' ' . $st->last_name);
                ?>
                <button class="btn btn-success hidden-print" onClick="window.print()">Print <i class="glyphicon glyphicon-print"></i></button>
            </h2>
        </center>
    <?php } ?>

    <?php
    if (isset($invoices))
    {
        ?>
        <table class="table table-borderless">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Doc Number</th>
                    <th>Amount</th>
                    <th>Description</th>
                    <th>Created By</th>
                    <th>Status</th>
                    <th class="hidden-print">Action</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $index = 1;
                $status = [
                    '0' => 'Rejected',
                    '1' => 'Active',
                    '2' => 'Pending',
                    '3' => 'Voided',
                    '4' => 'Reversed'
                ];
                foreach ($invoices as $in)
                {
                    $user = $this->ion_auth->get_user($in->created_by);
                    $flag = $in->flagged;
                    ?>
                    <tr>
                        <td><?php echo $index ?></td>
                        <td><?php echo date('dS M, Y', $in->created_on) ?></td>
                        <td><?php echo $in->invoice_no ?></td>
                        <td><?php echo number_format($in->amount, 2) ?></td>
                        <td> Tuition Fee Payable Term <?php echo $in->term . ' ' . $in->year ?></td>
                        <td><?php echo ucwords($user->first_name . ' ' . $user->last_name) ?></td>
                        <td><?php echo isset($status[$in->check_st]) ? $status[$in->check_st] : ''; ?></td>
                        <td class="hidden-print">
                            <?php
                            // if($flag)
                            // {
                            //     echo '<span class="label label-danger">Flagged</span>';
                            // }else{
                            ?>
                            <a href="<?php echo base_url('admin/student_ledger/flag_invoice/' . $in->id) ?>"><i class="glyphicon glyphicon-flag"></i></a>
                            <?php /* } */ ?>
                        </td>
                    </tr>
                    <?php
                    $index++;
                }
                ?>
            </tbody>
        </table>
    <?php } ?>

    <?php
    if (isset($f_extras))
    {
        ?>
        <table class="table table-borderless">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Doc Number</th>
                    <th>Amount</th>
                    <th>Description</th>
                    <th>Created By</th>
                    <th>Status</th>
                    <th class="hidden-print">Action</th>
                </tr>
            </thead>
            <?php
            $index = 1;
            $status = [
                '0' => 'Pending',
                '1' => 'Active',
                '2' => 'Reversed',
                '3' => 'Rejected',
            ];
            foreach ($f_extras as $f)
            {
                $user = $this->ion_auth->get_user($f->created_by);
                $flag = $f->flagged;
                ?>
                <tr>
                    <td><?php echo $index ?></td>
                    <td><?php echo date('dS M, Y', $f->created_on) ?></td>
                    <td><?php echo $f->invoice_no ?></td>
                    <td><?php echo number_format($f->amount, 2) ?></td>
                    <td><?php echo isset($xtras[$f->fee_id]) ? $xtras[$f->fee_id] : '' ?> <?php echo 'Term' . $f->term . ' ' . $f->year ?></td>
                    <td><?php echo ucwords($user->first_name . ' ' . $user->last_name) ?></td>
                    <td><?php echo isset($status[$f->status]) ? $status[$f->status] : '' ?></td>
                    <td>
                        <?php
                        if ($flag)
                        {
                            echo '<span class="label label-danger">Flagged</span>';
                        }
                        else
                        {
                            ?>
                            <a href="<?php echo base_url('admin/student_ledger/flag_extra/' . $f->id) ?>"><i class="glyphicon glyphicon-flag"></i></a>
                        <?php } ?>
                    </td>
                </tr>
                <?php
                $index++;
            }
            ?>
            <tbody>
            </tbody>
        </table>
    <?php } ?>
    <?php
    if (isset($payments))
    {
        ?>

        <table class="table table-borderless">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Doc Number</th>
                    <th>Amount</th>
                    <th>Description</th>
                    <th>Created By</th>
                    <th>Status</th>
                    <th class="hidden-print">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $index = 1;
                $status = [
                    '0' => 'Rejected',
                    '1' => 'Active',
                    '2' => 'Pending',
                    '3' => 'Reversed',
                ];
                foreach ($payments as $p)
                {
                    $user = $this->ion_auth->get_user($p->created_by);
                    $flag = $p->flagged;
                    ?>
                    <tr>
                        <td><?php echo $index ?></td>
                        <td><?php echo date('dS M, Y', $p->created_on) ?></td>
                        <td><?php echo 'REC' . $p->receipt_id ?></td>
                        <td><?php echo number_format($p->amount, 2) ?></td>
                        <td><?php echo isset($xtras[$p->description]) ? $xtras[$p->description] : 'Tuition Fee Payment' ?> <?php echo 'Term ' . $p->term . ' ' . $p->year ?></td>
                        <td><?php echo ucwords($user->first_name . ' ' . $user->last_name) ?></td>
                        <td><?php echo isset($status[$p->status]) ? $status[$p->status] : '' ?></td>
                        <td>
        <?php
        if ($flag)
        {
            echo '<span class="label label-danger">Flagged</span>';
        }
        else
        {
            ?>

                                <a href="<?php echo base_url('admin/student_ledger/flag_payment/' . $p->id) ?>"><i class="glyphicon glyphicon-flag"></i></a>
                            <?php } ?>
                        </td>
                    </tr>
                                <?php
                                $index++;
                            }
                            ?>
            </tbody>
            <?php } ?>
</div>
</div>