<?php $avt = strtolower(substr($this->user->first_name, 0, 1)); ?>
<div class=" ">
    <div class="center">

        <h4> <abbr><?php echo ucwords($this->school->school); ?> </abbr>
            <span style="font-size:11px;" class="col-md-12">
                <?php
                if (!empty($this->school->tel))
                {
                        echo $this->school->postal_addr . ' Tel:' . $this->school->tel . ' ' . $this->school->cell;
                }
                else
                {
                        echo $this->school->postal_addr . ' Cell:' . $this->school->cell;
                }
                ?>
            </span>

        </h4>
    </div>

    <?php
    $stream = $this->ion_auth->get_stream();
    ?>	
    <div class="clearfix"></div>

</div>


<div class="row">
    <div class="col-md-12">
        <hr>
        <h2 class="center"><?php echo ucwords($student->first_name . ' ' . $student->last_name); ?> Full Report 
            <br> <small>Produced On: <?php echo date('d M Y H:i') ?> </small></h3>
        <hr>
    </div>
</div>

<div class="row">
    <div class="col-md-12">

        <div class="col-md-3">

            <div class="image" >
                <?php
                if (!empty($student->photo)):
                        if ($passport)
                        {
                                ?> 
                                <image src="<?php echo base_url('uploads/' . $passport->fpath . '/' . $passport->filename); ?>" width="100%" height="100%" class="img-polaroid" style="align:left">
                        <?php } ?>	

                <?php else: ?>   
                        <?php echo theme_image("thumb.png", array('class' => "img-polaroid", 'style' => "width:100%; height:100%; align:left")); ?>
                <?php endif; ?>      
            </div>

            <h5> 
                <abbr><b>ADM NO.</b> <?php
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
                <br>
                <hr>
                <abbr><b>UPI NO.</b> <?php echo $student->upi_number; ?></abbr></h5>


        </div>


        <div class="col-md-3">
            <h4>Student Details</h4>
            <?php
            $class = $this->ion_auth->list_classes();
            $stream = $this->ion_auth->get_stream();

            $u = $this->ion_auth->get_user($student->created_by);
            ?>
            <address>
                <b>Birthday:</b> <?php echo $student->dob > 10000 ? date('d M Y', $student->dob) : ''; ?>.<br>
                <b>Gender:</b> <?php
                if ($student->gender == 1)
                        echo 'Male';
                elseif ($student->gender == 2)
                        echo 'Female';
                else
                        echo $student->gender;
                ?>.<br>


                <b>Disabled:</b> <?php echo $student->disabled ?><br>
                <b>Blood Grp:</b> <?php echo $student->blood_group ?><br>
                <b>My Phone:</b> <?php echo $student->student_phone ?><br>
                <b>Status:</b> <?php echo $student->student_status ?><br>
                <hr>
                <b>Citizenship:</b> <?php
                $cc = $this->ion_auth->populate('countries', 'id', 'name');
                echo isset($cc[$student->citizenship]) ? $cc[$student->citizenship] : '';
                ?><br>
                <b>Home County:</b> <?php
                $hc = $this->ion_auth->populate('counties', 'id', 'name');
                echo isset($hc[$student->county]) ? $hc[$student->county] : '';
                ?><br>
                <b>Sub County:</b> <?php echo $student->sub_county ?><br>
                <b>Residence</b>
                <?php echo $student->residence; ?><br>
                <hr>
                <b>Religion:</b> <?php echo $student->religion; ?><br>	
                <b>Allergies:</b> <?php echo $student->allergies; ?>.<br>										
            </address>

        </div>



        <div class="col-md-3">

            <h4>Other Details</h4> 
            <b>Former School:</b><br> <?php echo $student->former_school; ?><br>
            <b>Entry Marks:</b> <?php echo $student->entry_marks; ?><br>
            <hr>
            <b>Doctor:</b> <?php echo $student->doctor_name; ?>.<br>
            <b>Dr. Phone:</b> <?php echo $student->doctor_phone; ?><br>
            <hr>
            <b>Scholarship:</b> <?php echo $student->scholarship; ?><br>
            <?php
            if ($student->scholarship == 'Yes')
            {
                    ?>
                    <b>Scholarship Type:</b> <?php echo $student->scholarship_type; ?>.<br>
                    <b>Sponsor Details:</b><br> <?php echo $student->sponsor_details; ?>.<br>
            <?php } ?>
            <br>
            <br>

        </div>

        <div class="col-md-3">
            <h4>Admission Details</h4>
            <?php
            ?>
            <p><strong>Level:</strong> 

                <?php
                $cls = isset($class[$cl->class]) ? $class[$cl->class] : ' -';
                $strm = isset($stream[$cl->stream]) ? $stream[$cl->stream] : ' -';
                echo $cls . ' ' . $strm;
                ?>

            </p>

            <p><strong>Emergency Phone:</strong> <?php echo $student->emergency_phone; ?></p>

            <p><strong>Scholar:</strong> <?php echo $student->boarding_day; ?></p>
            <p><b>House:</b> <?php
                $hse = $this->ion_auth->list_house();
                if ($student->house && isset($hse[$student->house]))
                {
                        echo $hse[$student->house];
                }
                ?>  
            </p> 
            <hr>
            <p><strong>Admitted By:</strong> <?php echo $u->first_name . ' ' . $u->last_name; ?></p>
            <p><strong>Admitted On:</strong> <?php echo $student->admission_date > 10000 ? date('M, d, Y', $student->admission_date) : ' - '; ?></p>
            <?php
            if (isset($student->list_id))
            {
                    echo '<p>' . $student->list_id . '</p>';
            }
            else
            {
                    echo '<p>&nbsp;</p>';
            }
            ?>
            <br/>
            <br/>
        </div>


    </div>
    <!------------PARENTS DETAILS--------------------->
    <div class="col-md-12">

        <span style="width:400px">
            <h3 style="border:1px solid #ccc; text-align:center; background-color:#F5F5F5; "> Parents Details</h3>
        </span>
        <div class="col-md-4">

            <div class="info-s profile" style="text-align:center">
                <div class='btn btn-default btn-sm'>
                    <?php
                    if (!empty($paro->father_photo)):
                            $passport = $this->portal_m->parent_photo($paro->father_photo);
                            if ($passport)
                            {
                                    ?> 
                                    <image src="<?php echo base_url('uploads/' . $passport->fpath . '/' . $passport->filename); ?>" width="100" height="100" class="img-polaroid" style="align:left">
                            <?php } ?>	

                    <?php else: ?>   
                            <?php echo theme_image("member.png", array('class' => "img-polaroid", 'style' => "width:100px; height:100px; align:left")); ?>
                    <?php endif; ?> 
                </div>	

                <?php $ttl = $this->ion_auth->populate('titles', 'id', 'name'); ?>
                <h5><?php echo isset($ttl[$paro->f_title]) ? $ttl[$paro->f_title] . '.' : '' ?> <?php echo $paro->first_name . ' ' . $paro->last_name ?></h5>
                <table border="0" width="100%">

                    <tr> <td><strong>Relation:</strong></td><td> <?php echo $paro->f_relation ?></td></tr>
                    <tr> <td><strong>Cell Phone:</strong></td><td> <?php echo $paro->phone ?></td></tr>
                    <tr> <td><strong>Email:</strong></td><td style="font-size:10px;"> <?php echo substr($paro->email, 0, 30) . '..'; ?></td></tr>

                    <tr> <td><strong>Occupation:</strong></td><td><?php echo $paro->occupation ?></td></tr>
                    <tr> <td><strong>ID No:</strong></td><td> <?php echo $paro->f_id ?></td></tr>
                    <tr> <td><strong>Address:</strong></td><td><?php echo $paro->address ?></td></tr>
                </table>

            </div>

        </div>

        <div class="col-md-4">

            <div class="info-s profile"  style="text-align:center">
                <div class='btn btn-default btn-sm'>
                    <?php
                    if (!empty($paro->mother_photo)):
                            $mpp = $this->portal_m->parent_photo($paro->mother_photo);
                            if ($mpp)
                            {
                                    ?> 
                                    <image src="<?php echo base_url('uploads/' . $mpp->fpath . '/' . $mpp->filename); ?>" width="100" height="100" class="img-polaroid" style="align:left">
                            <?php } ?>	

                    <?php else: ?>   
                            <?php echo theme_image("member.png", array('class' => "img-polaroid", 'style' => "width:100px; height:100px; align:left")); ?>
                    <?php endif; ?> 
                </div>		

                <h5><?php echo isset($ttl[$paro->m_title]) ? $ttl[$paro->m_title] . '.' : '' ?> <?php echo '&nbsp;' . $paro->mother_fname . ' ' . $paro->mother_lname ?></h5>

                <table border="0" width="100%">
                    <tr> <td><strong>Relation:</strong></td><td> <?php echo $paro->m_relation ?></td></tr>
                    <tr><td><strong>Cell Phone:</strong></td><td> <?php echo $paro->mother_phone ?></td></tr>

                    <tr><td><strong>Email:</strong></td><td style="font-size:10px;"> <?php echo substr($paro->mother_email, 0, 20) . '..'; ?></td></tr>

                    <tr><td><strong>Occupation:</strong></td><td><?php echo $paro->mother_occupation; ?></td></tr>

                    <tr> <td><strong>ID No:</strong></td><td> <?php echo $paro->f_id ?></td></tr>
                    <tr><td><strong>Address:</strong></td><td><?php echo $paro->address ?></td></tr>
                    <?php
                    if ($paro->mother_phone)
                    {
                            ?>

                    <?php } ?>
                </table>

            </div>
        </div>
        <div class="col-md-4">

            <div class="info-s profile" style="text-align:center">
                <h4>Emergency Contacts</h4>
                <?php
                if ($em_cont)
                {
                        ?>
                        <h5> Name: <?php echo ucwords($em_cont->name); ?></h5>
                        <table border="0" width="100%">
                            <tr> <td><strong>Relation:</strong></td><td> <?php echo $em_cont->relation ?></td></tr>
                            <tr> <td><strong>Cell Phone:</strong></td><td> <?php echo $em_cont->phone ?></td></tr>
                            <tr> <td><strong>Email:</strong></td><td> <?php echo $em_cont->email ?></td></tr>
                            <tr> <td><strong>ID No:</strong></td><td> <?php echo $em_cont->id_no ?></td></tr>
                            <tr> <td><strong>Address:</strong></td><td><?php echo $em_cont->address ?></td></tr>
                            <tr> <td><strong>Provided By:</strong></td><td><?php echo $em_cont->provided_by ?></td></tr>
                        </table>

                        <?php
                }
                else
                {
                        ?>
                        No records uploaded at the moment
                <?php } ?>									 


            </div>  



        </div>


    </div>

    <!------------Classes HISTORY--------------------->
    <div class="col-md-12">

        <span style="width:400px">
            <h3 style="border:1px solid #ccc; text-align:center; background-color:#F5F5F5; "> Classes History</h3>
        </span>



        <table  cellpadding="0" cellspacing="0" width="100%" class="table">
            <thead>
            <th width="3%">#</th>
            <th>Class</th>
            <!--<th>Stream</th>-->
            <th>Year</th>
            <th>Updated On </th>
            <th>Updated By </th>
            </thead>
            <tbody>
                <?php $i = 0; ?>
                <?php
                $classes = $this->ion_auth->fetch_classes();
                foreach ($class_history as $p):

                        $usr = $this->ion_auth->get_user($p->created_by);
                        $i++;
                        ?>
                        <tr>
                            <td><?php echo $i . '.'; ?></td>	
                            <td><?php echo isset($classes[$p->class]) ? $classes[$p->class] : '-'; ?></td>
                           <!-- <td><?php echo isset($stream_name[$p->stream]) ? $stream_name[$p->stream] : '-'; ?></td>-->
                            <td><?php echo $p->year; ?></td>
                            <td><?php echo date('d M Y', $p->created_on); ?></td>
                            <td><?php echo $usr->first_name . ' ' . $usr->last_name; ?></td>
                        </tr>
                <?php endforeach ?>
            </tbody>

        </table>

    </div>

    <!------------Leadership HISTORY--------------------->
    <div class="col-md-12">
        <span style="width:400px">
            <h3 style="border:1px solid #ccc; text-align:center; background-color:#F5F5F5; "> Leadership Positions</h3>
        </span>

        <?php if ($position): ?>         

                <table cellpadding="0" cellspacing="0" width="100%" class="table">
                    <thead>
                    <th width="3%">#</th>
                    <th>Position</th>	
                    <th>Representing</th>	
                    <th>Start Date</th>	
                    <th>Date upto</th>
                    <th>Elected On </th>
                    <th>Recorded By </th>											
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;

                        foreach ($position as $p):
                                $i++;
                                $usr = $this->ion_auth->get_user($p->created_by);
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
                                                echo isset($classes[$p->student_class]) ? $classes[$p->student_class] : ' - ';
                                        }
                                        ?></td>
                                    <td><?php echo date('d/m/Y', $p->start_date); ?></td>
                                    <td width="30"><?php echo date('d/m/Y', $p->duration); ?></td>
                                    <td><?php echo date('d M Y', $p->created_on); ?></td>
                                    <td><?php echo $usr->first_name . ' ' . $usr->last_name; ?></td>
                                </tr>
                        <?php endforeach ?>
                    </tbody>

                </table>

        <?php else: ?>
                <p class='text'><?php echo lang('web_no_elements'); ?></p>
        <?php endif ?>

    </div>

    <!------------Disciplinary HISTORY--------------------->
    <div class="col-md-12">

        <span style="width:400px">
            <h3 style="border:1px solid #ccc; text-align:center; background-color:#F5F5F5; "> Discipline</h3>
        </span>

        <?php if ($disciplinary): ?>              

                <table  cellpadding="0" cellspacing="0" width="100%" class="table">
                    <thead>
                    <th width="3%">#</th>
                    <th>Reported on</th>
                    <th>Reported By</th>
                    <th>Reason</th>
                    <th>Action Taken</th>
                    <th>Taken On</th>
                    <th>Comment</th> 
                    <th>Recorded By</th> 
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;

                        foreach ($disciplinary as $p):
                                $i++;
                                $usr = $this->ion_auth->get_user($p->created_by);
                                if (!empty($p->reported_by))
                                {
                                        $user = $this->ion_auth->get_user($p->reported_by);

                                        $det = ucwords($user->first_name . ' ' . $user->last_name);
                                }
                                else
                                {
                                        $det = $p->others;
                                }
                                ?>
                                <tr>
                                    <td><?php echo $i . '.'; ?></td>					
                                    <td><?php echo date('d/m/Y', $p->date_reported); ?></td>
                                    <td><?php echo $det; ?></td>
                                    <td><?php echo $p->description; ?></td>
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

                                    <td><?php //echo $usr->first_name . ' ' . $usr->last_name;           ?></td>

                                </tr>
                        <?php endforeach ?>
                    </tbody>

                </table>
        <?php else: ?>
                <p class='text'><?php echo lang('web_no_elements'); ?></p>
        <?php endif ?>

    </div>

    <!------------Medical HISTORY--------------------->
    <div class="col-md-12">

        <span style="width:400px">
            <h3 style="border:1px solid #ccc; text-align:center; background-color:#F5F5F5; "> Medical Records</h3>
        </span>
        <?php if ($medical): ?>              

                <table  cellpadding="0" cellspacing="0" width="100%" class="table">
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




    <!------------Medical HISTORY--------------------->
    <div class="col-md-12">

        <span style="width:400px">
            <h3 style="border:1px solid #ccc; text-align:center; background-color:#F5F5F5; "> Extra Curricular Activities</h3>
        </span>
        <?php if ($extra_c): ?>              

                <table  cellpadding="0" cellspacing="0" width="100%" class="table">
                    <thead>
                    <th width="3%">#</th>
                    <th>Activity</th>
                    <th>Term</th>
                    <th>Year</th>
                    <th>Recorded On</th>	
                    <th>Recorded by</th>	
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;
                        $acts = $this->ion_auth->populate('activities', 'id', 'name');
                        foreach ($extra_c as $p):
                                $i++;
                                $u = $this->ion_auth->get_user($p->created_by);
                                ?>
                                <tr>
                                    <td><?php echo $i . '.'; ?></td>	
                                    <td><?php echo $acts[$p->activity]; ?></td>
                                    <td><?php echo $p->term; ?></td>
                                    <td><?php echo $p->year; ?></td>                                                            
                                    <td><?php echo date('d M Y', $p->created_on); ?></td>
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
    <div class="col-md-12">

        <span style="width:400px">
            <h3 style="border:1px solid #ccc; text-align:center; background-color:#F5F5F5; "> Library Book Status</h3>
        </span>
        <?php if (isset($borrowed_books) && count($borrowed_books)): ?>              
                <table  cellpadding="0" cellspacing="0" width="100%" class="table">
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
                        foreach ($borrowed_books as $p):
                                $i++;
                                $u = $this->ion_auth->get_user($p->created_by);
                                ?>
                                <tr>
                                    <td><?php echo $i . '.'; ?></td>	
                                    <td><?php echo isset($lib_books[$p->book]) ? $lib_books[$p->book] : ''; ?></td>
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

    <!------------Book Funds HISTORY--------------------->
    <div class="col-md-12">

        <span style="width:400px">
            <h3 style="border:1px solid #ccc; text-align:center; background-color:#F5F5F5; "> Book Funds Status</h3>
        </span>
        <?php if ($student_books): ?>              

                <table  cellpadding="0" cellspacing="0" width="100%" class="table">
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
                                    <td><?php echo isset($books[$p->book]) ? $books[$p->book] : ''; ?></td>
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

    <!------------PAYMENT HISTORY--------------------->
    <div class="col-md-12">
        <span style="width:400px">
            <h3 style="border:1px solid #ccc; text-align:center; background-color:#F5F5F5; "> Hostel Beds</h3>
        </span>

        <?php if ($bed): ?>

                <table cellpadding="0" cellspacing="0" width="100%" class="table">
                    <thead>
                    <th width="3%">#</th>
                    <th>Date Assigned</th>
                    <th>School Calendar</th>
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
                                    <td><?php //echo $cld[$p->school_calendar_id];           ?></td>
                                    <td><?php echo $beds[$p->bed]; ?></td>
                                    <td><?php echo $p->comment; ?></td>
                                    <td><?php echo ucwords($u->first_name . ' ' . $u->last_name); ?></td>
                                </tr>
                        <?php endforeach ?>
                    </tbody>

                </table>
        <?php else: ?>
                <p class='text'>No Bed Assigned at the moment</p>
        <?php endif ?>
    </div>


    <!------------Certificate --------------------->
    <div class="col-md-12">

        <span style="width:400px">
            <h3 style="border:1px solid #ccc; text-align:center; background-color:#F5F5F5; "> My Certificates</h3>
        </span>
        <?php if ($national_exams): ?>
                <h4> National Exams Certificates</h4>
                <table  cellpadding="0" cellspacing="0" width="100%" class="table">
                    <thead>
                    <th width="3%">#</th>
                    <th>Type</th>

                    <th>Mean Grade</th>
                    <th>Points</th>
                    <th>Certificate</th>
                    <th>Recorded On</th>
                    <th>Added By</th>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;

                        foreach ($national_exams as $p):
                                $u = $this->ion_auth->get_user($p->created_by);
                                $i++;
                                ?>
                                <tr>
                                    <td><?php echo $i . '.'; ?></td>
                                    <td><?php echo $p->certificate_type; ?></td>				

                                    <td><?php echo $p->mean_grade; ?></td>				
                                    <td><?php echo $p->points; ?></td>				
                                    <td>
                                        <a href='#' onClick="return confirm('Serial number required to view this document')" /> <i class="mdi mdi-download"></i> Download File</a>
                                    </td>				
                                    <td><?php echo date('d M Y', $p->created_on); ?></td>				
                                    <td><?php echo ucwords($u->first_name . ' ' . $u->last_name); ?></td>
                                </tr>
                        <?php endforeach ?>
                    </tbody>

                </table>
        <?php endif ?>

        <?php if ($other_certs): ?>
                <h4> Other Certificates</h4>
                <table  cellpadding="0" cellspacing="0" width="100%" class="table">
                    <thead>
                    <th width="3%">#</th>
                    <th>Date Issued</th>
                    <th>Title</th>

                    <th>Certificate</th>
                    <th>Recorded On</th>
                    <th>Added By</th>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;

                        foreach ($other_certs as $p):
                                $u = $this->ion_auth->get_user($p->created_by);
                                $i++;
                                ?>
                                <tr>
                                    <td><?php echo $i . '.'; ?></td>
                                    <td><?php echo date('d M Y', $p->date); ?></td>				
                                    <td><?php echo $p->title; ?></td>				

                                    <td>
                                        <a onClick="return confirm('Serial number required to view this document')" href='#' /> <i class="mdi mdi-download"></i> Download File</a>
                                    </td>				
                                    <td><?php echo date('d M Y', $p->created_on); ?></td>				
                                    <td><?php echo ucwords($u->first_name . ' ' . $u->last_name); ?></td>
                                </tr>
                        <?php endforeach ?>
                    </tbody>

                </table>
        <?php endif ?>



    </div>
    <!--- END FLUID--->

    <!------------PAYMENT HISTORY--------------------->
    <div class="col-md-12">

        <span style="width:400px">
            <h3 style="border:1px solid #ccc; text-align:center; background-color:#F5F5F5; "> Transport History</h3>
        </span>
        <?php if ($transport): ?>

                <table  cellpadding="0" cellspacing="0" width="100%" class="table">
                    <thead>
                    <th width="3%">#</th>
                    <th>Facility</th>
                    <th>Added on</th>
                    <th>Added By</th>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;

                        foreach ($transport as $p):
                                $u = $this->ion_auth->get_user($p->created_by);
                                $i++;
                                ?>
                                <tr>
                                    <td><?php echo $i . '.'; ?></td>
                                    <td><?php echo ucwords($transport_facility[$p->transport_facility]); ?></td>				
                                    <td><?php echo date('d M Y', $p->created_on); ?></td>				
                                    <td><?php echo ucwords($u->first_name . ' ' . $u->last_name); ?></td>
                                </tr>
                        <?php endforeach ?>
                    </tbody>

                </table>
        <?php else: ?>
                <p class='text'>No Transport Facility assigned at the moment</p>
        <?php endif ?>
    </div>


</div>
