<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h6 class="float-start"><?php echo $post->title ?> - Question and Answers</h6>
                <div class="float-end">
                    <!-- <button class="btn btn-primary off-canvas" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Toggle right offcanvas</button> -->
                    <button class="btn btn-success btn-sm off-canvas" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"><i class="fa fa-folder"></i> Post Quiz to Students <span class="caret"></span> </button>

                    <?php echo anchor('qa/trs/given_quiz/' . $post->id . '/' . $this->session->userdata['session_id'], '<i class="fa fa-thumbs-up"></i> View Given Quiz', 'class="btn btn-primary btn-sm "'); ?>
                    <?php echo anchor('qa/trs/', '<i class="fa fa-list"></i> List All', 'class="btn btn-info btn-sm "'); ?>
                    <a class="btn btn-sm btn-danger " onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
                </div>

            </div>
            <div class="card-body p-2">
                <!-- Document View -->
                <div class="row">


                    <div class="col-md-12">

                        <div class="col-sm-12 text-center">
                            <span class="" style="text-align:center">
                                <img src="<?php echo base_url('uploads/files/' . $this->school->document); ?>" class="center" width="100" height="100" />
                            </span>
                            <h5>
                                <span><?php echo strtoupper($this->school->school); ?></span>
                            </h5>
                            <small>
                                <?php
                                if (!empty($this->school->tel)) {
                                    echo $this->school->postal_addr . ' Tel:' . $this->school->tel . ' ' . $this->school->cell;
                                } else {
                                    echo $this->school->postal_addr . ' Cell:' . $this->school->cell;
                                }
                                ?>
                            </small>

                            <br>
                            <hr>
                            <h6 style=""><?php echo strtoupper($post->title) ?></h6>
                            <h6 style=""><b>LEVEL:</b> <?php echo strtoupper($post->title) ?></h6>
                            <h6 style=""><b>SUBJECT / LEARNING AREA:</b> <?php echo strtoupper($post->subject) ?></h6>
                            <?php if ($post->topic) { ?>
                                <h6 style=""><b>TOPIC / STRAND:</b> <?php echo strtoupper($post->topic) ?></h6>
                            <?php } ?>
                            <hr>
                        </div>

                        <div class="col-sm-12">
                            <h6>INSTRUSTIONS</h6>
                            <p><?php echo $post->instruction ?></p>
                        </div>


                    </div>

                </div>

                <div class="row">
            <div class="col-sm-12">
                <div class="timeline timeline-left">
                    <article class="timeline-item alt">
                        <div class="text-left">
                            <div class="time-show first">
                                <a href="#" class="btn btn-danger w-lg">QUESTIONS</a>
                            </div>
                        </div>
                    </article>
                    <?php $i = 0;
                    if ($questions) { ?>

                        <?php foreach ($questions as $p) {
                            $i++; ?>
                            <article class="timeline-item ">
                                <div class="timeline-desk col-sm-12">
                                    <div class="panel">
                                        <div class="timeline-box">
                                            <!-- <span class="timeline-icon"><i class="mdi mdi-checkbox-blank-circle-outline"></i></span> -->
                                            <h6> <span class="text-black" style="font-size:24px !important;"><?php echo $i ?>) <?php echo $p->question; ?></span> </h6>
                                            <span class="timeline-date text-red"><small> Marks ( <?php echo $p->marks ?> )</small></span>
                                            <p class="text-black"> Answer: <b class="text-green"><?php echo $p->answer ?></b> </p>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        <?php  } ?>
                    <?php } else { ?>
                        No question has been added
                    <?php } ?>

                </div>
            </div>
        </div>
                <!-- Document View End-->
            </div>
            <div class="card-footer">

            </div>
        </div>
    </div>

    <!-- Offright Canvas -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight">
        <div class="offcanvas-header">
            <h6 class="fw-bold offcanvas-title">My Classes</h6>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"><i class="fe fe-x fs-18"></i></button>
        </div>
        <div class="offcanvas-body">
            <div>
                <h6 class="mb-3 fw-bold" id="class_name"></h6>
                <ul class="list-group list-group-flush border">
                    <div class=" mb-2" id="myload" style="display: none; border:none">
                        <div class="s-body d-flex justify-content-center align-items-center flex-wrap gap-1">
                            <span class="me-0">
                                <svg id="myloader" xmlns="http://www.w3.org/2000/svg" height="60" width="60" data-name="Layer 1" viewBox="0 0 24 24">
                                    <path fill="#05c3fb" d="M12 1.99951a.99974.99974 0 0 0-1 1v2a1 1 0 1 0 2 0v-2A.99974.99974 0 0 0 12 1.99951zM12 17.99951a.99974.99974 0 0 0-1 1v2a1 1 0 0 0 2 0v-2A.99974.99974 0 0 0 12 17.99951zM21 10.99951H19a1 1 0 0 0 0 2h2a1 1 0 0 0 0-2zM6 11.99951a.99974.99974 0 0 0-1-1H3a1 1 0 0 0 0 2H5A.99974.99974 0 0 0 6 11.99951zM17.19629 8.99951a1.0001 1.0001 0 0 0 .86719.5.99007.99007 0 0 0 .499-.13428l1.73145-1a.99974.99974 0 1 0-1-1.73144l-1.73145 1A.9993.9993 0 0 0 17.19629 8.99951zM6.80371 14.99951a.99936.99936 0 0 0-1.36621-.36572l-1.73145 1a.99974.99974 0 1 0 1 1.73144l1.73145-1A.9993.9993 0 0 0 6.80371 14.99951zM15 6.80371a1.0006 1.0006 0 0 0 1.36621-.36621l1-1.73193a1.00016 1.00016 0 1 0-1.73242-1l-1 1.73193A1 1 0 0 0 15 6.80371zM3.70605 8.36523l1.73145 1a.99007.99007 0 0 0 .499.13428.99977.99977 0 0 0 .501-1.86572l-1.73145-1a.99974.99974 0 1 0-1 1.73144zM9 17.1958a.99946.99946 0 0 0-1.36621.36621l-1 1.73194a1.00016 1.00016 0 0 0 1.73242 1l1-1.73194A1 1 0 0 0 9 17.1958zM20.294 15.63379l-1.73145-1a.99974.99974 0 1 0-1 1.73144l1.73145 1a.99.99 0 0 0 .499.13428.99977.99977 0 0 0 .501-1.86572zM16.36621 17.562a1.00016 1.00016 0 1 0-1.73242 1l1 1.73194a1.00016 1.00016 0 1 0 1.73242-1z"></path>
                                </svg>
                            </span>
                        </div>
                    </div>
                    <div id="data-container">
                        <?php
                        foreach ($classes as $cl) {
                        ?>
                            <a href="<?php echo base_url('qa/trs/post_qa/' . $post->id . '/' . $cl->id . '/' . $this->session->userdata['session_id']) ?>" onclick="return confirm('Are you sure you want to post this assignment for the learners?')">
                                <li class="list-group-item d-flex justify-content-between align-items-center pe-2">
                                    <span class="d-inline-flex align-items-center">
                                        <i class="fe fe-check text-primary me-2" aria-hidden="true"></i><?php echo strtoupper($cl->name); ?></span>
                                    <div class="form-check form-switch</a>">

                                    </div>
                                </li>

                            <?php } ?>
                    </div>

                </ul>
            </div>

        </div>
    </div>
    <!-- Offright Canvas End-->
</div>

<style>
    .card-header {
        display: flex;
        justify-content: space-between;
    }
</style>