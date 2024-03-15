<?php $settings = $this->ion_auth->settings(); ?>          
<div class="col-md-12">

    <div class="widget">

        <div class="blocdk invoice">


            <div class="widget">
            <div class="col-md-3"></div>
                <div class = "col-md-6 pull-center hidden-print">
                    <?php echo form_open(current_url())?>
                    <div class="col-md-4"> From<input type="text" name="from" class="datepicker" > </div>
                    <div class="col-md-4"> To<input type="text" name="to" class="datepicker" > </div><br>
                    <div class="col-md-2"><button class="btn btn-success" type="submit"><i class="glyphicon glyphicon-filter"></i></button></div>
                    <div class="col-md-2"><button class="btn btn-warning" type="button" onClick="window.print()"><i class="glyphicon glyphicon-print"></i></button></div>
                    <?php echo form_close()?>
                </div>
                

                <div class="col-md-12 view-title center">
                    <h1><img src="<?php echo base_url('uploads/files/' . $settings->document); ?>" width="80" height="80" />  </h1>	
                    <h5><?php echo ucwords($settings->school); ?>
                        <br>
                        <span style="font-size:0.7em !important"><?php echo $settings->motto; ?></span>
                    </h5>
                    <h3> TRIAL BALANCE AS AT: <?php echo date('d M, Y', time()); ?> </h3>
                    <div class="clearfix"></div>
                    <div>&nbsp;</div>
                </div>

                <div id="tabxx">

                    <table cellpadding="0" cellspacing="0" width="70%" style="margin: 15px auto;">
                        <thead>
                            <tr>
                                <th width="43%">Account</th>
                                <th width="">Code</th>
                                <th width="">Debit</th>
                                <th width="">Credit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $cr = 0;
                            $dr = 0;

                            foreach ($accounts as $typ => $fins)
                            {
                                if (is_array($fins) && !empty($fins))
                                {
                                    ?>
                                    <tr>
                                        <td colspan="4"><strong><?php echo$typ; ?></strong></td>
                                    </tr>
                                    <?php
                                    foreach ($fins as $fk)
                                    {
                                        $k = (object) $fk;
                                        // if ($k->side)
                                        // {
                                        //     $cr += $k->balance;
                                        // }
                                        // else
                                        // {
                                        //     $dr += $k->balance;
                                        // }
                                        
                                        if(($k->code >=400) && ($k->code <600)){ 

                                        }else{
                                            // $cr += $
                                            // $dr += $k->dr;

                                        ?>
                                        
                                        <tr>
                                            <td><?php echo $k->account; ?></td>
                                            <td><?php echo $k->code; ?></td>
                                            <td class="rttx">
                                                <?php 
                                                $code = $k->code;
                                                 //dr
                                                 if($code =="600"){
                                                    echo number_format($bank->total,2);
                                                }else if($code =="610"){
                                                    $dr_acc_receivable = number_format($fee_payment->total + $other_revenue->total,2);
                                                    echo $dr_acc_receivable;
                                                }

                                                ?></td>
                                            <td class="rttx">
                                                <?php 
                                                   $code = $k->code;
                                                    //cr
                                                    if($code =="200"){
                                                        echo  number_format($fee_payment->total,2);
                                                    }else if($code == "260"){
                                                        echo number_format($other_revenue->total,2);
                                                    }else if($code == "610"){
                                                       
                                                        echo number_format($cr_acc_receivable->total,2);
                                                    }else if($code == "800"){
                                                        // echo number_format($acc_payable->total,2);
                                                    }
                                                ?>
                                            </td>
                                        </tr>
                                        <?php
                                        }
                                    }
                                }
                            }
                            ?>
                            <tr>
                                <td> </td>
                                <td> </td>
                                <td class="ctots"><?php echo number_format($bank->total + $fee_payment->total + $other_revenue->total, 2); ?></td>
                                <td class="ctots"><?php echo  number_format($fee_payment->total + $other_revenue->total + $cr_acc_receivable->total, 2); ?></td>
                            </tr>
                        </tbody>
                    </table>

                </div>

            </div>


        </div>

    </div>

</div>

<style>
    @media print{

        .navigation{
            display:none;
        }
        .head{
            display:none;
        }

        .tip{
            display:none !important;
        }
        .bank{
            float:right;
        }
        .view-title h1{border:none !important; }
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

