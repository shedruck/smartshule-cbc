<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h6 class="float-start"><?php echo ucfirst($student->first_name . ' ' . $student->last_name) ?> Profile</h6>
                <div class="btn-group btn-group-sm float-end" role="group">

                </div>
            </div>
            <div class="card-body p-3 mb-2">
                <!-- <div class="row justify-content-center"> -->
                <div class="statement">
                    <div class="block invoice slip-content">
                        <?php
                        if (isset($student) && !empty($student)) {
                        ?>
                            <div class=" ">

                                <div class="text-center">
                                    <div class="image">
                                        <img src="<?php echo base_url('uploads/files/' . $this->school->document); ?>" class="center" align="center" style="" width="120" height="120" />
                                    </div>
                                    <h5> <abbr><?php echo ucwords($this->school->school); ?> </abbr><br>




                                        <span style="font-size:11px;" class="col-md-12">
                                            <?php
                                            if (!empty($this->school->tel)) {
                                                echo $this->school->postal_addr . ' Tel:' . $this->school->tel . ' ' . $this->school->cell;
                                            } else {
                                                echo $this->school->postal_addr . ' Cell:' . $this->school->cell;
                                            }
                                            ?>
                                        </span>

                                    </h5>

                                </div>

                                <?php
                                $stream = $this->ion_auth->get_stream();
                                ?>
                                <div class="clearfix"></div>

                            </div>


                            <div class="row text-center">
                                <div class="col-md-12">
                                    <hr>
                                    <h5 class="center"><?php echo ucwords($student->first_name . ' ' . $student->middle_name . ' ' . $student->last_name); ?> Profile Details
                                        <br> <small>Produced On: <?php echo date('d M Y H:i') ?> </small>
                                    </h5>
                                    <hr>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3 col-lg-3 col-xl-3">
                                    <div class="card text-center shadow-none border profile-cover__img">
                                        <div class="card-body">
                                            <div class="profile-img-1">
                                                <img src="<?php echo base_url('assets/themes/default/img/member.png'); ?>" alt="img" id="profile-img">

                                            </div>
                                            <div class="profile-img-content text-dark my-2">
                                                <div>
                                                    <h6>
                                                        <abbr><b>ADM NO.</b> <?php
                                                                                if (!empty($student->old_adm_no)) {
                                                                                    echo $student->old_adm_no;
                                                                                } else {
                                                                                    echo $student->admission_number;
                                                                                }
                                                                                ?>
                                                        </abbr>
                                                        <br>
                                                        <hr>
                                                        <abbr><b>UPI NO.</b> <?php echo $student->upi_number; ?></abbr>
                                                    </h6>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-3 col-lg-3 col-xl-3">
                                    <h6>Student Details</h6>
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
                                                        else echo $student->gender;
                                                        ?>.<br>


                                        <b>Disabled:</b> <?php echo $student->disabled ?><br>
                                        <b>Blood Grp:</b> <?php echo $student->blood_group ?><br>
                                        <b>My Phone:</b> <?php echo $student->student_phone ?><br>
                                        <b>Status:</b> <?php echo $student->student_status ?><br>
                                        <hr>
                                        <b>Citizenship:</b> <?php $cc = $this->ion_auth->populate('countries', 'id', 'name');
                                                            echo isset($cc[$student->citizenship]) ? $cc[$student->citizenship] : ''; ?><br>
                                        <b>Home County:</b> <?php $hc = $this->ion_auth->populate('counties', 'id', 'name');
                                                            echo isset($hc[$student->county]) ? $hc[$student->county] : ''; ?><br>
                                        <b>Sub County:</b> <?php $subcc = $this->ion_auth->populate('subcounties', 'id', 'subcounty');
                                                            echo isset($subcc[$student->sub_county]) ? $subcc[$student->sub_county] : ''; ?><br>
                                        <b>Residence</b>
                                        <?php echo $student->residence; ?><br>
                                        <hr>
                                        <b>Religion:</b> <?php echo $student->religion; ?><br>
                                        <b>Allergies:</b> <?php echo $student->allergies; ?>.<br>
                                    </address>
                                </div>
                                <div class="col-md-3 col-lg-3 col-xl-3">
                                    <h6>Other Details</h6>


                                    <b>Former School:</b><br> <?php echo $student->former_school; ?><br>
                                    <b>Entry Marks:</b> <?php echo $student->entry_marks; ?><br>
                                    <hr>
                                    <b>Doctor:</b> <?php echo $student->doctor_name; ?>.<br>
                                    <b>Dr. Phone:</b> <?php echo $student->doctor_phone; ?><br>
                                    <hr>
                                    <b>Scholarship:</b> <?php echo $student->scholarship; ?><br>
                                    <?php if ($student->scholarship == 'Yes') { ?>
                                        <b>Scholarship Type:</b> <?php echo $student->scholarship_type; ?>.<br>
                                        <b>Sponsor Details:</b><br> <?php echo $student->sponsor_details; ?>.<br>
                                    <?php } ?>
                                </div>
                                <div class="col-md-3 col-lg-3 col-xl-3">
                                    <h6>Admission Details</h6>
                                    <?php
                                    $class = $this->ion_auth->list_classes();
                                    $stream = $this->ion_auth->get_stream();

                                    $u = $this->ion_auth->get_user($student->created_by);
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
                                                        if ($student->house && isset($hse[$student->house])) {
                                                            echo $hse[$student->house];
                                                        }
                                                        ?>
                                    </p>
                                    <hr>
                                    <p><strong>Admitted By:</strong> <?php echo $u->first_name . ' ' . $u->last_name; ?></p>
                                    <p><strong>Admitted On:</strong> <?php echo $student->admission_date > 10000 ? date('M, d, Y', $student->admission_date) : ' - '; ?></p>
                                    <?php
                                    if (isset($student->list_id)) {
                                        echo '<p>' . $student->list_id . '</p>';
                                    } else {
                                        echo '<p>&nbsp;</p>';
                                    }
                                    ?>
                                    <h4>Class Attendance</h4>
                                    <table border="0" width="100%">
                                        <tr>
                                            <td><b>Days Present:</b> </td>
                                            <td> <?php echo $days_present; ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Days Absent:</b> </td>
                                            <td> <?php echo $days_absent; ?></td>
                                        </tr>
                                    </table>

                                </div>
                            </div>

                            <hr>
                            <div class="row">
                                <div class="card">
                                    <div class="card-header bg-default">
                                        Classes History
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table cellpadding="0" cellspacing="0" width="100%" class="table table-bordered">
                                                <thead class="bg-default">
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
                                                    $classes = $this->portal_m->get_class_options();
                                                    foreach ($class_history as $p) :

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
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <div class="row">
                                <div class="card">
                                    <div class="card-header bg-default">
                                        Favourites and Hobbies
                                    </div>
                                    <div class="card-body">
                                        <?php if ($favourite_hobbies) : ?>
                                            <div class="table-responsive">
                                                <table cellpadding="0" cellspacing="0" width="100%" class="table table-bordered">
                                                    <thead class="bg-default">
                                                        <th>#</th>

                                                        <th>Level</th>

                                                        <th>Languages Spoken</th>
                                                        <th>Hobbies</th>
                                                        <th>Favourite Subjects</th>
                                                        <th>Favourite Books</th>
                                                        <th>Favourite Food</th>
                                                        <th>Favourite Bible Verse</th>
                                                        <th>Favourite Cartoon</th>
                                                        <th>Favourite Career</th>
                                                        <th>Others</th>

                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $i = 0;
                                                        foreach ($favourite_hobbies as $p) :
                                                            $i++;
                                                        ?>
                                                            <tr>
                                                                <td><?php echo $i . '.'; ?></td>

                                                                <td>
                                                                    <?php

                                                                    $cls = isset($class[$p->class]) ? $class[$p->class] : ' -';

                                                                    echo $cls;

                                                                    ?><br>
                                                                    <?php echo $p->year; ?>
                                                                </td>

                                                                <td><?php echo $p->languages_spoken; ?></td>
                                                                <td><?php echo $p->hobbies; ?></td>
                                                                <td><?php echo $p->favourite_subjects; ?></td>
                                                                <td><?php echo $p->favourite_books; ?></td>
                                                                <td><?php echo $p->favourite_food; ?></td>
                                                                <td><?php echo $p->favourite_bible_verse; ?></td>
                                                                <td><?php echo $p->favourite_cartoon; ?></td>
                                                                <td><?php echo $p->favourite_career; ?></td>
                                                                <td><?php echo $p->others; ?></td>


                                                            </tr>
                                                        <?php endforeach ?>
                                                    </tbody>

                                                </table>


                                            </div>

                                        <?php else : ?>
                                            <p class='text'><?php echo lang('web_no_elements'); ?></p>
                                        <?php endif ?>
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <div class="row">
                                <div class="card">
                                    <div class="card-header bg-default">
                                        Leadership Positions
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <?php if ($position) : ?>

                                                <table cellpadding="0" cellspacing="0" width="100%" class="table table-bordered table-colored table-success m-0">
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

                                                        foreach ($position as $p) :
                                                            $i++;
                                                            $usr = $this->ion_auth->get_user($p->created_by);

                                                        ?>
                                                            <tr>
                                                                <td><?php echo $i . '.'; ?></td>
                                                                <td><?php echo $st_pos[$p->position]; ?></td>
                                                                <td><?php
                                                                    if ($p->student_class == "Others") {
                                                                        echo 'Others';
                                                                    } else {
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

                                            <?php else : ?>
                                                <p class='text'><?php echo lang('web_no_elements'); ?></p>
                                            <?php endif ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="card">
                                    <div class="card-header bg-default">
                                        Discipline
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <?php if ($disciplinary) : ?>

                                                <table cellpadding="0" cellspacing="0" width="100%" class="table table-bordered table-colored table-success m-0">
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

                                                        foreach ($disciplinary as $p) :
                                                            $i++;
                                                            $usr = $this->ion_auth->get_user($p->created_by);
                                                            $user = $this->ion_auth->get_user($p->reported_by);
                                                        ?>
                                                            <tr>
                                                                <td><?php echo $i . '.'; ?></td>
                                                                <td><?php echo date('d/m/Y', $p->date_reported); ?></td>
                                                                <td><?php
                                                                    if (!empty($p->reported_by)) {
                                                                        echo $user->first_name . ' ' . $user->last_name;
                                                                    } else {
                                                                        echo $p->others;
                                                                    }
                                                                    ?>
                                                                </td>
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

                                                                <td><?php echo $usr->first_name . ' ' . $usr->last_name; ?></td>

                                                            </tr>
                                                        <?php endforeach ?>
                                                    </tbody>

                                                </table>
                                            <?php else : ?>
                                                <p class='text'><?php echo lang('web_no_elements'); ?></p>
                                            <?php endif ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="card">
                                    <div class="card-header bg-default">
                                        Medical Records
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <?php if ($medical) : ?>

                                                <table cellpadding="0" cellspacing="0" width="100%" class="table table-bordered table-colored table-success m-0">
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

                                                        foreach ($medical as $p) :
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
                                            <?php else : ?>
                                                <p class='text'><?php echo lang('web_no_elements'); ?></p>
                                            <?php endif ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="card">
                                    <div class="card-header bg-default">
                                        Extra Curricular Activities
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <?php if ($extra_c) : ?>

                                                <table cellpadding="0" cellspacing="0" width="100%" class="table table-bordered table-colored table-success m-0">
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
                                                        foreach ($extra_c as $p) :
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
                                            <?php else : ?>
                                                <p class='text'><?php echo lang('web_no_elements'); ?></p>
                                            <?php endif ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="card">
                                    <div class="card-header bg-default">
                                        Library Book Status
                                    </div>
                                    <div class="card-body">
                                        <?php if ($borrowed_books) : ?>

                                            <table cellpadding="0" cellspacing="0" width="100%" class="table table-bordered table-colored table-success m-0">
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
                                                    foreach ($borrowed_books as $p) :
                                                        $i++;
                                                        $u = $this->ion_auth->get_user($p->created_by);
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $i . '.'; ?></td>
                                                            <td><?php echo isset($lib_books[$p->book]) ? $lib_books[$p->book] : ''; ?></td>
                                                            <td><?php echo date('d/m/Y', $p->borrow_date); ?></td>
                                                            <td>
                                                                <?php
                                                                if ($p->status == 2) {
                                                                    echo '<span style="color:green">Book Returned</span>';
                                                                } elseif ($p->status == 1) {
                                                                    echo '<span style="color:red">Not Returned</span>';
                                                                }
                                                                ?> </td>
                                                            <td><?php echo $p->remarks; ?></td>
                                                        </tr>
                                                    <?php endforeach ?>
                                                </tbody>

                                            </table>
                                        <?php else : ?>
                                            <p class='text'><?php echo lang('web_no_elements'); ?></p>
                                        <?php endif ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="card">
                                    <div class="card-header bg-default">
                                        Book Funds Status
                                    </div>
                                    <div class="card-body">
                                        <?php if ($student_books) : ?>

                                            <table cellpadding="0" cellspacing="0" width="100%" class="table table-bordered table-colored table-success m-0">
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
                                                    foreach ($student_books as $p) :
                                                        $i++;
                                                        $u = $this->ion_auth->get_user($p->created_by);
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $i . '.'; ?></td>
                                                            <td><?php echo isset($books[$p->book]) ? $books[$p->book] : ''; ?></td>
                                                            <td><?php echo date('d/m/Y', $p->borrow_date); ?></td>
                                                            <td>
                                                                <?php
                                                                if ($p->status == 2) {
                                                                    echo '<span style="color:green">Book Returned</span>';
                                                                } elseif ($p->status == 1) {
                                                                    echo '<span style="color:red">Not Returned</span>';
                                                                }
                                                                ?> </td>
                                                            <td><?php echo $p->remarks; ?></td>
                                                        </tr>
                                                    <?php endforeach ?>
                                                </tbody>

                                            </table>
                                        <?php else : ?>
                                            <p class='text'><?php echo lang('web_no_elements'); ?></p>
                                        <?php endif ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="card">
                                    <div class="card-header bg-default">
                                        Hostel Beds
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <?php if ($bed) : ?>

                                                <table cellpadding="0" cellspacing="0" width="100%" class="table table-bordered table-colored table-success m-0">
                                                    <thead>
                                                        <th width="3%">#</th>
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
                                                        foreach ($bed as $p) :
                                                            $u = $this->ion_auth->get_user($p->created_by);
                                                            //$cld = $this->ion_auth->list_school_calendar();
                                                            $i++;
                                                        ?>
                                                            <tr>
                                                                <td><?php echo $i . '.'; ?></td>
                                                                <td><?php echo date('d M Y', $p->date_assigned); ?></td>
                                                                <td><?php echo $p->term; ?></td>
                                                                <td><?php echo $p->year; ?></td>
                                                                <td><?php echo $beds[$p->bed]; ?></td>
                                                                <td><?php echo $p->comment; ?></td>
                                                                <td><?php echo ucwords($u->first_name . ' ' . $u->last_name); ?></td>
                                                            </tr>
                                                        <?php endforeach ?>
                                                    </tbody>

                                                </table>
                                            <?php else : ?>
                                                <p class='text'>No Bed Assigned at the moment</p>
                                            <?php endif ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="card">
                                    <div class="card-header bg-default">
                                        Student Certificates
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <?php if ($national_exams) : ?>
                                                <h5> National Exams Certificates</h5>
                                                <table cellpadding="0" cellspacing="0" width="100%" class="table table-bordered table-colored table-success m-0">
                                                    <thead>
                                                        <th width="3%">#</th>
                                                        <th>Type</th>
                                                        <th>Serial No.</th>
                                                        <th>Mean Grade</th>
                                                        <th>Points</th>
                                                        <th>Certificate</th>
                                                        <th>Recorded On</th>
                                                        <th>Added By</th>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $i = 0;

                                                        foreach ($national_exams as $p) :
                                                            $u = $this->ion_auth->get_user($p->created_by);
                                                            $i++;
                                                        ?>
                                                            <tr>
                                                                <td><?php echo $i . '.'; ?></td>
                                                                <td><?php echo $p->certificate_type; ?></td>
                                                                <td><?php echo $p->serial_number; ?></td>
                                                                <td><?php echo $p->mean_grade; ?></td>
                                                                <td><?php echo $p->points; ?></td>
                                                                <td>
                                                                    <a target="_blank" href='<?php echo base_url() ?>uploads/<?php echo $p->fpath ?>/<?php echo $p->certificate ?>' /> <i class="glyphicon glyphicon-download"></i> Download File</a>
                                                                </td>
                                                                <td><?php echo date('d M Y', $p->created_on); ?></td>
                                                                <td><?php echo ucwords($u->first_name . ' ' . $u->last_name); ?></td>
                                                            </tr>
                                                        <?php endforeach ?>
                                                    </tbody>

                                                </table>
                                            <?php endif ?>

                                            <?php if ($other_certs) : ?>
                                                <h5> Other Certificates</h5>
                                                <table cellpadding="0" cellspacing="0" width="100%" class="table table-bordered table-colored table-success m-0">
                                                    <thead>
                                                        <th width="3%">#</th>
                                                        <th>Date Issued</th>
                                                        <th>Title</th>
                                                        <th>Serial No.</th>
                                                        <th>Certificate</th>
                                                        <th>Recorded On</th>
                                                        <th>Added By</th>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $i = 0;

                                                        foreach ($other_certs as $p) :
                                                            $u = $this->ion_auth->get_user($p->created_by);
                                                            $i++;
                                                        ?>
                                                            <tr>
                                                                <td><?php echo $i . '.'; ?></td>
                                                                <td><?php echo date('d M Y', $p->date); ?></td>
                                                                <td><?php echo $p->title; ?></td>
                                                                <td><?php echo $p->certificate_number; ?></td>
                                                                <td>
                                                                    <a target="_blank" href='<?php echo base_url() ?>uploads/files/<?php echo $p->file ?>' /> <i class="glyphicon glyphicon-download"></i> Download File</a>
                                                                </td>
                                                                <td><?php echo date('d M Y', $p->created_on); ?></td>
                                                                <td><?php echo ucwords($u->first_name . ' ' . $u->last_name); ?></td>
                                                            </tr>
                                                        <?php endforeach ?>
                                                    </tbody>

                                                </table>
                                            <?php endif ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="card">
                                    <div class="card-header bg-default">
                                        Transport History
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <?php if ($transport) : ?>

                                                <table cellpadding="0" cellspacing="0" width="100%" class="table table-bordered table-colored table-success m-0">
                                                    <thead>
                                                        <th width="3%">#</th>
                                                        <th>Facility</th>
                                                        <th>Added on</th>
                                                        <th>Added By</th>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $i = 0;

                                                        foreach ($transport as $p) :
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
                                            <?php else : ?>
                                                <p class='text'>No Transport Facility assigned at the moment</p>
                                            <?php endif ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>

                <?php
                        } else {
                ?>
                    <h3>Please Select Student First</h3>

                    <?php echo form_open('admin/reports/student_report'); ?>
                    <select name="student" class="select" tabindex="-1">
                        <option value="">Select Student</option>
                        <?php
                            $data = $this->ion_auth->students_full_details();
                            foreach ($data as $key => $value) :
                        ?>
                            <option value="<?php echo $key; ?>"><?php echo $value ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button class="btn btn-warning" style="height:30px;" type="submit">View Reports</button>

                    <?php echo form_close(); ?>
                <?php } ?>


                </div>
                <br>
                <br>
                <br>
                <div class="footer">
                    <div class="center" style="border-top:1px solid #ccc">
                        <span class="center" style="font-size:0.8em !important;text-align:center !important;">
                            <?php
                            if (!empty($this->school->tel)) {
                                echo $this->school->postal_addr . ' Tel:' . $this->school->tel . ' ' . $this->school->cell;
                            } else {
                                echo $this->school->postal_addr . ' Cell:' . $this->school->cell;
                            }
                            ?></span>
                    </div>
                </div>
            </div>
            <!-- </div> -->
        </div>
        <div class="card-footer">
            <div class="form-check d-inline-block">
                <!-- <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
					<label class="form-check-label" for="flexCheckChecked">
						Confirm
					</label> -->
            </div>
            <div class="float-end d-inline-block btn-list">

            </div>
        </div>
    </div>
</div>
</div>

<!-- Basic Modal -->
<div class="modal fade" id="hobies" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fs-5" id="exampleModalLabel">Record Student Hobbies and Favourites</h6>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>


        </div>
    </div>
</div>
<style>
    .card-header {
        display: flex;
        justify-content: space-between;
    }
</style>