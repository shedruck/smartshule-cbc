<?php $settings = $this->ion_auth->settings(); ?> 
<div class="widget">
    <div class="col-md-12">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <div class="right print">
                <button onClick="window.print();
                        return false" class="btn btn-primary" type="button"><span class="glyphicon glyphicon-print"></span> Print </button>
                        <?php echo anchor('admin/record_sales', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Sales Records')), 'class="btn btn-primary"'); ?>
            </div>
        </div>
        <div class="col-md-4"></div>
    </div>
    <div class="clear"></div>
    <div class="col-md-2"></div>
    <div class="slip col-md-8">
      <div class="slip-content">
        <div class="row">

            <div class="col-md-12 view-title ">
			   <span class="left">
			     <h1 ><img  src="<?php echo base_url('uploads/files/' . $settings->document); ?>" width="80" height="80" /></h1>
			</span>
                <span class="center">
                    <h6>OFFICIAL RECEIPT</h6>
                  
                </span>

                <span class="date">
                   
                    <span class="right">RECEIPT. <abbr style="padding:10px; color:red; font-size:2em !important" >
                            <?php
                            if ($rec->id < 100)
                            {
                                echo '# 0' . $rec->id;
                            }
                            else
                            {
                                echo '# '.$rec->id;
                            }
                            ?>
                        </abbr></span>
                </span>
                <div class="clear"></div>

                <?php
                $st = $this->ion_auth->list_student($rec->student);
                ?>	 
                <div class="col-md-12">

                    <b>Received From:</b>
                    <abbr title="Name" style="margin-left:20px;" ><?php echo $st->first_name . ' ' . $st->last_name; ?> </abbr>
                    <span class="">
                        <b> &nbsp;&nbsp;Of &nbsp;&nbsp;</b>
                        <abbr title="Stream"><?php echo $class; ?></abbr>
                    </span>	
                    <br>
                    <b>Registration Number:</b>
                    <abbr title="ADM NO." ><?php
                        if (!empty($st->old_adm_no))
                        {
                            echo $st->old_adm_no;
                        }
                        else
                        {
                            echo $st->admission_number;
                        }
                        ?></abbr>

                    <span class="right">
                        DATE: <abbr title="Date" style="margin-left:20px;" ><?php echo date('d M, Y H:i'); ?></abbr>
                    </span>
                </div>
                <div class="clear"></div>
                <br>
                <b>Amount paid in words:</b>
                <abbr title="ADM Date"><?php
                    $words = convert_number_to_words($rec->total);
                    echo ucwords($words);
                    ?></abbr> Kenya shillings only

            </div>

        </div>

      
        <table cellpadding="0" cellspacing="0" width="100%" class="receipt">
            <thead>
                <tr>
                    <th width="3%">#</th>
                    <th width="">Sales Date</th>
                    <th width="">Item</th>
                    <th width="">Quantity</th>
                    <th width="">Unit Price</th>
                    <th width="">Method</th>
                    <th width="">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                foreach ($sales as $p):

                    $user = $this->ion_auth->get_user($p->created_by);
                    $i++;
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo date('d/m/Y', $p->sales_date); ?></td>
                        <td><?php echo $items[$p->item_id]; ?></td>
                        <td><?php echo $p->quantity; ?></td>
                      
                        <td><?php echo number_format($p->unit_price,2); ?></td>
						  <td><?php echo $p->payment_method; ?></td>
                        <td class="rttb"><?php echo number_format($p->total, 2); ?></td>
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
                        <td></td>
                    </tr>

                  
                <?php endif; ?>
                <tr>
                    <td> </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="rttx" style="border-bottom:3px #000 double;  "><b>Total: <?php echo $this->currency;?></b></td>
                    <td class="rttb" style="border-bottom:3px #000 double;  "><?php echo number_format($rec->total, 2); ?></td>
                </tr> 
            </tbody>
        </table>

        <div class="row">
            <div class="col-md-6">
			  <br>
                    <br>
			<b>Processed By:</b> <?php echo $user->first_name.' '.$user->last_name;?>
			</div>
            <div class="col-md-6">
               
            </div>

        </div>
        <div class="">
            <div class="center" style="border-top:1px solid #ccc">		
                <span class="center" style="font-size:0.8em !important;text-align:center !important;">
				<?php if(!empty($settings->tel)){
					echo $settings->postal_addr . ' Tel:' . $settings->tel . ' Cell:' . $settings->cell;
				}
				else{
				  echo $settings->postal_addr . ' Cell:' . $settings->cell;
				} ?></span>
            </div>
        </div>
    </div>

</div>
</div>

<div class="col-md-2"></div>


<style>
    @media print{

        .col-md-4 {
width: 200px !important;
float: left !important;
}
.right{
float:right;

}
.bold{
font-weight:bold;
font-size:1.5em;
color:#000;
}
.kes{
color:#000;
font-weight:bold;
}
.item{
padding:3px;
}
.col-md-3 {
width: 200px !important;
float: left !important;
}
.col-md-6 {
width: 300px !important;
float: left !important;
}
.col-md-2 {
width: 150px !important;
float: left !important;
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
