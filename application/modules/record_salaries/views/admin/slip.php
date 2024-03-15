<?php
$refNo = refNo();
$settings = $this->ion_auth->settings();
?>
<div class="col-md-12 buttons-hide">
    <div class="col-md-4"></div>
    <div class="col-md-4">
        <div class="right print">
            <button onClick="window.print();
                        return false" class="btn btn-primary" type="button"><span class="glyphicon glyphicon-print"></span> Print </button>
                    <?php
                    if ($this->ion_auth->is_in_group($this->user->id, 3))
                    {
                            ?>
                            <?php
                    }
                    else
                    {
                            ?>
                            <?php echo anchor('admin/record_salaries', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => ' Salaries')), 'class="btn btn-primary"'); ?> 
                    <?php } ?>
        </div>
    </div>
    <div class="col-md-4"></div>
</div>
<div class="col-md-1"></div>
<div class="slip col-md-10">
    <div class="slip-content">
        <div class="row">
            <div class="col-md-12 view-title ">
                <span class="center">
                    <h6 class="center" style="font-size:1.5em;">
                        <img  src="<?php echo base_url('uploads/files/' . $this->school->document); ?>" class="center"  style="margin-right:10px;" width="80" height="80" /><br>
                        <?php echo $this->school->school; ?><br>
                        Payslip For The Period Of <abbr title="Date"  ><?php echo $post->month . ' ' . $post->year; ?></abbr>
                    </h6>
                </span>
                <?php
                $st = $this->ion_auth->get_user($post->employee);
                ?>
                <div class="row">
                    <div class="col-sm-4">
                        <address>
                            <strong>Employee: </strong><?php echo $st->first_name . ' ' . $st->last_name; ?><br>
                            <abbr title="Phone"><b>P: </b></abbr><?php echo $st->phone; ?><br>
                            <abbr title="Email"><b>E: </b></abbr><?php echo $st->email; ?><br>
                        </address>
                    </div>
                    <div class="col-sm-4">
                        <address>
                            <strong>EMP ID: </strong><?php
                            $zero = '';
                            if ($st->id < 100)
                            {
                                    $zero = '0';
                            }
                            echo $this->adm_prefix . '' . $zero . $st->id
                            ?><br>
                            EMP Date: <?php echo date('d M Y', $st->created_on); ?><br>
                            Salary Type: <?php echo $post->salary_method; ?><br>
                        </address>                                
                    </div>
                    <div class="col-sm-4">
                        <br>
                        <strong>Date:</strong> <?php echo date('l d F, Y', $post->salary_date); ?>
                        <br>
                        <div class="highlight">
                            <strong>Basic Salary: </strong><?php echo number_format($post->basic_salary, 2); ?> <em><?php echo $this->currency; ?></em>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <table width="100%" >
                <tr>
                    <td> <b> Earnings </b><div class="right"><b style="margin-right:10px;"> Amount (<?php echo $this->currency; ?>)</b> </div></td>
                    <td> <b> Deductions  </b><div class="right"><b style="margin-right:10px;"> Amount (<?php echo $this->currency; ?>)</b></div> </td>
                </tr>
                <tr>
                    <td>
                        <div class="inner_items">
                            <div class="item">
                                Basic Salary
                                <div class="right"><?php echo number_format($post->basic_salary, 2); ?></div>
                            </div>
                            <?php
                            $alsum = 0;
                            if (!empty($post->allowances)):
                                    ?>
                                    <?php
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
                                Taxable Pay : <?php echo number_format(($post->basic_salary + $alsum) - $post->nssf, 2);
                            ?>
                                <div class="right">
                                    <table class="fless" border="0">
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
            <br>
            <div class="row">
                <div class="col-sm-6">
                    <b style="border-bottom:1px solid #ccc"> Amount in words: </b>
                    <?php
                    $net = ($t_earnings - $t_deductions);
                    $words = convert_number_to_words($net);
                    echo ucwords($words);
                    ?> Ksh.
                </div>
                <div class="col-sm-6">
                    <div class="right" ><br>
                        <strong><span class="bold"> Net Pay: </span></strong>
                        <span class="kes" style="border-bottom:1px solid #ccc">
                            <?php echo $this->currency; ?> <?php echo number_format($net, 2); ?>  </span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <br>
                    <br>
                    <strong style="border-top:1px solid #000"> Employee Signature: </strong>
                </div>
                <div class="col-sm-6">
                    <br>
                    <br>
                    <strong class="right" style="border-top:1px solid #000"> Official Signature: </strong>
                </div>
            </div>
            <div class="center" style="border-top:1px solid #ccc">		
                <span class="center" style="font-size:0.8em !important;text-align:center !important;"><?php echo $settings->postal_addr . ' Tel: ' . $settings->tel . ' Cell: ' . $settings->cell ?></span>
            </div>
        </div>
    </div>
</div> 
<style>
    .fless{width:100%; }
    .fless td,  .fless th{padding: 2px 8px; }
    .bold{
        font-weight:bold;
    }
    @media print{
        .buttons-hide{
            display:none !important;
        } 
        .right{
            float:right;
        }
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
        .navigation{
            display:none;
        }
        .alert{
            display:none;
        }
        .alert-success{
            display:none;
        }
        .img{
            align:center !important;
        } 
        .print{
            display:none !important;
        }
        .bank{
            float:right;
        }
        .view-title h1{border:none !important; text-align:center }
        .view-title h3{border:none !important; }
        .split{
            float:left;
        }
        .header{display:none}
        .invoice { 
            width:100%;
            margin: auto !important;
            padding: 0px !important;
        }
        .invoice table{padding-left: 0; margin-left: 0; }
        .smf .content {
            margin-left: 0px;
        }
        .content {
            margin-left: 0px;
            padding: 0px;
        }
    }
</style>