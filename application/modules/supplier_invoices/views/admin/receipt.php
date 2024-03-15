<?php
    $settings = $this->ion_auth->settings();
    
?>
<div class="widget slip-widget" >
    <div class="col-md-12 buttons-hide">
       
        <div class="col-md-7">
            <div class="print ">
                  <button onClick="window.print();
                          return false" class="btn btn-primary btn-lg right" type="button"><span class="glyphicon glyphicon-print"></span> Print Voucher </button>
                          <a href="<?php echo base_url('admin/supplier_invoices/paid_invoices')?>" class="btn btn-danger">Back</a>
						
            </div> 
        </div>
		
    </div>
    <div class="col-md-1"></div>
    <div class="slip col-md-10">
        <div class="slip-content">
            <div class="row">
                <div class="col-sm-3 invoice-left">
                    <img  src="<?php echo base_url('uploads/files/' . $settings->document); ?>" class="center" align="center" style="" width="50%" height="80" />
                </div>
                <div class="col-sm-5 text-center">
                    <h4><?php echo $settings->school; ?></h4>
                    <h3>PAYMENT VOUCHER</h3>
                    <?php
                        if (!empty($settings->tel))
                        {
                             echo $settings->postal_addr . '<br> Tel:' . $settings->tel . ' ' . $settings->cell;
                        }
                        else
                        {
                             echo $settings->postal_addr . ' Cell:' . $settings->cell;
                        }
                    ?> 
                </div>

                <div class="col-md-4 text-right">
                    <h4>VOUCHER NO.<span style=" color:red;"> <?php echo $receipt->ref; ?></span></h4>
                     
                    DATE: <span><?php echo date('d M, Y H:i', $receipt->created_on); ?></span>
                </div>
            </div>
            <div class="col-md-12" style="margin-bottom:5px;margin-top:5px;border-top: #eee solid 1px">
                <div class="col-sm-4">
                    <strong>Paid To:</strong> <span>
                        <?php
                            echo isset($suppliers[$receipt->invoice]) ? $suppliers[$receipt->invoice] : '';
                        ?>    
                    </span>
                    
                </div>
                <div class="col-sm-7">
                    <span><strong>Amt in words : </strong> 
                        Ksh. <?php
                            $words = convert_number_to_words($amount->total);
                            echo ucwords($words);
                        ?> only</span>
                </div>
            </div>
            <table cellpadding="0" cellspacing="0" width="100%" class="receipt">
                <thead>
                    <tr>
                        <th width="3%">#</th>
                        <th width="">Payment Date</th>
                        <th width="">Description</th>
                        <th width="">Transaction No.</th>
                        <th width="">Amount</th>
                    </tr>
                </thead>
                <tbody>
                     <?php
                         $i = 0;
                         foreach ($payments as $p):
                              $user = $this->ion_auth->get_user($p->created_by);
                              $i++;
                              $itm = isset($items[$p->item]) ? $items[$p->item] : '-';
                              ?>
                             <tr>
                                 <td><?php echo $i; ?></td>
                                 <td><?php echo date('d/m/Y', $p->created_on); ?></td>
                                 <td><?php echo ucwords($itm); ?></td>
                                 <td><?php echo ucwords($p->ref); ?></td>
                                 <td class="rttb"><?php echo number_format($p->amount, 2); ?></td>
                             </tr> 
                        <?php endforeach ?>
                    <?php if ($i < 2): ?>
                             <tr>
                                 <td><?php echo $i + 1; ?></td>
                                 <td></td>
                                 <td></td>
                                 <td></td>
                                 <td></td>
                                 <td></td>
                             </tr>
                        <?php endif; ?>
                    <tr>
                        <td> </td>
                        <td></td>
                        <td></td>
                        <td class="rttx" style="border-bottom:3px #000 double;  ">Total: <?php echo $this->currency; ?> </td>
                        <td class="rttb" style="border-bottom:3px #000 double;  "><?php echo number_format($amount->total, 2); ?></td>
                    </tr> 

                     <tr>
                        <td> </td>
                        <td></td>
                        <td></td>
                        <td class="rttx" style="border-bottom:3px #000 double;  ">Balance: <?php echo $this->currency; ?> </td>
                        <td class="rttb" style="border-bottom:3px #000 double;  "><?php 
                            $bal = isset($balance[$receipt->invoice]) ? $balance[$receipt->invoice] : '0';
                            echo number_format($bal); ?></td>
                    </tr>
                </tbody>
            </table>

            <div class="row" style="margin-top:6px;">
                <div class="col-sm-3">
                     <b>Bank: </b> <?php echo number_format($amount->total, 2); ?>
                </div>
                <div class="col-sm-3">
                    <b>Check No:</b> <?php echo $p->check_no?>
                </div>

                <div class="col-sm-6">
                    <b>Bank Account</b> <?php echo isset($banks[$p->bank]) ? $banks[$p->bank] : ''?>
                </div>
            </div>
            <br><br><br>
            <div class="row" style="margin-top:6px;">
                <div class="col-sm-4">
                     <b>Payment Authorised By</b><br>
                     Head Teacher ...................<br>
                     Date ...........................<br>

                </div>
                <div class="col-sm-4">
                </div>

                <div class="col-sm-4">
                    <b>Prepared By : </b>  <?php echo $user->first_name . ' ' . $user->last_name; ?><br>
                    Sign...........................<br>
                    Date: <?php echo date('dS M, Y', $p->created_on) ?>
                </div>
            </div>

            <table width="100%" class="receipt">
                <thead>
                    <tr>
                        <th>VOTEHEAD</th>
                        <th>AMOUNT</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <?php
                            $ex = isset($expense[$receipt->invoice]) ? $expense[$receipt->invoice] : '';
                            $account_id = isset($expense_categories[$ex]) ? $expense_categories[$ex] : '';
                            echo  isset($accounts[$account_id]) ? $accounts[$account_id] : '';
                            ?>
                        </td>

                        <td><?php echo $this->currency?> <?php echo number_format($amount->total, 2); ?></td>
                    </tr>

                    <tr>
                        <td></td>
                        <td><b><?php echo $this->currency?> <?php echo number_format($amount->total, 2); ?></b></td>
                    </tr>
                </tbody>
            </table>    
            <br>
            <div class="row" style="margin-top:6px;">
                <center>
                <p> Receipt for Cash/ Check Payment - Received sum of shillings <?php
                            $words = convert_number_to_words($amount->total);
                            echo $this->currency.' '. ucwords($words);?> Only</p>
                        </center>
            </div>

             <div class="row" style="margin-top:6px;">
                 <div class="col-sm-4">
                     <b>Signature of Recipient</b>......................<br>
                     <b>ID NO</b>......................<br>
                     <b>Date<b>......................<br>
                 </div>
             </div>



			
			
            <div class="">
                <div class="center" style="border-top:1px solid #ccc">		
                    <span class="center" style="font-size:0.8em !important;text-align:center !important;">
                         <?php
                             if (!empty($settings->tel))
                             {
                                  echo $settings->postal_addr . ' Tel:' . $settings->tel . ' ' . $settings->cell;
                             }
                             else
                             {
                                  echo $settings->postal_addr . ' Cell:' . $settings->cell;
                             }
                         ?></span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-1"></div>


<style>
    @media print{
         .buttons-hide{
              display:none !important;
         }
         .right{
              float:right;
         }
         table tr{
              border:1px solid #666 !important;
         }
         table th{
              border:1px solid #666 !important;
              padding:5px;
         }
         table td{
              border:1px solid #666 !important;
              padding:5px;
         }
         .slip-widget{
              margin-top:0px;
         }
         .bold{
              font-weight:bold;
              font-size:1.5em;
              color:#000;
         }
         .<?php echo $this->currency; ?>{
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
         .print{
              display:none !important;
         }
         .bank{
              float:right;
         }
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








