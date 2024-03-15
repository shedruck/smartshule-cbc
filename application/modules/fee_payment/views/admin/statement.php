<div class="  right" id="menus"> 
    <a href="" onClick="window.print();
            return false" class="btn btn-primary"><i class="icos-printer"></i> Print</a>
    <a href="<?php echo site_url('admin/fee_payment/create/1'); ?>" class="btn btn-primary"><i class="glyphicon glyphicon-file"></i> New Payment</a>
    <a href="<?php echo site_url('admin/fee_payment/'); ?>" class="btn btn-primary"><i class="glyphicon glyphicon-list"></i> List Fee Statements</a>
    <a href="<?php echo site_url('admin/admission/view/' . $post->id); ?>" class="btn btn-success"><i class="glyphicon glyphicon-eye-open"></i> View <?php echo $post->first_name; ?>'s Profile</a>
</div>

 

<div class="widget">
    <div class="col-md-12 slip">
        <div class="statement">
            <div class="block invoice slip-content">
                <div class="row">
                    <div class="col-sm-3 invoice-left">
                        <img  src="<?php echo base_url('uploads/files/' . $this->school->document); ?>" class="center" align="center" style="" width="100%" height="120" />
                    </div>
                    <div class="col-sm-3 invoice-left">
                        <h4>&nbsp;</h4>                            
                    </div>
                    <div class="col-md-6 invoice-right">
                        <h4>STUDENT FEE STATEMENT</h4>
                        <?php $stream = $this->ion_auth->get_stream(); ?>
                        <strong>Date:</strong> <?php echo date('d M, Y H:i', time()); ?>
                        <br>
                        <strong>Student:</strong> <?php echo $post->first_name . ' ' . $post->middle_name.' '.$post->last_name; ?> - 
                        <?php
                        $clas = isset($cl[$class->class]) ? $cl[$class->class] : ' - ';
                        $fclas = isset($cl[$class->class]) ? class_to_short($clas) : ' - ';
                        $str = isset($stream[$class->stream]) ? $stream[$class->stream] : '  ';
                        echo $fclas . ' ' . $str;
                        ?>
                        <br>
                        <strong>Reg. Number:</strong>  <?php
                        echo $post->admission_number ? $post->admission_number : $post->old_adm_no;
                        ?>                        
                    </div>
                </div>
                <?php
                $ibal = $arrs;
                ksort($payload);
                foreach ($payload as $y => $p):
                    ksort($p);
                    ?>
                    <div class="border-dark">
                        <table class="fless">
                            <tr>
                                <td colspan="2">
                                    <span class="highlight">  <strong>Year: <span><?php echo $y; ?></span> </strong> </span>
                                    <span><button type="button" class="btn btn-default yx"> <i class="glyphicon glyphicon-chevron-right"></i></button> </span>
                                </td>
                            </tr>
                        </table>
                        <?php
                        foreach ($p as $term => $trans)
                        {
                            ?>
                            <div class="cz border-dark">
                                <table class="nob " width="100%" > 
                                    <tr>
                                        <td width="59%" style="border:0 !important;">
                                            <b><?php echo $this->terms[$term]; ?></b>
                                            <span><button type="button" class="btn btn-default tx"> <i class="glyphicon glyphicon-chevron-right"></i></button> </span>
                                        </td>
                                        <td width="41%"  style="border:0 !important;" class="rttx">Balance Brought Forward: <b><?php echo number_format($ibal, 2); ?></b></td>
                                    </tr>
                                </table>
                                <table cellpadding="0" cellspacing="0" width="100%" class="stt" style="margin-bottom: 6px;">
                                    <thead>
                                        <tr>
                                            <th width="3%">#</th>
                                            <th width="14%">Date</th>
                                            <th width="14%">Ref No</th>
                                            <th width="28%">Description</th>
                                            <th width="13%">Debit</th>
                                            <th width="13%">Credit</th>
                                            <th width="15%">Balance</th>
                                        </tr>
                                    </thead>
 
                                    <tbody> 
                                        <?php


                                        $i = 0;
                                        $dr = 0;
                                        $cr = 0;
                                        $wv = 0;
                                        $idw = 0;
                                        $exc = 0;
                                        $exw = 0;
                                        foreach ($trans as $type => $paidd)
                                        {
                                            $exs = 0;
                                            sort_by_field($paidd, 'date');
                                            foreach ($paidd as $paid)
                                            {
                                                $paid = (object) $paid;
                                                $debit = $type == 'Debit' || $type == 'Transport' ? $paid->amount : 0;
                                                $credit = $type == 'Credit' ? $paid->amount : 0;
                                                if ($debit)
                                                {
                                                    $idw = $paid->date;
                                                }
                                                $waiver = $type == 'Waivers' || $type == 'Discount' ? $paid->amount : 0;
                                                $bw = 0;
                                                $bcg = 0;
                                                if (isset($paid->ex_type))
                                                {
                                                    $wva = $paid->ex_type == 2 ? $paid->amount : 0;
                                                    $cg = $paid->ex_type == 1 ? $paid->amount : 0;
                                                    $exc += $cg;
                                                    $bcg += $cg;
                                                    $exw += $wva;
                                                    $bw += $wva;
                                                }
                                                $dr += $debit;
                                                $cr += $credit;
                                                $wv += $waiver;
                                                $bal = ($debit + $bcg) - ($credit + $waiver + $bw);
                                                $ibal += $bal;
                                                $i++;
                                                ?><tr>
                                                    <td><?php echo $i . '. '; ?></td>
                                                    <td><?php
                                                        if ($idw)
                                                        {
                                                            $wdate = date('d/m/Y', $idw);
                                                        }
                                                        else
                                                        {
                                                            $wdate = isset($this->terms[$term]) ? $this->terms[$term] : '';
                                                        }
                                                        $tdate = $paid->date > 0 ? date('d/m/Y', $paid->date) : $paid->date;
                                                        echo $waiver ? $wdate : $tdate;
                                                        ?>
                                                    </td>
                                                    <td><?php echo $paid->refno ? $paid->refno : gen_string(); ?></td>
                                                    <td>
                                                        <?php
                                                        $mess = ucwords($paid->desc);
                                                        if (is_numeric($mess) && $mess == 0)
                                                            $mess = 'Tuition Fee Payment';
                                                        elseif (is_numeric($mess))
                                                            $mess = isset($extras[$mess]) ? $extras[$mess] : ' - ';
                                                        $wwv = $paid->desc ? 'Waiver - ' . $paid->desc : 'Fee Waiver';
                                                        if($type == 'Discount')
                                                        {
                                                          $wwv = $paid->desc;  
                                                        }
                                                        
                                                        echo $waiver ? $wwv : rtrim($mess, ' -');
                                                        ?>
                                                    </td>
                                                    <td class="rttx"><?php
                                                        if ($bcg)
                                                        {
                                                            echo number_format($bcg, 2);
                                                        }
                                                        else
                                                        {
                                                            echo number_format($debit, 2);
                                                        }
                                                        ?></td>
                                                    <td class="rttx"><?php
                                                        if ($waiver)
                                                        {
                                                            echo number_format($waiver, 2);
                                                        }
                                                        elseif ($bw)
                                                        {
                                                            echo number_format($bw, 2);
                                                        }
                                                        else
                                                        {
                                                            echo number_format($credit, 2);
                                                        }
                                                        ?></td>
                                                    <td class="rttx"><?php echo number_format($ibal, 2); ?></td>
                                                </tr>
                                            <?php } ?>
                                        <?php } ?>
                                        <tr style="border-bottom:3px #000 double;  ">
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td class="rttb"><b>TOTALS</b></td>
                                            <td class="rttb"><?php echo number_format($dr + $exc, 2); ?></td>
                                            <td class="rttb"><?php echo number_format($cr + $wv + $exw, 2); ?></td>
                                            <td class="rttb"><?php echo number_format($ibal, 2); ?></td>
                                        <tr>
                                    </tbody>
                                </table>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <?php
                endforeach;

               // die;
                ?>
                <div class="row">
                    <div class="col-md-6"></div>
                    <div class="col-md-6">
                        <div class="total"> 
                            <?php if ($ibal < 0): ?>
                                <span class="highlight">
                                    <strong><span>Overpay:</span> <?php echo $this->currency; ?> <?php echo number_format($ibal, 2); ?>                                        <em></em>
                                    </strong>
                                </span>
                            <?php else: ?>
                                <span class="highlight">
                                    <strong><span>Balance:</span> <?php echo $this->currency; ?> <?php echo number_format($ibal, 2); ?>                                             <em></em>
                                    </strong>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer">
                <div class="col-sm-12">
                </div>
                <div class="center" style="border-top:1px solid #ccc">      
                    <span class="center" style="font-size:0.8em !important;text-align:center !important; border-top:1px solid #ccc;">
                        <?php
                        if (!empty($this->school->tel))
                        {
                            echo $this->school->postal_addr . ' Tel:' . $this->school->tel . ' ' . $this->school->cell;
                        }
                        else
                        {
                            echo $this->school->postal_addr . ' Cell:' . $this->school->cell;
                        }
                        ?></span>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function ()
    {
        $(".yx").click(function ()
        {
            $(this).closest("table.fless").toggleClass('hidden-print');
            $(this).closest("table.fless").parent().find('.cz').slideToggle("slow");
        });
        $(".tx").click(function ()
        {
            $(this).closest("table.nob").toggleClass('hidden-print');
            $(this).children("i").toggleClass('glyphicon-chevron-right');
            $(this).children("i").toggleClass('glyphicon-chevron-down');
            
            $(this).closest("table.nob").next('.stt').slideToggle(100,"linear");
           });
    });
</script>
<style>
    .btn {border: 0 !important;}
    /*.yx, .tx{display: none;}*/
    .cz{ margin-top: 2px;}
    .fless{width:100%; border:0; }
    @media print{
        .yx, .tx{display: none;}
       #scrollUp{display: none;}
        td.nob{  border:none !important; background-color:#fff !important;}
        .stt td, th {
            border: 1px solid #ccc;
        } 
        table tr{
            border:1px solid #666 !important;
        }
        table th{
            border:1px solid #666 !important;
        }
        table td{
            border:1px solid #666 !important;
        }   
     }
</style>
