

<?php
    $settings = $this->ion_auth->settings();
    $st = $this->ion_auth->list_student($post->reg_no);
?>
<div class="widget slip-widget" >
    <div class="col-md-12 buttons-hide">
	
	<div class="col-md-4">
	
		   <button onClick="view(<?php echo $id; ?>);" class="btn btn-primary btn-lg" type="button"><span class="glyphicon glyphicon-print"></span> Print Option 1 </button>
						  	  
		 <a href="<?php echo base_url('admin/fee_payment/receipt_option2/'.$r_id); ?>"  class="btn btn-info btn-lg" type="button"><span class="glyphicon glyphicon-print"></span> Print Option 2 </a>
		 
	</div>
	<div class="col-md-8">
            <div class="right print">
              
						   
						   
						  <?php echo anchor("admin/fee_payment/email_receipt/".$r_id, "<i class='glyphicon glyphicon-envelope'>
                </i> Email Parent", "class='btn btn-warning submit' id='submit'"); ?>
				
                        <?php echo anchor("admin/fee_payment/statement/" . $post->reg_no, "<i class='glyphicon glyphicon-list'>
                </i> View " . $st->first_name . "'s Statement", "class='btn btn-primary'"); ?>

                        <?php echo anchor('admin/fee_payment/create', '<i class="glyphicon glyphicon-list">
                </i> New Payments', 'class="btn btn-primary"'); ?>
                        <?php echo anchor('admin/fee_payment', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Payments')), 'class="btn btn-primary"'); ?>
            </div>
        </div>
		
		
       
    </div>
    <div class="col-md-1"></div>
    <div class="slip col-md-10">
        <div class="slip-content">
            <div class="row">
                <div class="col-sm-3 invoice-left">
                    <img  src="<?php echo base_url('uploads/files/' . $settings->document); ?>" class="center" align="center" style="" width="50" height="50" />
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
                <div class="col-sm-5">
                    <strong>Received From:</strong> <span><?php echo $st->first_name . ' ' . $st->last_name; ?> </span>
                    <span>-<?php echo $class; ?></span>
                </div>
                <div class="col-sm-5">
                    <span><strong>Amt in words : </strong> 
                        Ksh. <?php
                            $words = convert_number_to_words($total->total);
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
<div class="col-md-1"></div>



<div id="rcc" ></div>

<script>
    function view(id)
    {
        $('#rcc').show();
        $('#rcc').dialog({position: "top", "width": 450, draggable: false});
        $('#rcc').dialog('open');
        $('#rcc').load(BASE_URL + 'admin/fee_payment/view_sale/' + id + '/?type=ajax');
		
    }
</script>

<style>
    @media print 
    {
        #receipt { width: 100% !important; margin: 15px  auto !important; text-align:center; color:#000; font-family: Arial, Helvetica, sans-serif; font-size:21px !important;  }
        #receipt img { max-width: 120px !important;     max-height: 295px !important;width: auto; }                            
        #receipt h3 { margin: 5px 0; }
        #receipt, #receipt .table td {font-size: 21px !important;}

        .left { width:100%; float:left; text-align:left; margin-bottom: 3px; }
        #receipt .table, .totals { width: 100%; margin:10px 0; }
        #receipt table { border:0!important;}
        #receipt table td{font-size: 21px !important; padding:0; border-left:0!important;border-right:0!important; border-top:1px solid #000; border-bottom:1px solid #000;}
        #receipt .table th { border-bottom: 1px solid #000; background:0; }
        .totals td { width: 24%; padding:0; }

        #receipt p {margin: 0 0 0px !important;}
        .ui-resizable-handle, .slip-widget { display: none !important;}
        #buttons { display: none; }
        #receipt { max-width: 100% !important; width: 100%; margin: 0 auto; }
        * {
            text-shadow: none !important;
            background: transparent !important;
            box-shadow: none !important;
        }
    }
    @media print 
    {
        #receipt{border:0 !important; margin:15px auto !important;}
        .ui-dialog
        {
            position: relative !important;
            margin:15px auto !important;
            left: 0 !important;
            width: 85% !important;
        }
        .ui-dialog .ui-dialog-content{
            border:0 !important; 
            overflow: visible;
        }
        .ui-dialog-titlebar, .ui-resizable-handle .ui-resizable-s{display:none !important;}

        .slip-widget , .buttons-hide
        {
            display:none !important;
        }
        .modal-content , .modal-dialog{border:0 !important;}
        .modal-body
        {
            min-height:100%;
            border:0!important;
        }
        .right
        {
            float:right;
        }

        .slip-widget{
            margin-top:0px;
        }
        .bold
        {
            font-weight:bold;
            font-size:1.5em;
            color:#000;
        }
        .<?php echo $this->currency; ?>{
            color:#000;
            font-weight:bold;
        }

    }
    #receipt { width: 280px; margin: 0 auto; text-align:center; color:#000; font-family: Arial, Helvetica, sans-serif; font-size:12px;  }
    #receipt img { max-width: 100px; width: auto; }                            
    #receipt h3 { margin: 5px 0; }
    .left { width:100%; float:left; text-align:left; margin-bottom: 3px; }
    #receipt .table, .totals { width: 100%; margin:10px 0; }
    #receipt table { border:0!important;}
    #receipt table td{padding:0; border-left:0!important;border-right:0!important; border-top:1px solid #000; border-bottom:1px solid #000;}
    #receipt .table th { border-bottom: 1px solid #000; background:0; }
    .totals td { width: 24%; padding:0; }
    .table td:nth-child(2) { overflow:hidden; }
    #receipt p {padding: 5px 10px !important;}


</style>     



   






