<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h6 class="float-start">Class Assignments</h6>
                <div class="float-end">
                    <a onclick="goBack()" href="#" class="btn btn-danger btn-sm w-sm waves-effect m-t-10 waves-light"><i class="fa fa-caret-left"></i> Go Back</a>
                </div>
            </div>
            <div class="card-body p-2">
                <div class="row">
                    <div class="col-lg-5 col-md-5">
                        <div class="card text-center shadow-none border profile-cover__img">
                            <div class="card-body">
                                <div class="profile-img-1">
                                    <img src="<?php echo base_url('assets/themes/default/img/member.png'); ?>" alt="img" id="profile-img">

                                </div>
                                <div class="profile-img-content text-dark my-2">
                                    <div>
                                        <?php $u = $this->ion_auth->get_user($p->created_by); ?>
                                        <h6 class="mb-0">Given By : <?php echo strtoupper($u->first_name . ' ' . $u->last_name); ?></h6>
                                        <p class="text-muted mb-0">Educator/Teacher</p>
                                    </div>
                                </div>
                                <?php
                                if (!empty($p->document)) {
                                ?>
                                    <a href="<?php echo base_url('uploads/files/' . $p->document); ?>" class="btn btn-success btn-sm w-sm waves-effect m-t-10 waves-light"><i class="fa fa-download"></i> Download Attachment</a>
                                <?php } ?>
                                <hr>
                                <div class="text-left">
                                    <p class="text-black font-13"><strong>SUBJECT :</strong>
                                        <?php

                                        $sub = $this->portal_m->get_subject($class); ?>
                                        <span class="m-l-15"><?php echo  $sub[$p->subject]; ?></span>
                                    </p>

                                    <p class="text-black font-13"><strong>TOPIC :</strong> <span class="m-l-15"><?php echo $p->topic; ?></span></p>

                                    <p class="text-black font-13"><strong>SUBTOPIC :</strong> <span class="m-l-15"><?php echo $p->subtopic; ?></span></p>

                                    <p class="text-black font-13"><strong>START DATE :</strong> <span class="m-l-15"><?php echo date('d M Y', $p->start_date); ?></span></p>

                                    <p class="text-red font-13"><strong>END DATE:</strong><span class="m-l-15"><?php echo date('d M Y', $p->end_date); ?></span></p>

                                    <p class="text-black font-13"><strong>POSTED ON :</strong> <span class="m-l-15"><?php echo date('d M Y', $p->created_on); ?></span></p>
                                </div>
                                <hr>
                                <h6>Comment / Remarks</h6>
                                <p class="text-black font-13 m-t-20">
                                    <?php echo $p->comment ?>
                                </p>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-7">
                        <div class="card">
                            <div class="card-header">
                                <h6>Assignment Given</h6>
                            </div>
                            <div class="card-body">
                                <embed src="<?php echo base_url('uploads/files/' . $p->document); ?>" width="100%" height="550" class="tr_all_hover" type='application/pdf'>
                            </div>
                        </div>


                    </div>
                    <hr>
                    <div class="row justify-content-center">
                        <div class="col-lg-8 col-xl-8 col-md-8 col-sm-12">
                            <h6>Submitted Assignments (<?php echo number_format(count($done)) ?>)</h6>
                            <hr>

                            <div class="table-responsive">
                                <?php if ($done) { ?>
                                    <table id="responsiveDataTable" class="table table-bordered">
                                        <thead>
                                            <th>Student</th>
                                            <th>Submitted on</th>
                                            <th>Status</th>
                                            <th><?php echo lang('web_options'); ?></th>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 0;

                                            foreach ($done as $p) :

                                                $st = $this->portal_m->find($p->student);
                                                $i++;
                                            ?>
                                                <tr>

                                                    <td><?php echo $st->first_name . ' ' . $st->last_name; ?></td>
                                                    <td><?php echo date('d/m/Y', $p->date); ?></td>
                                                    <td><?php if ($p->status == 1) echo '<span class="label label-success">Marked</span>';
                                                        else echo '<span class="label label-warning">Pending</span>'; ?> </td>

                                                    <td width=''>
                                                        <div class='btn-group'>
                                                            <?php if ($p->status == 1) { ?>
                                                                <a class="btn btn-sm btn-success" href='<?php echo site_url('assignments/trs/mark_assign/' . $p->id . '/' . $p->student . '/' . $class . '/' . $this->session->userdata['session_id']); ?>'><i class='fa fa-share'></i> View</a>
                                                            <?php } else { ?>
                                                                <a class="btn btn-sm btn-primary" href='<?php echo site_url('assignments/trs/mark_assign/' . $p->id . '/' . $p->student . '/' . $class . '/' . $this->session->userdata['session_id']); ?>'><i class='fa fa-share'></i> View </a>
                                                            <?php } ?>

                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach ?>
                                        </tbody>
                                    </table>
                                <?php } else { ?>
                                    <h6>No posted assignment at the moment</h6>
                                <?php } ?>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
            <div class="card-footer">

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