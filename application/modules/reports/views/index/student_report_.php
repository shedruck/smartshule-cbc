<div class="head">
    <div class="  right" id="menus"> 
        <div class="col-sm-6">
            <?php echo form_open('reports/student_report/'); ?> 
            <?php echo form_dropdown('student', array('' => 'Select Student') + $kids, $this->input->post('student'), 'class="form-control"'); ?>
            <button class="btn btn-warning pull-right"  style="" type="submit">View Report</button>
        </div>
        <div class="col-sm-6">
            <a href="" onClick="window.print();
                        return false" class="btn btn-primary pull-right"><i class="icos-printer"></i> Print</a>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<?php $settings = $this->ion_auth->settings(); ?>
<div class="widget">
    <div class="col-sm-12 slip">
        <div class="statement">
            <div class="block invoice slip-content">
                <?php
                if (isset($student) && !empty($student))
                {
                        ?>
                        <div >
                            <div class="center">
                                <hr>
                                <h4> <abbr><?php echo ucwords($student->first_name . ' ' . $student->last_name); ?> </abbr></h4>
                                <span> ADM NO. <?php
                                    if (!empty($student->old_adm_no))
                                            echo $student->old_adm_no;
                                    else
                                            echo $student->admission_number;
                                    ?></span> |   <span>Admission Date: <?php echo $student->admission_date > 10000 ? date('M, d, Y', $student->admission_date) : ' - '; ?></span>
                                <br>
                                <b>Birthday:</b> <?php echo $student->dob > 1000 ? date('d M Y', $student->dob) : ''; ?> | 
                                <b>Gender:</b> <?php
                                if ($student->gender == 1)
                                        echo 'Male';
                                else
                                        echo 'Female';
                                ?>
                                <br>
                                <b>Student Email</b> <?php echo $student->email; ?> 
                                <hr>
                            </div>

                            <?php
                            $stream = $this->ion_auth->get_stream();
                            ?>	
                            <div class="clearfix"></div>

                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="col-sm-4">
                                    <h4>Admission Details</h4>
                                    <?php
                                    $class = $this->ion_auth->list_classes();
                                    $stream = $this->ion_auth->get_stream();
                                    $u = $this->ion_auth->get_user($student->created_by);
                                    ?>
                                    <p><strong>Class:</strong> <?php
                                        $cls = isset($class[$cl->class]) ? $class[$cl->class] : ' -';
                                        $strm = isset($stream[$cl->stream]) ? $stream[$cl->stream] : ' -';
                                        if (!$cl->stream == 1)
                                        {
                                                echo $cls . ' ' . $strm;
                                        }
                                        else
                                        {
                                                echo $cls;
                                        }
                                        ?></p>

                                    <p><strong>Admitted By:</strong> <?php echo $u->first_name . ' ' . $u->last_name; ?></p>
                                    <p><strong>Admitted On:</strong> <?php echo $student->admission_date > 10000 ? date('M, d, Y', $student->admission_date) : ' - '; ?></p>
                                    <p> <b><abbr title="House">House:</abbr></b> <?php
                                        $hse = $this->ion_auth->list_house();
                                        if ($student->house && isset($hse[$student->house]))
                                                echo $hse[$student->house];
                                        ?>
                                    </p>
                                </div>

                                <div class="col-sm-4">
                                    <h4>Other Details</h4>
                                    <b>Residence: </b><?php echo $student->residence; ?><br>
                                    <b>Former School:</b> <?php echo $student->former_school; ?><br>
                                    <b>Entry Marks:</b> <?php echo $student->entry_marks; ?><br>
                                    <b>Allergies:</b> <?php echo $student->allergies; ?>.<br>
                                    <b>Doctor:</b> <?php echo $student->doctor_name; ?>.<br>
                                    <b>Dr. Phone:</b> <?php echo $student->doctor_phone; ?>.<br>
                                    <br>
                                    <br>
                                </div>

                                <div class="col-sm-4">
                                    <h4>Payment Summary</h4>
                                    <div class="">
                                        <strong ><span >Fee Payable: </span>   </strong><?php
                                        if ($fee && $student->status)
                                        {
                                                echo number_format($fee->invoice_amt, 2);
                                        }
                                        else
                                        {
                                                echo '0.00';
                                        }
                                        ?>  <em></em>

                                    </div> 

                                    <div class=" ">
                                        <strong ><span>Total Paid: </span>  </strong><?php
                                        if (!empty($fee) && $student->status)
                                        {
                                                $amm = $fee->paid;
                                                if ($waiver)
                                                {
                                                        $amm = $fee->paid - $waiver;
                                                }
                                                echo number_format($amm, 2);
                                        }
                                        else
                                        {
                                                echo '0.00';
                                        }
                                        ?>
                                    </div>
                                    <!---WAIVER--->
                                    <?php if ($waiver && $student->status): ?>
                                            <div class=" ">
                                                <strong ><span>Fee Waived: </span>  </strong><?php echo number_format($waiver, 2); ?>  <em></em>
                                            </div>
                                    <?php endif ?>
                                    <div class="" style="border-bottom:double; border-top:1px solid #000;">
                                        <?php
                                        if (isset($fee) && isset($fee->balance))
                                        {
                                                if ($fee->balance > 0)
                                                {
                                                        echo '<span><strong >Fee Balance: </span> </strong>' . number_format($fee->balance, 2);
                                                }
                                                elseif ($fee->balance < 0)
                                                {
                                                        echo '<span><strong >Overpay </span>  </strong>' . number_format($fee->balance, 2);
                                                }
                                                elseif ($fee->balance == 0)
                                                {
                                                        echo '<span><strong>No Balance </span> </strong>' . number_format($fee->balance, 2);
                                                }
                                        }
                                        ?>   
                                    </div>
                                </div>
                            </div>
                            <!------------PARENTS DETAILS--------------------->
                            <div class="col-sm-12">

                                <span style="width:400px">
                                    <h3 style="border:1px solid #ccc; text-align:center; background-color:#F5F5F5; "> Parents Details</h3>
                                </span>
                                <div class="col-sm-6">
                                    <h4>Name: <?php echo $paro->first_name . ' ' . $paro->last_name ?></h4>
                                    <strong>Email:</strong> <?php echo $paro->email ?><br>
                                    <strong>Cell Phone:</strong><?php echo $paro->phone ?><br>
                                    <strong>Other Phone:</strong> <?php echo $paro->phone2 ?><br>
                                    <strong>Occupation:</strong><?php echo $paro->occupation ?><br>
                                    <strong>Address:</strong><?php echo $paro->address ?>
                                </div>
                                <div class="col-md-5">
                                    <h4>Name: <?php echo $paro->mother_fname . ' ' . $paro->mother_lname ?></h4>
                                    <strong>Email:</strong><?php echo $paro->mother_email ?><br>
                                    <strong>Cell Phone:</strong> <?php echo $paro->mother_phone ?><br>
                                    <strong>Other Phone:</strong> <?php echo $paro->mother_phone2 ?><br>
                                    <strong>Occupation:</strong><?php echo ''; ?><br>
                                    <strong>Address:</strong><?php echo $paro->address ?>
                                </div>
                            </div>
                            <!------------PAYMENT HISTORY--------------------->
                            <div class="col-sm-12">
                                <span style="width:400px">
                                    <h3 style="border:1px solid #ccc; text-align:center; background-color:#F5F5F5; "> Payment History</h3>
                                </span>
                                <?php if (!empty($p)): ?>
                                        <table width="100%" class="display">
                                            <thead>
                                                <tr>
                                                    <th width="3%">#</th>
                                                    <th width="">Date</th>
                                                    <th width="">Description</th>
                                                    <th width="">Method</th>
                                                    <th width="">Ref.</th>
                                                    <th width="">Bank</th>
                                                    <th width="">Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = 0;
                                                $ksum = 0;
                                                foreach ($p as $p):
                                                        $user = $this->ion_auth->get_user($p->created_by);
                                                        $i++;
                                                        $ksum += $p->amount;
                                                        $desc = $p->description;
                                                        if (is_numeric($p->description) && $p->description == 0)
                                                                $desc = 'Tuition Fee Payment';
                                                        elseif (is_numeric($p->description))
                                                                $desc = 'Fee Payment';
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $i; ?></td>
                                                            <td><?php echo date('d/m/Y', $p->payment_date); ?></td>
                                                            <td><?php echo $desc; ?></td>
                                                            <td><?php echo $p->payment_method; ?></td>
                                                            <td><?php echo $p->transaction_no; ?></td>
                                                            <td><?php
                                                                if (!empty($p->bank_id))
                                                                {
                                                                        echo isset($banks[$p->bank_id]) ? $banks[$p->bank_id] : ' ';
                                                                }
                                                                ?></td>
                                                            <td><?php echo number_format($p->amount, 2); ?></td>
                                                        </tr>
                                                <?php endforeach; ?>
                                                <tr style="border-bottom:3px #000 double;  ">
                                                    <td> </td>
                                                    <td> </td>
                                                    <td> </td>
                                                    <td> </td>
                                                    <td> </td>
                                                    <td class="rttb"> Total</td>
                                                    <td class="rttb"><?php echo number_format($ksum, 2); ?></td>
                                                </tr>
                                            </tbody>
                                        </table>                                        
                                <?php else: ?>
                                        <h5>No Payment has been recorded at the moment!!</h5>
                                <?php endif; ?>
                            </div>
                            <!------------Classes HISTORY--------------------->
                            <div class="col-sm-12">
                                <span style="width:400px">
                                    <h3 style="border:1px solid #ccc; text-align:center; background-color:#F5F5F5; "> Classes History</h3>
                                </span>
                                <table cellpadding="0" cellspacing="0" width="100%" class="display">
                                    <thead>
                                    <th width="3%">#</th>
                                    <th>Class</th>
                                    <th>Stream</th>
                                    <th>Year</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($class_history as $p):
                                                $i++;
                                                ?>
                                                <tr>
                                                    <td><?php echo $i . '.'; ?></td>	
                                                    <td><?php echo isset($classes_groups[$p->class]) ? $classes_groups[$p->class] : '-'; ?></td>
                                                    <td><?php echo isset($stream_name[$p->stream]) ? $stream_name[$p->stream] : '-'; ?></td>
                                                    <td><?php echo $p->year; ?></td>
                                                </tr>
                                        <?php endforeach ?>
                                    </tbody>

                                </table>
                            </div>
                            <!------------Leadership HISTORY--------------------->
                            <div class="col-sm-12">
                                <span style="width:400px">
                                    <h3 style="border:1px solid #ccc; text-align:center; background-color:#F5F5F5; "> Leadership Positions</h3>
                                </span>
                                <?php if ($position): ?> 
                                        <table cellpadding="0" cellspacing="0" width="100%" class="display">
                                            <thead>
                                            <th width="3%">#</th>
                                            <th>Position</th>	
                                            <th>Representing</th>	
                                            <th>Start Date</th>	
                                            <th>Date upto</th>	
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = 0;

                                                foreach ($position as $p):
                                                        $i++;

                                                        $class = $this->ion_auth->list_classes();
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $i . '.'; ?></td>	
                                                            <td><?php echo $st_pos[$p->position]; ?></td>
                                                            <td><?php
                                                                if ($p->student_class == "Others")
                                                                {
                                                                        echo 'Others';
                                                                }
                                                                else
                                                                {
                                                                        echo isset($class[$p->student_class]) ? $class[$p->student_class] : ' - ';
                                                                }
                                                                ?></td>
                                                            <td><?php echo date('d/m/Y', $p->start_date); ?></td>
                                                            <td width="30"><?php echo date('d/m/Y', $p->duration); ?></td>
                                                        </tr>
                                                <?php endforeach ?>
                                            </tbody>

                                        </table>

                                <?php else: ?>
                                        <p class='text'><?php echo lang('web_no_elements'); ?></p>
                                <?php endif ?>
                            </div>
                            <!------------Disciplinary HISTORY--------------------->
                            <div class="col-sm-12">
                                <span style="width:400px">
                                    <h3 style="border:1px solid #ccc; text-align:center; background-color:#F5F5F5; "> Disciplinary</h3>
                                </span>
                                <?php if ($disciplinary): ?>
                                        <table  cellpadding="0" cellspacing="0" width="100%" class="display">
                                            <thead>
                                            <th width="3%">#</th>
                                            <th>Reported on</th>
                                            <th>Reported By</th>
                                            <th>Reason</th>
                                            <th>Action Taken</th>
                                            <th>Taken On</th>
                                            <th>Comment</th> 
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = 0;

                                                foreach ($disciplinary as $p):
                                                        $i++;

                                                        $user = $this->ion_auth->get_user($p->reported_by);
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $i . '.'; ?></td>					
                                                            <td><?php echo date('d/m/Y', $p->date_reported); ?></td>
                                                            <td><?php
                                                                if (!empty($p->reported_by))
                                                                {
                                                                        echo $user->first_name . ' ' . $user->last_name;
                                                                }
                                                                else
                                                                {
                                                                        echo $p->others;
                                                                }
                                                                ?></td>
                                                            <td><?php echo substr($p->description, 0, 30) . '...'; ?></td>
                                                            <td>
                                                                <?php
                                                                if (isset($p->action_taken))
                                                                        echo $p->action_taken;
                                                                else
                                                                        echo '<i>Still Pending</i>';
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php if (isset($p->modified_on)) echo date('d/m/Y', $p->modified_on); ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $p->comment; ?>
                                                            </td> 
                                                        </tr>
                                                <?php endforeach ?>
                                            </tbody>

                                        </table>
                                <?php else: ?>
                                        <p class='text'><?php echo lang('web_no_elements'); ?></p>
                                <?php endif ?>
                            </div>
                            <!------------Medical HISTORY--------------------->
                            <div class="col-sm-12">
                                <span style="width:400px">
                                    <h3 style="border:1px solid #ccc; text-align:center; background-color:#F5F5F5; "> Medical Records</h3>
                                </span>
                                <?php if ($medical): ?>
                                        <table  cellpadding="0" cellspacing="0" width="100%" class="display">
                                            <thead>
                                            <th width="3%">#</th>
                                            <th>Date</th>
                                            <th>Sickness Reported</th>
                                            <th>Action Taken</th>
                                            <th>Comment</th>	
                                            <th>Recorded by</th>	
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = 0;

                                                foreach ($medical as $p):
                                                        $i++;

                                                        $u = $this->ion_auth->get_user($p->created_by);
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $i . '.'; ?></td>	
                                                            <td><?php echo date('d M Y', $p->date); ?></td>
                                                            <td><?php echo $p->sickness; ?></td>
                                                            <td><?php echo $p->action_taken; ?></td>
                                                            <td><?php echo $p->comment; ?></td>
                                                            <td><?php echo $u->first_name . ' ' . $u->last_name; ?></td>
                                                        </tr>
                                                <?php endforeach ?>
                                            </tbody>

                                        </table>
                                <?php else: ?>
                                        <p class='text'><?php echo lang('web_no_elements'); ?></p>
                                <?php endif ?>
                            </div>
                            <!------------Book Funds HISTORY--------------------->
                            <div class="col-sm-12">
                                <span style="width:400px">
                                    <h3 style="border:1px solid #ccc; text-align:center; background-color:#F5F5F5; "> Book Fund Status</h3>
                                </span>
                                <?php if ($student_books): ?>
                                        <table  cellpadding="0" cellspacing="0" width="100%" class="display">
                                            <thead>
                                            <th width="3%">#</th>
                                            <th>Book</th>
                                            <th>Borrowed Date</th>
                                            <th>Status</th>
                                            <th>Remarks</th>	
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = 0;

                                                foreach ($student_books as $p):
                                                        $i++;

                                                        $u = $this->ion_auth->get_user($p->created_by);
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $i . '.'; ?></td>	
                                                            <td><?php echo $books[$p->book]; ?></td>
                                                            <td><?php echo date('d/m/Y', $p->borrow_date); ?></td>
                                                            <td>
                                                                <?php
                                                                if ($p->status == 2)
                                                                {
                                                                        echo '<span style="color:green">Book Returned</span>';
                                                                }
                                                                elseif ($p->status == 1)
                                                                {
                                                                        echo '<span style="color:red">Not Returned</span>';
                                                                }
                                                                ?> </td>
                                                            <td><?php echo $p->remarks; ?></td>
                                                        </tr>
                                                <?php endforeach ?>
                                            </tbody>

                                        </table>
                                <?php else: ?>
                                        <p class='text'><?php echo lang('web_no_elements'); ?></p>
                                <?php endif ?>
                            </div>                            

                            <!--- END FLUID--->
                        </div>

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
                <?php
        }
        else
        {
                ?>

        <?php } ?>

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
        #menus{
            display:none;
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
        .col-sm-4{
            width:250px  !important; 
            float:left  !important;
        }
        .col-sm-6{
            width:500px  !important; 
            float:left  !important;
        }
        .col-md-5{
            width:400px  !important; 
            float:left  !important;
        }
        .col-sm-12{
            width:960px  !important; 
            float:left  !important;
        }
        .h4{
            border:none  !important; 	width:800px;
        }
        .h3{
            border:none  !important; 
            width:800px;
        }
        .h5{
            border:none  !important; 	width:800px;
        }

    }
</style>
