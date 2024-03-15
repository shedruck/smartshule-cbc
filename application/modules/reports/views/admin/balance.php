<div class="head">
    <div class="icon">
        <span class="icosg-target1"></span></div>
    <h2>Fee Status Report</h2>
    <div class="right">   
        <a href="" onClick="window.print(); return false" class="btn btn-primary"><i class="icos-printer"></i> Print</a>
    </div>    					
</div>
<div class="toolbar">
<div class="block-fluid col-md-12">
    <?php echo form_open(current_url()); ?>
                <div class='form-group col-md-5'>
                    <div class="col-md-3">Minimum Balance<span class='required'>*</span></div>
                    <div class="col-md-9">
                        <?php
                        $bals = array(
                            '999999' => 'Any Balance',
                            '1000' => '1,000',
                            '2000' => '2,000',
                            '5000' => '5,000',
                            '8000' => '8,000',
                            '10000' => '10,000',
                            '12000' => '12,000',
                            '15000' => '15,000',
                            '18000' => '18,000',
                            '20000' => '20,000',
                            '25000' => '25,000',
                            '30000' => '30,000',
                            '35000' => '35,000',
                            '40000' => '40,000',
                            '45000' => '45,000',
                            '50000' => '50,000',
                            '60000' => '60,000',
                            '80000' => '80,000',
                            '100000' => '100,000'
                        );
                        echo form_dropdown('min', array('' => '') + $bals, '', ' class="select" data-placeholder="Select Minimum Balance" ');
                        echo form_error('min');
                        ?>
                    </div>
                </div>

                <div class='form-group col-md-5'>
                    <div class="col-md-3">Maximum Balance</div>
                    <div class="col-md-9">
                        <?php
                        $max = array(
                            '0' => 'Select Maximum Balance',
                            '10000' => '10,000',
                            '12000' => '12,000',
                            '15000' => '15,000',
                            '18000' => '18,000',
                            '20000' => '20,000',
                            '25000' => '25,000',
                            '30000' => '30,000',
                            '35000' => '35,000',
                            '40000' => '40,000',
                            '45000' => '45,000',
                            '50000' => '50,000',
                            '60000' => '60,000',
                            '80000' => '80,000',
                            '100000' => '100,000'
                        );
                        echo form_dropdown('max', $max, '', ' class="select" data-placeholder="Select Maximum Balance" ');
                        echo form_error('max');
                        ?>
                    </div>
                </div>
                <div class="form-group col-md-2">
                    <button class="btn btn-xs btn-success">Filter</button>
                </div>
                <?php echo form_close()?>
                <div class="clearfix"></div>
            </div>
    <div class="noof">
        <div class="col-md-1">&nbsp;</div>
        <div class="col-md-9"><?php echo form_open(current_url()); ?>
            Include Suspended<input type="checkbox" name="sus" value="1"/>
            <button class="btn btn-primary"  type="submit">Submit</button>
            <?php echo form_close(); ?>
        </div>
        <div class="col-md-2"> 
        </div>
    </div>
</div>
<div class="block invoice">
    <h1> </h1>
    <div class="row">
        <div class="col-md-10">
            <h3><?php echo $this->school->school; ?>  Fee Status Report  -  <?php echo date('d M Y'); ?></h3>
        </div>
    </div>
    <table cellpadding="0" cellspacing="0" width="100%" class="nob">
        <thead>
            <tr>
                <th width="3%">#</th>
                <th width="20%">Name</th>
                <th width="10%">Class</th>
                <th width="11%">ADM</th>
                <th width="15%">Invoiced Amt.</th>
                <th width="15%">Paid</th>
                <th width="15%">Overall Balance</th>
            </tr>
        </thead>
        <tbody>
            <?php
            ksort($fee);
            $i = 0;
            $s = 0;
            $fbal = 0;
            $fpaid = 0;
            foreach ($fee as $kl => $strpecs)
            {
                    $cname = isset($this->classes[$kl]) ? $this->classes[$kl] : ' ';
                    foreach ($strpecs as $str => $kids)
                    {
                            $ivs = 0;
                            $pds = 0;
                            $bal = 0;
                            $kstr = isset($str_opts[$str]) ? $str_opts[$str] : ' &nbsp;';
                            ?>
                            <tr>
                                <td> </td>
                                <td colspan="6"><strong><?php echo $cname . ' ' . $kstr; ?></strong></td>
                            </tr>
                            <?php
                            foreach ($kids as $kid)
                            {
                                    $i++;
                                    $s++;
                                    $ivs += $kid->invoice_amt;
                                    $pds += $kid->paid;
                                    $bal += $kid->balance > 0 ? $kid->balance : 0;
                                    $stu = $this->worker->get_student($kid->id);
                                    ?> 
                                    <tr>
                                        <td><?php echo $i . '. '; ?></td>
                                        <td><?php echo $stu->first_name . ' ' . $stu->last_name; ?> </td>
                                        <td ><?php echo $cname . ' ' . $kstr; ?></td>
                                        <td><?php echo $stu->old_adm_no ? $stu->old_adm_no : $stu->admission_number; ?></td>
                                        <td class="rttb"> <?php echo number_format($kid->invoice_amt, 2); ?></td>
                                        <td class="rttb"> <?php echo number_format($kid->paid, 2); ?></td>
                                        <td class="rttb"><?php echo number_format($kid->balance, 2); ?> </td>
                                    </tr>
                                    <?php
                            }
                            ?>
                            <tr class="rttbt">
                                <td colspan="2" > </td>
                                <td colspan="2"><?php echo $cname; ?> Totals:</td>
                                <td class="rttb"><?php echo number_format($ivs, 2); ?></td>
                                <td class="rttb"><?php echo number_format($pds, 2); ?></td>
                                <td class="rttb"><?php echo number_format($bal, 2); ?></td>
                            </tr>
                            <?php
                            $i = 0;
                            $fbal += $bal;
                            $fpaid += $pds;
                    }
            }
            ?>
            <tr>
                <td colspan="5" > </td>
                <td >&nbsp; </td>
                <td></td>
            </tr>
            <tr>
                <td colspan="2" > </td>
                <td colspan="2"  class="rttbd">  </td>
                <td class="rttbd"><?php //echo number_format($fpaid, 2); ?></td>
                <td class="rttbd">  Overall Balance: </td>
                <td class="rttbd"><?php echo number_format($fbal, 2); ?></td>
            </tr>
            <tr>
                <td colspan="5" > </td>
                <td >&nbsp; </td>
                <td></td>
            </tr>
            <tr>
                <td> </td>
                <td> </td>
                <td  colspan="3" ><small>Total Students: <?php echo number_format($s); ?></small></td>
                <td colspan="2" ><small> Date: <?php echo date('d M Y H:i:s'); ?></small></td>
            </tr>

        </tbody>
    </table>

    <div class="row">
        <div class="col-md-9"></div>
        <div class="col-md-3"> </div>
    </div>

</div>
