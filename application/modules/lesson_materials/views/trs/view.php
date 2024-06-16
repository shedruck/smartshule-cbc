<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h6 class="float-start">Lesson Materials</h6>
                <div class="btn-group btn-group-sm float-end" role="group">
                    <?php echo anchor('lesson_materials/trs/new_lesson_materials/' . $this->session->userdata['session_id'], '<i class="fa fa-plus"></i> New Lesson Material', 'class="btn btn-primary btn-sm "'); ?>
                    <?php echo anchor('lesson_materials/trs/', '<i class="fa fa-list"></i> List All Lesson Materials', 'class="btn btn-success btn-sm "'); ?>
                    <a class="btn btn-sm btn-danger " onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
                </div>
            </div>
            <div class="card-body p-3 mb-2">
                <!-- <div class="row justify-content-center"> -->
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-xl-4">
                        <div class="card text-center shadow-none border profile-cover__img">
                            <div class="card-body">
                                <div class="profile-img-1">
                                    <img src="<?php echo base_url('assets/themes/default/img/member.png'); ?>" alt="img" id="profile-img">

                                </div>
                                <div class="profile-img-content text-dark my-2">
                                    <div>
                                        <?php $u = $this->ion_auth->get_user($post->created_by); ?>
                                        <h5 class="mb-0"> BY: <?php echo strtoupper($u->first_name . ' ' . $u->last_name); ?></h5>
                                        <p class="text-muted mb-0">Educator / teacher</p>
                                    </div>
                                </div>

                                <?php
                                if (!empty($post->file_name)) {
                                ?>
                                    <a class="btn btn-sm btn-info" target="_blank" href='<?php echo base_url() ?><?php echo $post->file_path ?>/<?php echo $post->file_name ?>' /><i class='fa fa-arrow-down'></i> Download</a>
                                <?php } ?>
                                <hr>
                                <div class="text-left">
                                    <p class="text-black font-13"><strong>SUBJECT :</strong>
                                        <?php

                                        $sub = $this->portal_m->get_subject($post->class); ?>
                                        <span class="m-l-15"><?php echo  isset($sub[$post->subject]) ? $sub[$post->subject] : '';; ?></span>
                                    </p>

                                    <p class="text-black font-13"><strong>TOPIC :</strong> <span class="m-l-15"><?php echo $post->topic; ?></span></p>

                                    <p class="text-black font-13"><strong>SUBTOPIC :</strong> <span class="m-l-15"><?php echo $post->subtopic; ?></span></p>

                                    <p class="text-black font-13"><strong>POSTED ON :</strong> <span class="m-l-15"><?php echo date('d M Y', $post->created_on); ?></span></p>
                                </div>
                                <hr>
                                <h6>Comment / Remarks</h6>
                                <p class="text-black font-13 m-t-20">
                                    <?php echo $post->comment ?>
                                </p>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-8 col-xl-8">
                        <div class="card">
                            <div class="card-header">
                                <h6>E-Note</h6>
                            </div>
                            <div class="card-body">
                                <embed src="<?php echo base_url() ?><?php echo $post->file_path ?>/<?php echo $post->file_name ?>" width="100%" height="700" class="tr_all_hover" type='application/pdf'>
                            </div>
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
<style>
    .card-header {
        display: flex;
        justify-content: space-between;
    }
</style>