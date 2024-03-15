<div class="col-md-12">

    <div class="widget">

        <div class="block invoice">
            <div class="row">
                <div class="col-md-2">
                    <div class="image" >
                        <?php
                        if (!empty($student->photo)):
                                if ($passport)
                                {
                                        ?> 
                                        <image src="<?php echo base_url('uploads/' . $passport->fpath . '/' . $passport->filename); ?>" width="100" height="100" class="img-polaroid" style="align:left">
                                <?php } ?>	

                        <?php else: ?>   
                                <?php echo theme_image("thumb.png", array('class' => "img-polaroid", 'style' => "width:100px; height:100px; align:left")); ?>
                        <?php endif; ?>  
                        <br>
                        <br>
                        <?php echo anchor('admin/admission/student_id/' . $student->id, '<i class="glyphicon glyphicon-user"> </i> Student ID Card', 'class="btn btn-success"'); ?> 						
                    </div>
                </div>
                <div class="col-md-4">
                    <h4> <abbr><?php echo ucwords($student->first_name . ' ' . $student->last_name); ?>. </abbr></h4>
                    <h4>
                        <abbr>ADM NO. <?php
                            if (!empty($student->old_adm_no))
                            {
                                    echo $student->old_adm_no;
                            }
                            else
                            {
                                    echo $student->admission_number;
                            }
                            ?>
                        </abbr>
                    </h4>
                    <span class="date">Admission Date: <?php echo date('d M Y', $student->admission_date); ?></span>
                </div>

                <div class="col-md-6 ">
                    <div class="right">

                    </div>


                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <h4>Student Details</h4>

                    <address>
                        <b>Birthday:</b> <?php echo $student->dob > 1000 ? date('d M Y', $student->dob) : ''; ?>.<br>
                        <b>Gender:</b> <?php
                        if ($student->gender == 1)
                                echo 'Male';
                        else
                                echo 'Female';
                        ?>.<br>
                        <?php echo $student->email; ?>.<br>
                        <b><abbr title="House">House:</abbr></b> <?php
                        $hse = $this->ion_auth->list_house();
                        if ($student->house && isset($hse[$student->house]))
                        {
                                echo $hse[$student->house];
                        }
                        ?>  
                        <br>
                        <br>
                        <?php //echo anchor('admin/leaving_certificate/create/' . $student->id, '<i class="glyphicon glyphicon-file"> </i> Leaving Certificate', 'class="btn btn-info"'); ?> 
                    </address>
                </div>

                <div class="col-md-3">
                    <h4>Admission Details</h4>
                    <?php
                    $class = $this->ion_auth->list_classes();
                    $stream = $this->ion_auth->get_stream();

                    $u = $this->ion_auth->get_user($student->created_by);
                    ?>
                    <p><strong>Class:</strong> <?php
                        $cls = isset($class[$cl->class]) ? $class[$cl->class] : ' -';
                        $strm = isset($stream[$cl->stream]) ? $stream[$cl->stream] : ' -';
                        echo $cls . ' ' . $strm;
                        ?></p>

                    <p><strong>Admitted By:</strong> <?php echo $u->first_name . ' ' . $u->last_name; ?></p>
                    <p><strong>Admitted On:</strong> <?php echo date('M, d, Y', $student->admission_date); ?></p>
                    <p>&nbsp;</p>

                    <br>

                </div>

                <div class="col-md-3">
                    <h4>Other Details</h4>


                    <b>Residence</b><br>
                    <?php echo $student->residence; ?><br>
                    <b>Former School:</b> <?php echo $student->former_school; ?><br>
                    <b>Entry Marks:</b> <?php echo $student->entry_marks; ?><br>
                    <b>Allergies:</b> <?php echo $student->allergies; ?>.<br>
                    <b>Doctor:</b> <?php echo $student->doctor_name; ?>.<br>
                    <b>Dr. Phone:</b> <?php echo $student->doctor_phone; ?>.<br>


                    <br>
                    <br>
                    <?php //echo anchor('admin/parents/view/' . $student->parent_id, '<i class="glyphicon glyphicon-eye-open"> </i> Parents Full Details', 'class="btn btn-warning"'); ?> 

                </div>

                <div class="col-md-3">
                    <?php
                    if ($this->ion_auth->is_admin())
                    {
                            ?>
                            <h4>Payment Details</h4>

                            <div class="highlight2">
                                <strong ><span >Fee Payable: </span> <?php echo $this->currency; ?> <?php
                                    if ($fee && $student->status)
                                    {
                                            echo number_format($fee->invoice_amt, 2);
                                    }
                                    else
                                    {
                                            echo '0.00';
                                    }
                                    ?>  <em></em>
                                </strong>
                            </div> 
                            <div class="highlight ">
                                <strong ><span>Total Paid: </span><?php echo $this->currency; ?> <?php
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
                                    ?></strong>
                            </div>
                            <!---WAIVER--->
                            <?php if ($waiver && $student->status): ?>
                                    <div class="highlight ">
                                        <strong ><span>Fee Waived: </span> <?php echo $this->currency; ?> <?php
                                            echo number_format($waiver, 2);
                                            ?>  <em></em></strong>
                                    </div>
                            <?php endif ?>
                            <div class="highlight3">
                                <strong > <?php
                                    if (isset($fee) && isset($fee->balance))
                                    {
                                            if ($fee->balance > 0)
                                            {
                                                    echo '<span>Fee Balance: </span> ' . $this->currency . ' ' . number_format($fee->balance, 2);
                                            }
                                            elseif ($fee->balance < 0)
                                            {
                                                    echo '<span>Overpay </span> ' . $this->currency . ' ' . number_format($fee->balance, 2);
                                            }
                                            elseif ($fee->balance == 0)
                                            {
                                                    echo '<span>No Balance </span> ' . $this->currency . ' ' . number_format($fee->balance, 2);
                                            }
                                    }
                                    ?>   </strong>
                            </div><br>
                            <?php //echo anchor('admin/fee_payment/statement/' . $student->id, '<i class="glyphicon glyphicon-folder-open"> </i> View Fee Statement', 'class="btn btn-primary"'); ?> 
                    <?php } ?>
                </div>
            </div>
            <?php
            if ($this->ion_auth->is_admin())
            {
                    ?>
                    <div class="widget">
                        <div class="block-fluid tabbable">                    
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#tab7" data-toggle="tab">Parents Details</a></li>
                                <li class=""><a href="#tab1" data-toggle="tab">Payment History</a></li>
                                <li class=""><a href="#tab2" data-toggle="tab">Class Performance</a></li>
                                <li class=""><a href="#tab4" data-toggle="tab">Leadership Positions</a></li>

                                <li class=""><a href="#tab5" data-toggle="tab">Disciplinary</a></li>

                                <li class=""><a href="#tab6" data-toggle="tab">Transport</a></li>
                                <li class=""><a href="#tab3" data-toggle="tab">Rooms/Beds</a></li>
 
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane " id="tab1">
                                    <?php if (!empty($p)): ?>
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
                                                    <?php endforeach ?>

                                                </tbody>
                                            </table>

                                            <div class="row">
                                                <div class="col-md-6"></div>
                                                <div class="col-md-6">
                                                    <div class="total">

                                                        <div class="highlight">
                                                            <strong><span>Total Paid Including Waivers:</span> <?php echo $this->currency; ?>. <?php
                                                                if (!empty($fee))
                                                                {
                                                                        echo number_format($fee->paid, 2);
                                                                }
                                                                else
                                                                {
                                                                        echo '0.00';
                                                                }
                                                                ?>  <em></em></strong>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    <?php else: ?>
                                            <h5>No Payment has been recorded at the moment!!</h5>
                                    <?php endif; ?>
                                </div>
                                <!--TAB2-->
                                <div class="tab-pane " id="tab2">
                                    <?php if (!empty($exams)): ?>
                                            <table cellpadding="0" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th width="3%">#</th>
                                                        <th width="">Term/Semester</th>
                                                        <th width="">Total Marks</th>
                                                        <th width="">Remarks</th>
                                                        <th width="">Recorded on</th>
                                                        <th width="">Recorded By</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 0;
                                                    $av = 0;

                                                    foreach ($exams as $p):
                                                            $user = $this->ion_auth->get_user($p->created_by);
                                                            $exams_id = 0; //$this->exams_management_m->find($p->exams_id);

                                                            $i++;
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $i; ?></td>
                                                                <td><?php
                                                                    if ($exams_id)
                                                                    {
                                                                            echo ' Term ' . $term[$exams_id->exam_type] . ' - ';
                                                                            echo $type_details[$exams_id->exam_type];
                                                                    }
                                                                    else
                                                                    {
                                                                            echo ' - ';
                                                                    }
                                                                    ?></td>
                                                                <td><?php echo $p->total; ?></td>
                                                                <td><?php echo $p->remarks; ?></td>
                                                                <td><?php echo date('d/m/Y', $p->created_on); ?></td>
                                                                <td><?php echo $user->first_name . ' ' . $user->last_name; ?></td>
                                                            </tr>
                                                    <?php endforeach ?>
                                                </tbody>
                                            </table>

                                    <?php else: ?>
                                            <h5>No exams has been recorded at the moment!!</h5>
                                    <?php endif; ?>
                                </div> 
                                <!--TAB 3-->
                                <div class="tab-pane " id="tab3">
                                    <?php if ($bed): ?>
                                            <table class="" cellpadding="0" cellspacing="0" width="100%">
                                                <thead>
                                                <th>#</th>
                                                <th>Date Assigned</th>
                                                <th>Term</th>
                                                <th>Year</th>
                                                <th>Bed</th>
                                                <th>Comment</th>
                                                <th>Assigned By</th>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 0;
                                                    foreach ($bed as $p):

                                                            $u = $this->ion_auth->get_user($p->created_by);
                                                            $i++;
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $i . '.'; ?></td>					
                                                                <td><?php echo date('d M Y', $p->date_assigned); ?></td>
                                                                <td><?php echo $this->terms[$p->term]; ?></td>
                                                                <td><?php echo $p->year; ?></td>
                                                                <td><?php echo $beds[$p->bed]; ?></td>
                                                                <td><?php echo $p->comment; ?></td>
                                                                <td><?php echo ucwords($u->first_name . ' ' . $u->last_name); ?></td>
                                                            </tr>
                                                    <?php endforeach ?>
                                                </tbody>
                                            </table>
                                    <?php else: ?>
                                            <p class='text'><?php echo lang('web_no_elements'); ?></p>
                                    <?php endif ?>
                                </div>
                                <!--TAB 4 POSITIONS-->
                                <div class="tab-pane " id="tab4">
                                    <?php if ($position): ?>
                                            <table cellpadding="0" cellspacing="0" width="100%">
                                                <thead>
                                                <th>#</th>
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
                                <!---End Position-->

                                <!--TAB 5 POSITIONS-->
                                <div class="tab-pane " id="tab5">
                                    <?php if ($disciplinary): ?>              

                                            <table  cellpadding="0" cellspacing="0" width="100%">
                                                <thead>
                                                <th>#</th>
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
                                                                    <?php echo $p->action_taken; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo date('d/m/Y', $p->modified_on); ?>
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
                                <!---End TAB-->

                                <!--TAB 6 Transport-->
                                <div class="tab-pane " id="tab6">
                                    
                                </div>
                                <!---End TAB-->

                                <!--TAB 7 Parents-->
                                <div class="tab-pane active" id="tab7">
                                    <div class="block-fluid">
                                        <div class="col-md-6">
                                            <div class="widget">
                                                <div class="profile clearfix">
                                                    <div class="image">
                                                        <img src="<?php echo base_url('assets/themes/admin/img/2.png'); ?>" width="100" height="100"class="img-polaroid"/>
                                                    </div>                        
                                                    <div class="info-s">
                                                        <h2><?php echo $paro->first_name . ' ' . $paro->last_name ?></h2>
                                                        <table border="0" width="300">
                                                            <tr> <td><strong>Email:</strong></td><td> <?php echo $paro->email ?></td></tr>
                                                            <tr> <td><strong>Cell Phone:</strong></td><td> <?php echo $paro->phone ?></td></tr>
                                                            <tr> <td><strong>Other Phone:</strong></td><td> <?php echo $paro->phone2 ?></td></tr>
                                                            <tr> <td><strong>Occupation:</strong></td><td><?php echo $paro->occupation ?></td></tr>
                                                            <tr> <td><strong>Address:</strong></td><td><?php echo $paro->address ?></td></tr>
                                                        </table>
                                                        <div class="status">Father Details</div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="widget">
                                                <div class="profile clearfix">
                                                    <div class="image">
                                                        <img src="<?php echo base_url('assets/themes/admin/img/3.png'); ?>" width="100" height="100"class="img-polaroid"/>
                                                    </div>                        
                                                    <div class="info-s">
                                                        <h2><?php echo $paro->mother_fname . ' ' . $paro->mother_lname ?></h2>
                                                        <table border="0" width="300">
                                                            <tr> <td><strong>Email:</strong></td><td> <?php echo $paro->mother_email ?></td></tr>
                                                            <tr> <td><strong>Cell Phone:</strong></td><td> <?php echo $paro->mother_phone ?></td></tr>
                                                            <tr> <td><strong>Other Phone:</strong></td><td> <?php echo $paro->mother_phone2 ?></td></tr>
                                                            <tr> <td><strong>Occupation:</strong></td><td><?php echo ''; ?></td></tr>
                                                            <tr> <td><strong>Address:</strong></td><td><?php echo $paro->address ?></td></tr>
                                                        </table>

                                                        <div class="status">Mother Details</div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!---End TAB-->
                            </div>
                        </div>
                    </div>

            <?php } ?>
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
</style>
