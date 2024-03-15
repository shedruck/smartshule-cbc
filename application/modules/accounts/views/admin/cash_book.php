<?php


$settings = $this->ion_auth->settings(); ?>          
<div class="col-md-12" style="background-color:white">
 

    <div class="widget">

        <div class=" invoice">

            <div class="widget">
                <div class="col-md-2"></div>
                 <?php echo form_open(current_url())?>
                 <div class="col-md-3 hidden-print">
                    Bank 
                 <?php
                      echo form_dropdown('bank_id', array('' => 'Select Bank Account') + $banks,' class="select"  ');
                ?>
                 </div>
                <div class = "col-md-6 pull-center hidden-print">
                   
                    <div class="col-md-4"> From<input type="text" name="from" class="datepicker" > </div>
                    <div class="col-md-4"> To<input type="text" name="to" class="datepicker" > </div><br>
                    <div class="col-md-2"><button class="btn btn-success" type="submit"><i class="glyphicon glyphicon-filter"></i></button></div>
                    <div class="col-md-2"><button class="btn btn-warning" type="button" onClick="window.print()"><i class="glyphicon glyphicon-print"></i></button></div>
                   
                </div>
                <?php echo form_close()?>

                <div class="col-md-12 view-title center">
                    <h1><img src="<?php echo base_url('uploads/files/' . $settings->document); ?>" width="80" height="80" />  </h1>	
                    <h5><?php echo ucwords($settings->school); ?>
                        <br>
                        <span style="font-size:0.7em !important"><?php echo $settings->motto; ?></span>
                    </h5>
                    
                    <h3 > 
                            <?php
                                if($this->input->post()){
                                    $from =  $this->input->post('from');
                                    $to = $this->input->post("to");
                                    $ba =  $this->input->post('bank_id');
                                    $bnk =  isset($banks[$ba]) ? $banks[$ba] : '';
                                    $bnnk = strtoupper($bnk);
                                    if($ba == "")
                                    {
                                        $bnnk ="ALL ACCOUNTS";
                                    }
                                    $title = "CASH BOOK BETWEEN $from  AND $to FOR $bnnk";
                                }else{
                                    $title = "CASH BOOK";
                                }
                                echo $title;
                            ?>    
                    </h3>
                    <div class="clearfix"></div>
                    <div>&nbsp;</div>
                </div>

                <div id="tabxx" >
               
                 
                    <table cellpadding="0" cellspacing="0" width="98%" class="table-condensed" style="margin: 15px auto; font-size:small; " >
                         <thead>
                             <tr>
                                 <th>#</th>
                                 <th>Transaction Date</th>
                                 <th>Bank</th>
                                 <th>Description</th>
                                 <th>Dr</th>
                                 <th>Cr</th>
                                 <td>Balance</td>
                             </tr>

                             <tbody>
                                 <?php
                                 	$index = 1;
                                 	$l_bal = 0;
                                    $current = 0;
                                    $drs = 0;
                                    $crs = 0;
                                 	foreach($transactions as $t)
                                 	{
                                 		$l_bal = $t['cr'];
                                 		$current +=  $t['dr'] ==0? $l_bal :  -$t['dr'] - $l_bal ;
                                        $drs += $t['dr'];
                                        $crs += $t['cr'];
                                 		 

                                 	?>
                                 <tr>
                                 	<td><?php echo $index; ?></td>
                                 	<td><?php echo date('dS M, Y',$t['date'])?></td>
                                 	<td><?php echo isset($banks[$t['bank_id']]) ? $banks[$t['bank_id']] : ''?></td>
                                 	<td><?php echo $t['transaction'] ?></td>
                                 	<td><?php echo number_format($t['dr'],2)?></td>
                                 	<td><?php echo number_format($t['cr'],2)?></td>
                                 	<td><?php echo number_format($current,2)?></td>
                                 </tr>

                                 <?php $index++; } ?>

                                 <tr>
                                     <td colspan="4"><h4>Totals</h4></td>
                                     <td><strong><?php echo number_format($drs,2)?></strong></td>
                                     <td><strong><?php echo number_format($crs,2)?></strong></td>
                                     <td><strong><?php echo number_format($crs - $drs,2)?></strong></td>
                                 </tr>

                                 
                             </tbody>
                         </thead>
                    </table>
                  
         
                     
                      
                          
               
                    <p>&nbsp; </p>
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

    a{
        text-decoration:none;
    }

   .bri{

   }

    



     
</style> 


