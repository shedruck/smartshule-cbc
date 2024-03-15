<div class="row">
    <div class="col-md-12">
        <div class="card recent-operations-card">
            <div class="card-block">  
                <div class="page-header">
                    <div class="page-block">
                        <div class="row align-items-center">
                           <div class="col-md-6">					  
                                <h4 class="m-b-10"> Fee Statement </h4>
                            </div>
                            <div class="col-md-6">
                                <div class="pull-right">
								 
                 <a href="" onClick="window.print();
                    return false" class="btn btn-success"><i class="icos-printer"></i> Print</a>
				
				<?php echo anchor( 'st#finance' , '<i class="fa fa-home">
                </i> Exit', 'class="btn btn-sm btn-danger"');?> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				<hr>
				
				
     <div class="block-fluid">
		  <?php $settings = $this->ion_auth->settings();?>
		  
  <div class="image text-center" >
			<img  src="<?php echo base_url('uploads/files/' . $settings->document); ?>" class="text-center" align="center" style="" width="120" height="120" />    
		</div>

                
				<h3 style="text-align: center;"><?php echo $settings->school;?></h3>
<ul style="text-align: center;">
<li><?php echo $settings->postal_addr;?></li>
</ul>
<p style="text-align: center;">Tel: <?php echo $settings->tel;?> <?php echo $settings->cell;?>&nbsp; &nbsp;&nbsp;&nbsp; Email: <?php echo $settings->email;?></p>
  <div class="image text-center" >
			<?php 
												
								 $photo = $this->student->photo ? $this->st_m->passport($this->student->photo) : 0;
									if ($photo)
									{
											$path = 'uploads/' . $photo->fpath . '/' . $photo->filename;
											
									}
									else
									{
											$path = image_path('avatar-blank.jpg');
									}
									

							?>
						
				<image src="<?php echo base_url($path); ?>" width="120" height="120" class="" alt="User-Profile-Image">  
				<p>&nbsp;</p>
				<div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">
						<table style="width: 100%;" border="1" class="profile-table profile-text" >
							   <tbody>


								  <tr class="profile-th">
									 <td width="187" class="">
										<p><strong>Student Name </strong></p>
									 </td>
									 <td width="450" class="bg-white">
										<p>
										<?php echo $this->student->first_name;?>
										<?php echo $this->student->middle_name;?>
										<?php echo $this->student->last_name;?>
										</p>
									 </td>
								  </tr>

								  <tr class="profile-th">
									 <td width="187" class="">
										<p><strong>Class </strong></p>
									 </td>
									 <td width="450" class="bg-white">
										<p><?php $cl = $this->ion_auth->fetch_classes(); echo $cl[$this->student->class];?></p>
									 </td>
								  </tr>

								  <tr class="profile-th">
									 <td width="187" class="">
										<p><strong>UPI Number </strong></p>
									 </td>
									 <td width="450" class="bg-white">
										<p><?php echo $this->student->upi_number;?></p>
									 </td>
								  </tr>
								  
							</tbody>	  
						</table>
               </div>
                 <div class="col-sm-3"></div>	
              </div>				 
		</div>
                    <?php
                    $ibal = $arrs;
                    ksort($payload);
                    foreach ($payload as $y => $p):
                            ksort($p);
                            ?>
                            <table class="fless display" > 
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
                                            <td width=""  style="border-top: 0 !important;border-bottom: 0 !important;" class="rttx pull-right">Balance Brought Forward: <b><?php echo number_format($ibal, 2); ?></b></td>
                                        </tr> 
                                    </table>
                                    <table width="100%" class="stt display table" style="margin-bottom: 6px; ">
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
                                                                <td class="text-center"><?php
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
                                                                <td class="text-center"><?php echo $paid->refno ? $paid->refno : gen_string(); ?></td>
                                                                <td class="text-center">
                                                                    <?php
                                                                    $mess = ucwords($paid->desc);
                                                                    if (is_numeric($mess) && $mess == 0)
                                                                            $mess = 'Tuition Fee Payment';
                                                                    elseif (is_numeric($mess))
                                                                            $mess = $extras[$mess];

                                                                    $wwv = $paid->desc ? 'Waiver - ' . $paid->desc : 'Fee Waiver';

                                                                    echo $waiver ? $wwv : $mess;
                                                                    ?>
                                                                </td>
                                                                <td class="rttx text-center"><?php
                                                                    if ($bcg)
                                                                    {
                                                                            echo number_format($bcg, 2);
                                                                    }
                                                                    else
                                                                    {
                                                                            echo number_format($debit, 2);
                                                                    }
                                                                    ?></td>
                                                                <td class="rttx text-center"><?php
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
                                                                <td class="rttx text-center"><?php echo number_format($ibal, 2); ?></td>
                                                            </tr>
                                                    <?php } ?>
                                            <?php } ?>
                                            <tr style="border-bottom:3px #000 double;  ">
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td class="rttb"><b>TOTALS</b></td>
                                                <td class="rttb text-center"><?php echo number_format($dr + $exc, 2); ?></td>
                                                <td class="rttb text-center"><?php echo number_format($cr + $wv + $exw, 2); ?></td>
                                                <td class="rttb text-center"><?php echo number_format($ibal, 2); ?></td>
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
             
            </div>
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
        .highlight{
            background-color:#000 !important;
            color:#fff !important;
        }
    }
</style>