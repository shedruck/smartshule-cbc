<div class="head hidden-print">
    <div class="icon"><span class="icosg-target1"></span></div>
    <h2>&nbsp;
        <div class="pull-right">
            <?php echo anchor('trs/account', '<i class="mdi mdi-reply"></i>Back', 'class="btn btn-primary"'); ?>
            <button onClick="window.print();
                        return false" class="btn btn-success" type="button"><span class="mdi mdi-printer"></span> Print </button>
        </div>    					
    </h2> 
</div>

<div class="row sliip">
    <div class="col-md-12">
        <div class="panel panel-default">
            <!-- <div class="panel-heading">
                <h4>Invoice</h4>
            </div> -->
            <div class="panel-body">
                <div class="clearfix">
                    <div class="pull-left">
                        <h3>
                            Payslip For The Period Of <strong   ><?php echo $post->month . ' ' . $post->year; ?> </strong>
                        </h3>
                    </div>
                    <div class="pull-right">
                        <h4>  </h4>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">

                        <div class="pull-left m-t-5">
                            <?php
                            $st = $this->ion_auth->get_user($post->employee);
                            ?>
                            <address>
                                <strong>Employee:</strong><br>
                                <?php echo $st->first_name . ' ' . $st->last_name; ?><br>
                                <?php echo $st->phone; ?><br>
                                <?php echo $st->email; ?>
                            </address>
                        </div>
                        <div class="pull-right m-t-5">
                            <span><?php echo $this->school->school; ?></span><br>
                            <span>P.O Box <?php echo $this->school->postal_addr; ?></span><br>
                            <span>Tel. <?php echo $this->school->cell; ?></span>
                        </div>
                    </div><!-- end col -->
                </div>
                <!-- end row -->
                <div class="m-h-10"></div>
                <div class="row">
                    <table class="table ">
                        <tr>
                            <th>Earnings (<?php echo $this->currency; ?>)</th>
                            <th> Deductions(<?php echo $this->currency; ?>)</th>
                        </tr>
                        <tr>
                            <td>
                                <div class="inner_items">
                                    <div class="item">
                                        Basic Salary
                                        <div class="right"><?php echo number_format($post->basic_salary, 2); ?></div>
                                    </div>
                                    <?php if (!empty($post->allowances)): ?>
                                            <?php
                                            $alsum = 0;
                                            $all = explode(',', $post->allowances);
                                            foreach ($all as $l):
                                                    $vals = explode(':', $l);
                                                    $alsum += $vals[1];
                                                    ?>
                                                    <div class="item">
                                                        <?php echo $vals[0]; ?>
                                                        <div class="right"> <?php echo number_format($vals[1], 2); ?></div>
                                                    </div>
                                            <?php endforeach; ?> 
                                    <?php endif; ?> 
                                </div>
                            </td>
                            <td>
                                <div class="inner_items">
                                    <div class="item">
                                        Taxable Pay: <?php echo number_format(($post->basic_salary + $alsum) - $post->nssf, 2);
                                    ?>
                                        <div class="right">
                                            <table class="fless table" border="0">
                                                <tr><th>From</th><th>To</th><th>Taxable Pay</th><th>Tax Rate</th><th>Tax Amt.</th></tr>
                                                <?php
                                                $relief = $this->school->relief;
                                                $e = 0;
                                                $poc_amt = 0;
                                                $wtx = 0;
                                                $taxable = ($post->basic_salary + $alsum) - $post->nssf;
                                                foreach ($ranges as $R)
                                                {
                                                        $e++;
                                                        $amt = $e == 1 ? $R->amount : $taxable - $poc_amt;
                                                        if ($e == 1 && $taxable < $R->amount)
                                                        {
                                                                $amt = $taxable;
                                                        }
                                                        if ($amt < 0)
                                                        {
                                                                $amt = 0;
                                                        }
                                                        if ($amt >= $R->amount)
                                                        {
                                                                $amt = $R->amount;
                                                        }
                                                        if ($e == count($ranges))
                                                        {
                                                                $amt = $taxable - $poc_amt;
                                                        }
                                                        $rtax = $amt * ($R->tax / 100);
                                                        $poc_amt += $amt;
                                                        $wtx += $rtax;
                                                        ?>
                                                        <tr>
                                                            <td><?php echo number_format($R->range_from); ?></td>
                                                            <td class="text-right"><?php echo $e == count($ranges) ? '- ' : number_format($R->range_to); ?></td>
                                                            <td class="text-right"><?php echo number_format($amt); ?></td>
                                                            <td class="text-right"><?php echo number_format($R->tax); ?>%</td>
                                                            <td class="text-right"><?php echo number_format($rtax, 1); ?></td>
                                                        </tr>
                                                <?php } ?>
                                                <tr>
                                                    <td colspan="2"></td>
                                                    <td colspan="2">PAYE before Relief</td>
                                                    <td class="text-right"><?php echo number_format($wtx, 2); ?></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2"></td>
                                                    <td colspan="2">Personal Relief</td>
                                                    <td class="text-right"><?php echo number_format($relief, 2); ?></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2"></td>
                                                    <td colspan="2">PAYE Due</td>
                                                    <td class="text-right bold"><?php echo $wtx > $relief ? number_format($wtx - $relief, 2) : 0; ?></td>
                                                </tr>
                                            </table>
                                            <div class="clearfix"></div>                                   
                                        </div>
                                    </div>
                                    <?php if (!empty($post->advance)): ?>
                                            <div class="item">
                                                Advance Salary
                                                <div class="right"><?php echo number_format($post->advance, 2); ?></div>
                                            </div>
                                    <?php endif; ?>
                                    <?php if (!empty($post->nhif)): ?>
                                            <div class="item">
                                                NHIF
                                                <div class="right"><?php echo number_format($post->nhif, 2); ?></div>
                                            </div>
                                    <?php endif; ?>
                                    <?php if (!empty($post->nssf)): ?>
                                            <div class="item">
                                                NSSF
                                                <div class="right"><?php echo number_format($post->nssf, 2); ?></div>
                                            </div>
                                    <?php endif; ?>
                                    <?php
                                    if (isset($post->staff_deduction) && !empty($post->staff_deduction))
                                    {
                                            ?>
                                            <div class="item">
                                                Staff Deduction
                                                <div class="right"><?php echo number_format($post->staff_deduction, 2); ?></div>
                                            </div>
                                    <?php } ?>

                                    <?php if (!empty($post->deductions)): ?>
                                            <?php
                                            $dec = explode(',', $post->deductions);
                                            foreach ($dec as $d):
                                                    $vals = explode(':', $d);
                                                    ?>
                                                    <div class="item">
                                                        <?php echo $vals[0]; ?>
                                                        <div class="right"> <?php echo number_format($vals[1], 2); ?></div>
                                                    </div>
                                            <?php endforeach; ?> 
                                    <?php endif; ?> 
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="item">
                                    <b>Total Earnings</b>
                                    <div class="right" style="border-bottom:1px solid #ccc">
                                        <?php
                                        $t_earnings = ($post->basic_salary + $post->total_allowance);
                                        echo number_format($t_earnings, 2);
                                        ?>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="item">
                                    <b>Total Deductions</b>
                                    <div class="right" style="border-bottom:1px solid #ccc">  <?php
                                        $minn = $wtx > $relief ? $wtx - $relief : 0;
                                        $t_deductions = ($post->advance + $minn + $post->total_deductions + $post->nhif + $post->nssf + $post->staff_deduction);
                                        echo number_format($t_deductions, 2);
                                        ?></div>
                                </div>	
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <div class="clearfix m-t-40">
                            <h5 class="small text-inverse font-600"> Amount in words:</h5>
                            <small>
                                <?php
                                $net = ($t_earnings - $t_deductions);
                                $words = convert_number_to_words($net);
                                echo ucwords($words);
                                ?> 
                            </small>
                        </div>
                    </div>
                    <br>

                    <div class="col-md-3 col-sm-6 col-xs-6 col-md-offset-3">
                        <p class="text-right"><b>Net Pay:</b></p>
                        <h3 class="text-right"> <?php echo $this->currency; ?> <?php echo number_format($net, 2); ?></h3>
                        <hr>
                    </div>
                </div>                
            </div>
            <div class="center" style="border-top:1px solid #ccc">		
                <span class="center" style="font-size:0.8em !important;text-align:center !important;"><?php echo $this->school->school . ' ' . $this->school->postal_addr . ' Tel: ' . $this->school->tel . ' Cell: ' . $this->school->cell ?></span>
            </div>
        </div>

    </div>

</div>
<style>
    .center{text-align: center;}
    .fless{width:100%; }
    .fless td,  .fless th{padding: 2px 8px; }
    .bold{
        font-weight:bold;
    }
    .inner_items {
        min-height: 60px;
    }
    .right {
        margin-right: 20px;
    }

    .right {
        float: right;
    }
    @media print{
        .sliip{margin: 20px;}
        .buttons-hide{
            display:none !important;
        } 
        .right{
            float:right;
        }
        .center{text-align: center;}
        .bold{
            font-weight:bold;
            color:#000;
        }
        .kes{
            color:#000;
            font-weight:bold;
        }
        .item{
            padding:3px;
        } 
    }
</style>