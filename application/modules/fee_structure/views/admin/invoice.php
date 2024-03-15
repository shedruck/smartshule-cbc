<?php
$range = range(date('Y') - 5, date('Y') + 2);
$yrs = array_combine($range, $range);
krsort($yrs);
?>
<div class="row actions">
    <div class="" id="menus">
        <center><h3>Generate Invoices </h3>	</center>
        <?php echo form_open(current_url()); ?>
        <div class='form-group'> 
        <div class="col-md-2">&nbsp; </div>		
            <div class="col-md-4">
                Select Class <br>
                <?php echo form_dropdown('class', array('' => '') + $this->classes, $this->input->post('class'), 'class="select"') ?> 
            </div>
            <div class="col-md-1">
               <h1> OR </h1>
            </div>
            <div class="col-md-4">
                Select Students
                <?php
                $students = $this->ion_auth->students_full_details();
                echo form_dropdown('students[]', $students, $this->input->post('students'), ' class="Qsel" multiple ');
                echo form_error('students');
                ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-2">&nbsp; </div>
            <div class="col-md-4">
                Term
                <?php
                echo form_dropdown('term', array('' => '') + $this->terms, $this->input->post('term'), ' class="tsel" placeholder="Select Term" ');
                echo form_error('term');
                ?>
            </div>
			 <div class="col-md-1">&nbsp; </div>
            <div class="col-md-4">
                Year
                <?php
                echo form_dropdown('year', array('' => '') + $yrs, $this->input->post('year') ? $this->input->post('year') : date('Y'), ' class="tsel" placeholder="Select Year" ');
                echo form_error('year');
                ?>
            </div>
        </div>
        <br>
		<center>
        <input type="checkbox" name="waiver" value="1"/> Include Fee Waiver
        <input type="checkbox" name="bal" value="1"/> Include Balance
		<hr>
        <button class="btn btn-warning" style="height:30px;" type="submit">View Invoice</button>
        <a href="" onClick="window.print();
                return false" class="btn btn-primary"><i class="icos-printer"></i> Print
        </a>
		</center>
        <?php echo form_close(); ?>
        <br>
        <br>
    </div>
</div>

