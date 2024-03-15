<?php
$refNo = refNo();
$settings = $this->ion_auth->settings();
?>
<div class="middle">
    <div class="button tip" title="New Fee Statement">
        <a href="<?php echo site_url('admin/fee_payment/create/1'); ?>">
            <span class="icomg-file"></span>
            <span class="text">New Payment</span>
        </a>                    
    </div>                      
    <div class="button tip" title="Edit Statement">
        <a href="<?php echo site_url('admin/fee_payment/data_edit/' . $post->reg_no); ?>">
            <span class="icomg-pencil2"></span>
            <span class="text">Edit Statement</span>
        </a>                    
    </div> 
    <div class="button tip" title="List All Fee Statements">
        <a href="<?php echo site_url('admin/fee_payment/'); ?>">
            <span class="icomg-list"></span>
            <span class="text">List Fee Statements</span>
        </a>                    
    </div>                                         
    <div class="button tip" title="Print Statement">
        <a href="" onClick="window.print();
                return false">
            <span class="icomg-printer"></span>
            <span class="text">Print Statement</span>
        </a>                    
    </div> 
    <!--<div class="button tip" title="Download Statement">
        <a href="<?php //echo site_url('admin/fee_payment/pdf/' . $post->id);   ?>">
            <span class="icomg-download"></span>
            <span class="text">Download Statement</span>
        </a>                    
    </div> -->                                         
</div>

<div class="widget">

    <div class="block invoice">

        <div class="row">
            <div class="date right">F-<?php echo $refNo; ?>-<?php echo date('y', time()) . '-' . date('2', time()) . '-' . date('H', time()); ?></div>
            <div class="col-md-11 view-title ">
                <span class="center">
                    <h1><img src="<?php echo base_url('uploads/files/' . $settings->document); ?>" width="150" height="150" />
                        <h5><?php echo ucwords($settings->motto); ?>
                            <br>
                            <span style="font-size:0.6em !important"><?php echo $settings->postal_addr . '<br> Tel:' . $settings->tel . ' Cell:' . $settings->cell ?></span>
                        </h5>
                    </h1>
                </span>
                <h3> PAYMENT HISTORY DATED: <?php echo date('Y', time()); ?> ACADEMIC YEAR<BR> </h3>
                <span class="date">Date: <?php echo date('d M, Y H:i', time()); ?></span>
                <?php             
                $st = $this->ion_auth->list_student($post->reg_no);

                $cl = $this->ion_auth->list_classes();
                $stream = $this->ion_auth->get_stream();
                ?>	

                <div class="clearfix"></div>

                <div class="col-md-12">
                    <div class="col-md-1"></div>
                    <div class="col-md-10 ">
                        <b>Name of Student:</b>
                        <abbr title="Name" ><?php echo $st ? $st->first_name . ' ' . $st->last_name : ' '; ?> </abbr>
                        <span class="right">
                            <b>Registration Number:</b>
                            <?php
                            if ($st)
                            {
 
                                if (!empty($st->old_adm_no))
                                {
                                    echo $st->old_adm_no;
                                }
                                else
                                {
                                    if ($st->admission_number > 99)
                                    {
                                        echo $st->admission_number;
                                    }
                                    else
                                    {
                                        echo '0' . $st->admission_number;
                                    }
                                }
                            }
                            ?>

                        </span>	
                        <br>
                        <b>Class</b>:
                        <abbr title="Stream"><?php
                         if ($st)
                            {
                            $cc = isset($cl[$st->class]) ? $cl[$st->class] : ' ';
                            $stt = isset($stream[$st->stream]) ? $cl[$st->stream] : ' ';
                            echo $cc . ' ' . $stt;
                              }
                            ?></abbr>
                        <span class="right">
                            <b>Gender</b>: 
                            <abbr title="Gender"><?php
                             if ($st)
                            {
                                if ($st->gender == 1)
                                    echo 'Male';
                                else
                                    echo 'Female';
                              }   ?></abbr>
                        </span>
                        <br>
                        <b>Date of Admission</b>:
                        <abbr title="ADM Date"><?php echo $st?date('d M Y', $st->admission_date): ' '; ?></abbr>


                    </div>		  
                    <div class="col-md-1"></div>
                </div>

            </div>

        </div>

        <h3>Payment History</h3>	

        <table cellpadding="0" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th width="3%">#</th>
                    <th width="">Payment Date</th>
                    <th width="">Description</th>
                    <th width="">Payment Method</th>
                    <th width="">Transaction No.</th>
                    <th width="">Bank.</th>
                    <th width="">Amount</th>

                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                foreach ($post as $p):
                    $amt = $this->fee_payment_m->total_paid($p->reg_no);
                    $user = $this->ion_auth->get_user($p->created_by);

                    $i++;
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo date('d/m/Y', $p->payment_date); ?></td>
                        <td><?php echo $p->description; ?></td>
                        <td><?php echo $p->payment_method; ?></td>
                        <td><?php echo $p->transaction_no; ?></td>
                        <td><?php
                            if (!empty($p->bank_id))
                            {
                                echo $banks[$p->bank_id];
                            }
                            ?></td>
                        <td><?php echo number_format($p->amount, 2); ?></td>
                    </tr>
                <?php endforeach ?>
<?php if ($i < 5): ?>

                    <tr>
                        <td><?php echo $i + 1; ?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>

                        <td></td>
                    </tr>

                    <tr>
                        <td><?php echo $i + 2; ?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>

                        <td></td>
                    </tr>
                    <tr>
                        <td><?php echo $i + 3; ?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>

                        <td></td>
                    </tr>


<?php endif; ?>

            </tbody>
        </table>

        <div class="row">
            <div class="col-md-9"></div>
            <div class="col-md-3">
                <div class="total">

                    <div class="highlight">
                        <strong><span>Total:</span> <?php echo $this->currency;?>. <?php
                            $amt = $this->fee_payment_m->total_paid($post->reg_no);

                            echo number_format($amt->amount, 2);
                            ?>  <em></em></strong>
                    </div>
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

