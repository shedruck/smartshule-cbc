<div class="head">
    <div class="icon"><span class="icosg-target1"></span></div>
    <h2>Fee Extras Report</h2> 
    <div class="right">
    </div>
</div>
<div class="toolbar">
    <div class="col-md-10"><br/>
        <?php echo form_open(current_url()); ?>
        Class
        <?php echo form_dropdown('class', array('' => 'Select Class') + $this->classes, $this->input->post('class'), 'class ="tsel" '); ?>
    </div>
    <div class="col-md-2"><br/>
        <button class="btn btn-primary"  type="submit">View Report</button>
        <?php echo form_close(); ?>
    </div>
</div>
<div class="block invoice">
    <h1> </h1>
    <div class="row">
        <div class="col-md-10">
            <?php
            $clstr = '';
            if (isset($this->classes[$class]))
            {
                    $clstr = ' For ' . $this->classes[$class];
            }
            else
            {
                    $clstr = '';
            }
            ?>
            <h3>Fee Extras   Report <?php echo $clstr; ?></h3>
        </div>
    </div>
    <table cellpadding="0" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th width="3%">#</th>
                <th width="20%">Name</th>
                <th width="20%">Amount</th>
                <th width="8%"></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;
            $fsum = 0;
            $tsum = 0;
            foreach ($roster as $kl => $specs)
            {
                    $cname = isset($this->classes[$kl]) ? $this->classes[$kl] : ' ';
                    /*  ?>
                      <tr>
                      <td> </td>
                      <td colspan="3" ><strong><?php echo $cname; ?>  </strong></td>
                      </tr>
                      <?php */
                    foreach ($specs as $ky => $det)
                    {
                            $s = (object) $det;
                            $i++;
                            $stu = $this->worker->get_student($ky);
                            $ism = 0;
                            ?>
                            <tr>
                                <td><?php echo $i . '. '; ?></td>
                                <td><?php echo $stu->first_name . ' ' . $stu->last_name; ?> </td>
                                <td>
                                    <table class="tablex">
                                        <?php
                                        foreach ($det as $fee_ids)
                                        {
                                                //$sm++;
                                                $d = (object) $fee_ids;
                                                $fsum += $d->amount;
                                                $ism += $d->amount;
                                                ?>
                                                <tr>
                                                    <td class="wits"><?php echo isset($list[$d->fee_id]) ? $list[$d->fee_id] : ' - '; ?></td>
                                                    <td><?php echo number_format($d->amount, 2); ?></td>
                                                </tr>                                            
                                        <?php } ?>
                                    </table>
                                </td>
                                <td><?php echo number_format($ism, 2); ?></td>
                            </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="2" > </td>
                        <td class="rttb"><strong><?php echo $cname; ?> Totals:  </strong></td>
                        <td class="rttb"> <strong><?php echo number_format($fsum, 2); ?></strong></td>
                    </tr>
                    <?php
                    $i = 0;
                    $tsum += $fsum;
                    $fsum = 0;
            }
            if (count($roster) > 1)
            {
                    ?>
                    <tr>
                        <td colspan="2" > </td>
                        <td>&nbsp;</td>
                        <td> </td>
                    </tr>
                    <tr>
                        <td colspan="2" > </td>
                        <td class="rttbd"><?php echo $fstr; ?> Totals: </td>
                        <td class="rttbd"><?php echo number_format($tsum, 2); ?></td>
                    </tr>
            <?php } ?>
        </tbody>
    </table>
    <div class="row">
        <div class="col-md-9"></div>
        <div class="col-md-3"> </div>
    </div>
</div>
<style>
    .tablex{width: 100%; border:0 !important;}
    .tablex td{ border-right: 0 !important; padding: 1px;}
    .tablex td.wits{width: 50%;}
    .tablex tr:last-child td{  border-bottom: 0 !important;}
    .tablex tr:last-child td{  border-bottom: 0 !important;}
    @media print
    {
        .tablex{margin-top: -2px !important;}
        table td{padding:2px !important;}
        .tablex{width: 100%; border:0 !important;}
        .tablex td{ border-right: 0 !important; padding: 1px;}
        .tablex td.wits{width: 50%;}
        .tablex tr:last-child td{  border-bottom: 0 !important;}
        .tablex tr:last-child td{  border-bottom: 0 !important;}
    }
</style>
<script>
        $(document).ready(
                function ()
                {
                    $(".tsel").select2({'placeholder': 'Please Select', 'width': '220px'});
                    $(".tsel").on("change", function (e)
                    {
                        notify('Select', 'Value changed: ' + e.added.text);
                    });

                    $(".fsel").select2({'placeholder': 'Please Select', 'width': '100px'});
                    $(".fsel").on("change", function (e)
                    {
                        notify('Select', 'Value changed: ' + e.added.text);
                    });
                });
</script>