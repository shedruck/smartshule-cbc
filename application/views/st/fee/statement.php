<div class="row" id='x-acts' > 
    <div class=" pull-right" > 
        <a href="" onClick="window.print(); return false" class="btn btn-custom"><i class="icos-printer"></i> Print</a>
    </div>

	 <div class="col-md-12 text-center">
			<div class="image" >
				<img  src="<?php echo base_url('uploads/files/' . $this->school->document); ?>" class="center" align="center" style="" width="120" height="120" />    
			</div>
			<h4><?php echo ucwords($this->school->school); ?> 
			
		
				 <p>
				<?php
						if (!empty($this->school->tel))
						{
								echo $this->school->postal_addr . ' Tel:' . $this->school->tel . ' ' . $this->school->cell;
						}
						else
						{
								echo $this->school->postal_addr . ' Cell:' . $this->school->cell;
						}
				?>
				</p>
				<span class="center titles">STUDENT FEE STATEMENT AS AT: <?php echo date('d M, Y H:i', time()); ?>  </span>
				<hr>
			</h4>

		</div>

</div>


	

<div class="widget">
    <div class="col-md-12 slip">
	

        <div class="statement">
            <div class="table-responsive">
                <div class="block invoice slip-content">
                   
                    <?php
                    $stream = $this->ion_auth->get_stream();
                    ?>	
                    <div class="row">
                       
                        <div class="col-md-6">
                            <h4> <b>STUDENT NAME:</b>  <abbr><?php echo strtoupper(strtolower($post->first_name . ' ' . $post->last_name)); ?></abbr></h4>
                            <h4>
                                <abbr> <b>ADM No:  </b><?php
                                    if (!empty($post->old_adm_no))
                                    {
                                            echo $post->old_adm_no;
                                    }
                                    else
                                    {
                                            if ($post->admission_number)
                                            {
                                                    echo $post->admission_number;
                                            }
                                    }
                                    ?>       </abbr>
									
									 <span class="date"> <b>CLASS: </b>  <?php echo $this->student->cl->name; ?> </span>
                            </h4>
                           
                        </div>

                        <div class="col-md-6 ">
                            <div class="col-md-3">
                                <div class="top"><h4><?php echo number_format($summary->invoice_amt, 2); ?></h4></div>
                                <p class="text-muted m-0">Invoiced Amt</p>
                            </div>
                            <div class=" col-md-3">
                                <div class="top"><h4><?php echo number_format($summary->paid, 2); ?></h4></div>
                                <p class="text-muted m-0">Paid</p>
                            </div>
                            <div class="col-md-3">
                                <div class="top"><h4><?php echo number_format($summary->balance, 2); ?></h4></div>
                                <p class="text-muted">Total Balance</p>
                            </div> 
                            <div class="clearfix"></div>
                        </div>
						
						
                    </div>
					
					<hr>
					
                    <div class="clearfix"></div>
                    <?php
                    $ibal = $arrs;
                    ksort($payload);
                    foreach ($payload as $y => $p):
                            ksort($p);
                            ?>
                            <table class=" fless display" > 
                                <tr >
                                    <td colspan="2"><span class="highlight">  <strong>Year: <span><?php echo $y; ?></span>  </strong>  </span></td> 
                                </tr> 
                            </table>

                            <?php
                            foreach ($p as $term => $trans)
                            {
                                    ?>
                                    <table class="display"  width="100%" > 
                                        <tr>
                                            <td width="59%" style="border-top: 0 !important;border-bottom: 0 !important;"><b><?php echo $this->terms[$term]; ?></b></td> 
                                            <td width="41%"  style="border-top: 0 !important;border-bottom: 0 !important;" class="rttx">Balance Brought Forward: <b><?php echo number_format($ibal, 2); ?></b></td>
                                        </tr>
                                    </table>
									<table class="table stt display table-striped table-bordered">
                                   
                                        <thead>
                                            <tr>
                                                <th width="3%">#</th>
                                                <th width="10%">Date</th>
                                                <th width="14%">Ref No</th>
                                                <th width="32%">Description</th>
                                                <th width="13%">Debit</th>
                                                <th width="13%">Credit</th>
                                                <th width="15%">Balance</th>
                                            </tr>
                                        </thead>
                                        <tbody> <?php
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
                                                            $debit = $type == 'Debit' ? $paid->amount : 0;
                                                            $credit = $type == 'Credit' ? $paid->amount : 0;

                                                            if ($debit)
                                                            {
                                                                    $idw = $paid->date;
                                                            }
                                                            $waiver = $type == 'Waivers' ? $paid->amount : 0;
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
                                                                    {
                                                                            $mess = 'Fee Payment';
                                                                    }
                                                                    elseif (is_numeric($mess))
                                                                    {
                                                                            $mess = isset($extras[$mess]) ? $extras[$mess] : '';
                                                                    }
                                                                    $wwv = $paid->desc ? 'Waiver - ' . $paid->desc : 'Fee Waiver';

                                                                    echo $waiver ? $wwv : $mess;
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
                                    <?php
                            }
                            ?>
                            <?php
                    endforeach;
                    ?>
                    <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-6">
                            <div class="clearfix"></div>
                            <div class="pull-right">                        
                                <div class="total newrect"> 
                                    <span class="highlight">
                                        <strong><span>Balance: &nbsp;</span><?php echo number_format($ibal, 2); ?>  <?php echo ($ibal < 0) ? ' (Overpay)' : ''; ?>  <em></em></strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="foote">
                    <div class="center" >		
                        <span class="center" s>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .fless{width:100%; border:0;}
    @media print{
        td.nob{  border:none !important; background-color:#fff !important;}
    }
</style>