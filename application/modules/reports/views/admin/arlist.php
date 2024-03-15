<div class="head">
    <div class="icon"><span class="icosg-target1"></span></div>
    <h2>Fee Arrears Breakdown Report</h2> 
    <div class="right">                       
    </div>    					
</div>
<style>
    a{color:#000;}
</style>
<div class="block invoice">
    <h1> </h1>

    <div class="row">
        <div class="col-md-10">
            <?php
            if ($term == 1)
            {
                    $atm = 3;
            }
            else
            {
                    $atm = $term - 1;
            }
            ?>
            <h3> <?php echo 'Term ' . $atm . ' Arrears Status  Report'; ?></h3>
        </div>

    </div>

    <table cellpadding="0" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th width="3%">#</th>
                <th width="20%">Name</th>
                <th width="20%">Amount</th>
                <th width="20%">Status</th>
                <th width="20%">Overall Balance</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;
            $tsum = 0;
            foreach ($arrears as $s)
            {
                    $stu = $this->worker->get_student($s->student);
                    $i++;
                    $tsum +=$s->amount;
                    ?>
                    <tr>
                        <td><?php echo $i . '. '; ?></td>
                        <td><?php echo anchor('admin/fee_payment/statement/' . $s->student, $stu->first_name . ' ' . $stu->last_name, 'title="View Statemet"'); ?> </td>
                        <td class="rttx"><?php echo number_format($s->amount, 2); ?></td>
                        <td class="rttx"> <?php
                            if ($s->amount > 0)
                            {
                                    if ($s->paid == $s->amount || $s->paid > $s->amount)
                                    {
                                            $st = 'Cleared';
                                    }
                                    else
                                    {
                                            $st = 'Pending ';
                                            //$st .= number_format($s->amount - $s->paid, 2);
                                    }
                                    echo $st;
                            }
                            ?></td>
                        <td class="rttx"><?php echo number_format($s->totbal, 2); ?></td>
                    </tr>

            <?php } ?>
            <tr>
                <td colspan="2" > </td>
                <td class="rttb"> <strong><?php echo number_format($tsum, 2); ?></strong></td>
                <td> </td>
                <td> </td>
            </tr>

        </tbody>
    </table>

    <div class="row">
        <div class="col-md-9"></div>
        <div class="col-md-3"> </div>
    </div>

</div>
