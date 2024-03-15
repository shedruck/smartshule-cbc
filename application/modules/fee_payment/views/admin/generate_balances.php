<div class="head">
    <div class="icon"><span class="icosg-target1"></span></div>
    <h2>Fee Arrears Report</h2> 
    <div class="right">                       
    </div>    					
</div>

<div class="toolbar">
    <div class="noof">
        <?php echo form_open(current_url()); ?>
        Suspended Only<input type="checkbox" name="sus" value="1"/>
        Class
        <?php echo form_dropdown('class', array('' => 'Select Class') + $streams, $this->input->post('class'), 'class ="tsel" '); ?>
        Term
        <?php echo form_dropdown('term', array('' => 'Select Term') + $this->terms, $this->input->post('term'), 'class ="fsel" '); ?>
        Year 
        <?php echo form_dropdown('year', array('' => 'Select Year') + $yrs, $this->input->post('year'), 'class ="fsel" '); ?>
        <button class="btn btn-primary"  type="submit">View Balances</button>
		 <a href="" onClick="window.print();
                    return false" class="btn btn-primary"><i class="icos-printer"></i> Print
        </a>
		
        <?php echo form_close(); ?>
    </div>
</div>
<div class="block1 " >

    <div class="row">
        <div class="col-md-10">
            <?php
            if ($class == '' || !$class)
            {
                    $clstr = ' For All Classes ';
            }
            elseif (isset($this->classes[$class]))
            {
                    $clstr = ' For ' . $this->classes[$class];
            }
            else
            {
                    $clstr = '';
            }

            if ($term == '' || !$term)
            {
                    $tstr = ' ';
            }
            elseif (isset($this->terms[$term]))
            {
                    $tstr = '  ' . $this->terms[$term];
            }
            else
            {
                    $tstr = '';
            }
            $ystr = '';
            if ($yr)
            {
                    $ystr = $yr;
            }
            ?>
            
        </div>
    </div>

            <?php
            $i = 0;
            $tsum = 0;
            $fsum = 0;
            $ovpay = 0;
            foreach ($rearr as $kl => $specs)
            {
                    $cname = isset($this->classes[$kl]) ? $this->classes[$kl] : ' ';
                    ?>
					
					 <?php
                    foreach ($specs as $ky => $det)
                    {
                            $s = (object) $det;
                            $i++;
                            $fsum += $s->amount > 0 ? $s->amount : 0;
                            $ovpay += $s->amount < 0 ? abs($s->amount) : 0;
                            $stu = $this->worker->get_student($s->student);
							
							if($s->amount <= 0){
								continue;
							}
                            ?>
                   <div class="slip" >
                        <div class="statement">
                            <div class="block invoice slip-content">
                                <div class="row row-fluid center">
                                   
                                    <div class="col-sm-12  invoice-left">
									 <img src="<?php echo base_url('uploads/files/' . $this->school->document); ?>" alt="" style="width: 15%;">
									 
                                        <h2><?php echo $this->school->school; ?></h2>
                                      
                                        <?php
                                        if (!empty($this->school->tel))
                                        {
                                                echo $this->school->postal_addr . '<br> Tel:' . $this->school->tel . ' ' . $this->school->cell;
                                        }
                                        else
                                        {
                                                echo $this->school->postal_addr . ' Cell:' . $this->school->cell;
                                        }
                                        ?>
                                    </div>
                                </div>
                               
                                </div>
								<h5>
								<p>Balance due <b><?php echo $this->school->currency.''.number_format($s->amount, 2); ?></b> </p>
                                 <br>
									<p>	Dear Parent/Guardian,</p>
									<br>

										<p style="line-height:25px">This is a reminder that your child <b><?php echo $stu->first_name . ' ' . $stu->middle_name . ' ' . $stu->last_name; ?></b> of  Admission Number:
                                               <b> <?php
                                                if (!empty($stu->old_adm_no))
                                                {
                                                        echo $stu->old_adm_no;
                                                }
                                                else
                                                {
                                                        if ($stu->admission_number)
                                                        {
                                                                echo $stu->admission_number;
                                                        }
                                                }
                                                ?></b>
Level/Class
                                       <b>     <?php
                                                echo $classes_groups[$classes[$stu->class]];
                                                ?></b>
												has a school fee balance of <b><?php echo $this->school->currency.''.number_format($s->amount, 2); ?></b> which is overdue. Kindly pay this amount today to avoid your child being locked out of school. If your have paid avoid this reminder.
										<p>

										<p>Thank you for your payment.</p>
										<br>

										<p>Sincerely,</p>
									
										<br>
										<img src="<?php //echo base_url('uploads/headteacher-signature.png')?>" width="70" >

										<p>School Accounts Dept</p>
									</h5>	

                                <?php
                                if ($banks)
                                {
                                        ?>
										<hr>
                                        <h5 style="width:100%; border-bottom:1px solid #000;">Bank(s) Details</h5>
                                        <table width="100%" border="0" style="border:none !important">
                                            <tr style="border:none !important">
                                                <th style="border:none !important" width="3%">#</th>
                                                <th style="border:none !important; text-align:left">Bank Name</th>
                                                <th style="border:none !important; text-align:left">Account Name</th>
                                                <th style="border:none !important;text-align:left ">Branch</th>
                                                <th style="border:none !important; text-align:left">Account No.</th>
                                            </tr>
                                            <?php
                                            $i = 0;
                                            foreach ($banks as $b)
                                            {
                                                    $i++;
                                                    ?>
                                                    <tr style="border:none !important">
                                                        <td style="border:none !important"><?php echo $i; ?></td>
                                                        <td style="border:none !important"><?php echo $b->bank_name ?></td>
                                                        <td style="border:none !important"><?php echo $b->account_name ?></td>
                                                        <td style="border:none !important"><?php echo $b->branch ?></td>
                                                        <td style="border:none !important"><?php echo $b->account_number ?></td>
                                                    </tr>
                                            <?php } ?>
                                    <?php } ?>
                                    <tr style="border:none !important">
                                        <td style="border:none !important"> </td>
                                        <td style="border:none !important">Mobile Payment</td>
                                        <td style="border:none !important"> </td>
                                        <td style="border:none !important" colspan="2"><?php echo $this->school->mobile_pay ?></td>
                                    </tr>
                                </table>

                                <span style="width:400px">
                                    <h4 style="border:1px solid #ccc; text-align:center; background-color:#F5F5F5; "> THANK YOU FOR CHOOSING  <?php
                                        $ss = $this->school;
                                        echo strtoupper($ss->school);
                                        ?></h4>
                                </span>

                            </div>
                            <div class="footer">
                                <div class="center" style="border-top:1px solid #ccc">		
                                    <span class="center" style="font-size:0.8em !important;text-align:center !important;">
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

                  
            <?php } ?>
			  </div>
                    <?php } ?>

  

    <div class="row">
        <div class="col-md-9"></div>
        <div class="col-md-3"> </div>
    </div>

</div>

<script>
        $(document).ready(
                function ()
                {
                    $(".tsel").select2({'placeholder': 'Please Select', 'width': '140px'});
                    $(".tsel").on("change", function (e) {

                        notify('Select', 'Value changed: ' + e.added.text);
                    });

                    $(".fsel").select2({'placeholder': 'Please Select', 'width': '100px'});
                    $(".fsel").on("change", function (e) {
                        console.log(e);
                        notify('Select', 'Value changed: ' + e.added.text);
                    });
                });
</script>


<style>
    .amt{text-align: right;}
    .fless{width:100%; border:0;}
    .slip {
        width: 21cm;
        min-height: 29.7cm;
        padding: 2cm;
        margin: 1cm auto;
        border: 1px #D3D3D3 solid;
        border-radius: 5px;
        background: white;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }
    @page {
        size: A4;
        margin: 0;
    }
    @media print{
        .slip{
            margin: 0;
            border: initial;
            border-radius: initial;
            width: initial;
            min-height: initial;
            box-shadow: initial;
            background: initial;
            page-break-after: always;   
        }
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
    .actions{background-color: #fff; padding: 8px}
</style>