<div class="widget">
    <?php
    if ($flag)
    {//************************multiple**/            
        foreach ($payload as $student => $row)
        {
            $bal = $row['bal'];
            $parent = $row['parent'];
            $post = $this->worker->get_student($student);
            $invoice = $row['invoice'];
            ?>
            <div class="slip">
                <div class="statement">
                    <div class="invoice slip-content">
                        <div class="row">
                        <center>
                            <div class="col-xs-3">
                                <img src="<?php echo base_url('uploads/files/' . $this->school->document); ?>" alt="" style="width: 80%;">
                            </div>
                            <div class="col-xs-8">
                                <h1><?php echo $this->school->school; ?></h1>
                                <br>
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
                            </center>
                        </div>
                        <div>
                            <div class="center">
                                <span class="center titles">STUDENT INVOICE  </span>
                                <hr>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-12">
                                <div class="col-md-10 ">
                                    <b style="font-size:15px">Student:</b>
                                    <abbr title="Name" style="font-size:15px" ><?php echo $post->first_name . ' ' . $post->middle_name. ' '.$post->last_name; ?> </abbr>
                                    <span class="right" style="font-size:15px">
                                        <b style="font-size:15px">Invoice No: </b>
                                        <?php echo date('m') . '/' . date('y') . '-' . $post->id; ?>
                                    </span>
                                    <br>
                                    <b style="font-size:15px">Class</b>:
                                    <abbr title="Stream" style="font-size:15px">
									<?php
									    $classes = $this->ion_auth->fetch_classes();
                                        echo $classes[$post->class];
                                        ?>
									</abbr>
                                    <span class="right" style="font-size:15px">
                                        <b>Invoice Date: </b>
                                        <?php echo date('d M Y', time()) ?>
                                    </span>	

                                    <br>
                                    <span style="font-size:15px" >
                                        <b>Admission No:</b>
                                        <?php
                                         
                                                echo $post->admission_number ?  $post->admission_number : $post->old_adm_no;
                                         
                                        ?>
                                    </span>			
                                    <hr>
                                </div>		  
                            </div>
                        </div>

                        <h5 class = "center titles">Termly School Fee Invoice.</h5>
                        <table cellpadding = "0" cellspacing = "0" width = "100%" class = "stt" style = "margin-bottom: 6px;">
                            <tr>
                                <th>#</th>
                                <th>Description</th>
                                <th>Amount (<?php echo $this->currency; ?>)</th>
                            </tr>
                            <?php
                            $i = 0;
                            $tot = 0;
                            $rem = 0;
                            $extra = 0;
                            $wvd = 0;
                            $trans = 0;
                            $arr = isset($bal->balance) ? $bal->balance : 0;
                            foreach ($invoice as $yr => $fees)
                            {
                                foreach ($fees as $term => $row)
                                {
                                    foreach ($row as $title => $specs)
                                    {
                                        if ($title === 'Extra' || $title === 'Uniform')
                                        {
                                            foreach ($specs as $dkey => $dspec)
                                            {
                                                $ds = (object) $dspec;
                                                $extra += $ds->amount;
                                            }
                                        }

                                        if ($title === 'Trans')
                                        {
                                            foreach ($specs as $dkey => $dspec)
                                            {
                                                $ds = (object) $dspec;
                                                $trans += $ds->amount;
                                            }
                                        }

                                        if ($title === 'Waivers')
                                        {
                                            foreach ($specs as $dkey => $dspec)
                                            {
                                                $ds = (object) $dspec;
                                                $wvd += $ds->amount;
                                            }
                                        }

                                        foreach ($specs as $key => $spec)
                                        {
                                            $s = (object) $spec;
                                            $tot += $title === 'Waivers' ? 0 : $s->amount;
                                            if ($title === 'Tuition')
                                            {
                                                $rem += $s->invoiced ? $s->amount : 0;
                                            }
                                            $i++;
                                            ?>
                                            <tr class="item-row">
                                                <td width="5%"><?php echo $i; ?>. </td>
                                                </td>
                                                <td class="description"> <?php echo $s->desc; ?>  </td>
                                                <td  width="25%" class="amt">
                                                    <?php
                                                    echo ($title === 'Waivers') ? '- ' : '';
                                                    echo number_format($s->amount, 2);
                                                    ?> </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                }
                            }
                            $ex = $extra + $trans;
                            $actual = ($has_wv ? ($arr + $wvd) - $ex : $arr - $ex) - $rem;
                            if ($has_wv)
                            {
                                $tot = $tot - $wvd;
                            }
                            ?>
                            <tr class="rttb" >
                                <td class="blank"> </td>
                                <td class="total-line"><b>Subtotal:</b></td>
                                <td class="amt"> <strong><?php echo number_format($tot, 2); ?></strong></td>
                            </tr>
                            <?php
                            if ($has_bal)
                            {
                                ?>
                                <tr class="rttb" >
                                    <td class="blank"> </td>
                                    <td class="total-line"><b>Current Fee Arrears: </b></td>
                                    <td class="amt"><strong><?php echo number_format($actual, 2); ?></strong></td>
                                </tr>
                            <?php } ?>
                            <tr class="rttb">
                                <td class="blank"> </td>
                                <td class="total-line balance"><b>Total Due: </b></td>
                                <td class="total-value balance amt" style="border-bottom:double"><strong>
                                        <?php echo $has_bal ? number_format(($tot + $actual), 2) : number_format(($tot), 2); ?></strong></td>
                            </tr>

                        </table>
                        <?php
                        if ($banks)
                        {
                            ?>
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
                            <h3 style="border:1px solid #ccc; text-align:center; background-color:#F5F5F5; "> Thank you for choosing <?php
                                $ss = $this->school;
                                echo $ss->school;
                                ?></h3>
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

            </div>
            <?php
        }
    }
    else
    {//single
        //*********** ****END PER STUDENT ********* ******************************///
        if (isset($post) && !empty($post))
        {
            ?>
            <div class="col-md-12 slip">

                <div class="statement">
                    <div class="block invoice slip-content">
                        <div>
                            <div class="center">
                                <h1><?php echo $this->school->school; ?></h1>
                                <br>
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
                                </span>
                                <br>
                                <br>
                                <span class="center titles">STUDENT INVOICE  </span>
                                <hr>
                            </div>

                            <div class="clearfix"></div>

                            <div class="col-md-12">
                                <div class="col-md-10 " style="font-size:15px">
                                    <b>Student:</b>
                                    <abbr title="Name" style="font-size:18px" ><?php echo $post->first_name . ' ' . $post->middle_name.' '.$post->last_name; ?> </abbr>
                                    <span class="right">
                                        <b>Invoice No.: </b>
                                        <?php
                                        echo date('m') . '/' . date('y') . '-' . $post->id;
                                        ?>
                                    </span>	

                                    <br>
                                    <b>Class</b>:
                                    <abbr title="Stream"><?php
                                        echo $classes_groups[$classes[$post->class]];
                                        ?></abbr>

                                    <span class="right">
                                        <b>Invoice Date: </b>
                                        <?php echo date('d M Y', time()) ?>
                                    </span>	

                                    <br>
                                    <span >
                                        <b>Registration Number:</b>
                                        <?php
                                        echo $post->admission_number ? $post->admission_number : $post->old_adm_no;
                                        ?>
                                    </span>			
                                    <hr>
                                </div>		  
                            </div>
                        </div>
                        <h5 class="center titles">Tuition and Extra Fees for Next term.</h5>
                        <table cellpadding="0" cellspacing="0" width="100%" class="stt" style="margin-bottom: 6px;">
                            <tr>
                                <th>#</th>
                                <th>Description</th>
                                <th>Amount (<?php echo $this->currency; ?>)</th>
                            </tr>
                            <?php
                            $i = 0;
                            $tot = 0;
                            $extra = 0;
                            $wvd = 0;
                            $trans = 0;
                            $rem = 0;
                            $arr = isset($bal->balance) ? $bal->balance : 0;
                            foreach ($payload as $yr => $fees)
                            {
                                foreach ($fees as $term => $row)
                                {
                                    foreach ($row as $title => $specs)
                                    {
                                        if ($title === 'Extra')
                                        {
                                            foreach ($specs as $dkey => $dspec)
                                            {
                                                $ds = (object) $dspec;
                                                $extra += $ds->amount;
                                            }
                                        }

                                        if ($title === 'Trans')
                                        {
                                            foreach ($specs as $dkey => $dspec)
                                            {
                                                $ds = (object) $dspec;
                                                $trans += $ds->amount;
                                            }
                                        }

                                        if ($title === 'Waivers')
                                        {
                                            foreach ($specs as $dkey => $dspec)
                                            {
                                                $ds = (object) $dspec;
                                                $wvd += $ds->amount;
                                            }
                                        }

                                        foreach ($specs as $key => $spec)
                                        {
                                            $s = (object) $spec;
                                            $tot += ($title === 'Waivers') ? 0 : $s->amount;
                                            if ($title === 'Tuition')
                                            {
                                                $rem += $s->invoiced ? $s->amount : 0;
                                            }
                                            if (($title === 'Waivers') && !$has_wv)
                                            {
                                                continue;
                                            }
                                            $i++;
                                            ?>
                                            <tr class="item-row">
                                                <td width="5%"><?php echo $i; ?>. </td>
                                                <td class="description"> <?php echo $s->desc; ?>   </td>
                                                <td  width="25%" class="amt">
                                                    <?php
                                                    echo ($title === 'Waivers') ? '- ' : '';
                                                    echo number_format($s->amount, 2);
                                                    ?> 
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                }
                            }
                            $ex = $extra + $trans;
                            $actual = ($has_wv ? ($arr + $wvd) - $ex : $arr - $ex) - $rem;
                            if ($has_wv)
                            {
                                $tot = $tot - $wvd;
                            }
                            ?>
                            <tr class="rttb">
                                <td class="blank"> </td>
                                <td class="total-line"><b>Subtotal: <?php echo $this->currency; ?></b></td>
                                <td class="amt"> <strong><?php echo number_format($tot, 2); ?></strong></td>
                            </tr>
                            <?php
                            if ($has_bal)
                            {
                                ?>
                                <tr class="rttb">
                                    <td class="blank"> </td>
                                    <td class="total-line"><b>Current Fee Arrears: </b></td>
                                    <td class="amt"><strong><?php echo number_format($actual, 2); ?></strong></td>
                                </tr>
                            <?php } ?>
                            <tr class="rttb">
                                <td class="blank"> </td>
                                <td class="total-line balance"><b>Total Due:</b></td>
                                <td class="total-value balance amt" style="border-bottom:double"><strong>
                                        <?php echo $has_bal ? number_format(($tot + $actual), 2) : number_format(($tot), 2); ?></strong></td>
                            </tr>

                        </table>
                        <?php
                        if ($banks)
                        {
                            ?>
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
                        </table>
                        <span style="width:400px">
                            <h3 style="border:1px solid #ccc; text-align:center; background-color:#F5F5F5; "> Thank you for choosing <?php
                                $ss = $this->school;
                                echo $ss->school;
                                ?></h3>
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

            </div>
            <?php
        }
        else
        {
            ?>

            <?php
        }
    }
    ?>

</div>
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

<script type="text/javascript">
    $(function ()
    {
        $(".tsel").select2({'placeholder': 'Please Select', 'width': '100%'});
        $(".Qsel").select2({'placeholder': 'Select Students', 'width': '100%'});
    });
</script>
