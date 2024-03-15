

	<div class="row1">
				<div class="card shadow-sm ctm-border-radius grow">
			<div class="card-header d-flex align-items-center justify-content-between">
				<h4 class="card-title mb-0 d-inline-block">Recent Payments</h4>
			 <button onClick="window.print(); return false" class="btn btn-primary btn-sm pull-right" type="button"><span class="glyphicon glyphicon-print"></span> Print Receipt </button>
			</div>

<?php
    $settings = $this->ion_auth->settings();
    $st = $this->ion_auth->list_student($post->reg_no);
?>
<div class="widget slip-widget" >
   

    <div class="slip col-md-12">
        <div class="slip-content">
            <div class="row">
                <div class="col-sm-3 invoice-left">
                    <img  src="<?php echo base_url('uploads/files/' . $settings->document); ?>" class="center" align="center" style="" width="50%"  />
                </div>
                <div class="col-sm-6 text-center">
                    <h4><?php echo $settings->school; ?></h4>
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
                <div class="col-md-3 text-right">
                    <h4>RECEIPT NO.<span style=" color:red;"> <?php echo $total->id; ?></span></h4>
                    <strong>Reg. Number: </strong> <?php
                        if (!empty($st->old_adm_no))
                        {
                             echo $st->old_adm_no;
                        }
                        else
                        {
                             echo $st->admission_number;
                        }
                    ?>
                    <br> 
                    DATE: <span><?php echo date('d M, Y H:i', time()); ?></span>
                </div>
            </div>
            <div class="col-md-12" style="margin-bottom:5px;margin-top:5px;border-top: #eee solid 1px">
                <div class="col-sm-12">
                    <b>Received From:</b> <span><?php echo $st->first_name . ' ' . $st->last_name; ?> </span>
                    <span>-<?php echo $class; ?></span>
                </div>
                <div class="col-sm-12">
                    <span><b>Amount in words : </b> 
                        Ksh. <?php
                            $words = convert_number_to_words($total->total);
                            echo ucwords($words);
                        ?> only</span>
                </div>
            </div>
             <table class="table bordered custom-table table-hover">
                <thead>
                    <tr>
                        <th width="3%">#</th>
                        <th width="">Payment Date</th>
                        <th width="">Description</th>
                        <th width="">Payment Method</th>
                        <th width="">Transaction No.</th>
                        <th width="">Amount</th>
                    </tr>
                </thead>
                <tbody>
                     <?php
                         $i = 0;
                         foreach ($p as $p):
                              $user = $this->ion_auth->get_user($p->created_by);
                              $i++;
                              ?>
                             <tr>
                                 <td><?php echo $i; ?></td>
                                 <td><?php echo date('d/m/Y', $p->payment_date); ?></td>
                                 <td><?php
                                      if ($p->description == 0)
                                           echo 'Tuition Fee Payment';
                                      elseif (is_numeric($p->description))
                                           echo $extras[$p->description];
                                      else
                                           echo $p->description;
                                      ?></td>
                                 <td><?php echo ucwords($p->payment_method); ?></td>
                                 <td><?php echo $p->transaction_no; ?></td>
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
                        <td></td>
                        <td class="rttx" style="border-bottom:3px #000 double;  ">Total: <?php echo $this->currency; ?> </td>
                        <td class="rttb" style="border-bottom:3px #000 double;  "><?php echo number_format($total->total, 2); ?></td>
                    </tr> 
                </tbody>
            </table>
            <div class="row" style="margin-top:6px;">
                <div class="col-sm-6">
                     <b>Processed By:</b> <?php echo $user->first_name . ' ' . $user->last_name; ?>
                </div>
                <div class="col-sm-6">
                    <div class="total">
                         <div class="text-right" style="border-bottom:1px solid #ccc">
                            Fee Balance:<?php echo $this->currency; ?> <span style="border-bottom:1px solid #ccc"> <b><?php echo number_format($fee->balance, 2); ?>  </b></span>
                        </div> 
                    </div>
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


</div>
</div>

<style>
    @media print{
         .buttons-hide{
              display:none !important;
         }

		 .quicklink-sidebar-menu{
              display:none !important;
         }
		 
		 .card-header{
              display:none !important;
         }
         .right{
              float:right;
         }
         table {
             width:100% !important;
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
              margin-top:100px;
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
