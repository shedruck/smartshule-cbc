 
<div class="head"> 
    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2>  Fee Balances Breakdown Report  </h2>
    <div class="right">  
        <?php echo anchor('admin/reports/fee/'  , '<i class="glyphicon glyphicon-bar-chart"></i> Back' , 'class="btn btn-primary"'); ?>
     </div>
</div>
<style>
    a{color:#000;}
</style>
<div class="block invoice">
    <h1> </h1>

    <div class="row">
        <div class="col-md-10">

            <h3> <?php echo 'Fee Balance Report'; ?></h3>
        </div>

    </div>

    <table cellpadding="0" cellspacing="0" width="50%">
        <thead>
            <tr>
                <th width="3%">#</th>
                <th width="20%">Name</th>
                <th width="20%">Balance</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;
            $tsum = 0;
            foreach ($bals as $sbal)
            {
                    $s = (object) $sbal;
                    $stu = $this->worker->get_student($s->student);
                    $i++;
                    $tsum +=$s->amount;
                    ?>
                    <tr>
                        <td><?php echo $i . '. '; ?></td>
                        <td><?php echo anchor('admin/fee_payment/statement/' . $s->student, $stu->first_name . ' ' . $stu->last_name, 'title="View Statemet"'); ?> </td>
                        <td class="rttx"><?php echo number_format($s->amount, 2); ?></td>
                    </tr>

            <?php } ?>
            <tr>
                <td> </td>
                <td> </td>
                <td class="rttb"> <strong><?php echo number_format($tsum, 2); ?></strong></td>
                
            </tr>

        </tbody>
    </table>

    <div class="row">
        <div class="col-md-9"></div>
        <div class="col-md-3"> </div>
    </div>

</div>
